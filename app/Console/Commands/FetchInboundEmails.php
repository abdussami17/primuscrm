<?php

namespace App\Console\Commands;

use App\Models\Email;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchInboundEmails extends Command
{
    protected $signature   = 'email:fetch-inbound {--limit=50 : Max emails to process per run}';
    protected $description = 'Poll the IMAP inbox for customer replies and store them in the CRM';

    public function handle(): int
    {
        if (!function_exists('imap_open')) {
            $this->error('PHP IMAP extension (ext-imap) is not installed or enabled.');
            return self::FAILURE;
        }

        $account = \App\Models\EmailAccount::active();

        if (!$account) {
            $this->error('No active email account found. Configure one in Settings → Email Account.');
            return self::FAILURE;
        }

        // Auto-derive IMAP host from SMTP host if not set (smtp.X.com → imap.X.com)
        $imapHost = $account->imap_host;
        if (!$imapHost && $account->smtp_host) {
            $imapHost = preg_replace('/^smtp\./', 'imap.', $account->smtp_host);
            $this->warn("No IMAP host configured — derived: {$imapHost} (set it in Settings to suppress this)");
        }
        if (!$imapHost) {
            $this->error("Email account \"{$account->name}\" has no IMAP host configured.");
            return self::FAILURE;
        }

        $username = $account->imap_username ?: $account->smtp_user;
        $password = $account->imap_password ?: $account->smtp_pass;
        $limit    = (int) $this->option('limit');

        $dsn = $account->toImapDsn($imapHost);

        $this->info("Connecting to {$imapHost}:{$account->imap_port} as {$username}…");

        $connection = @imap_open($dsn, $username, $password, 0, 1, ['DISABLE_AUTHENTICATOR' => 'GSSAPI']);

        if (!$connection) {
            $error = imap_last_error();
            $this->error("IMAP connection failed: {$error}");
            Log::error("FetchInboundEmails: IMAP connection failed: {$error}");
            return self::FAILURE;
        }

        $this->info('Connected. Searching for unread messages…');

        // Search all messages — deduplication is handled by imap_uid in the DB
        $messageIds = imap_search($connection, 'ALL', SE_UID);

        if (!$messageIds) {
            $this->info('No new messages found.');
            imap_close($connection);
            return self::SUCCESS;
        }

        // Sort newest first and respect limit
        rsort($messageIds);
        $messageIds = array_slice($messageIds, 0, $limit);

        $imported = 0;
        $skipped  = 0;

        foreach ($messageIds as $uid) {
            try {
                // Skip already imported UIDs
                if (Email::where('imap_uid', $uid)->exists()) {
                    $skipped++;
                    continue;
                }

                // Fetch headers
                $rawHeaders = imap_fetchheader($connection, $uid, FT_UID);
                $headerObj  = imap_rfc822_parse_headers($rawHeaders);

                $fromAddress = $this->extractAddress($headerObj->from[0] ?? null);
                $fromName    = $this->extractName($headerObj->from[0]    ?? null);
                $subject     = isset($headerObj->subject)
                    ? imap_utf8($headerObj->subject)
                    : '(no subject)';
                $date        = isset($headerObj->date)
                    ? date('Y-m-d H:i:s', strtotime($headerObj->date))
                    : now()->toDateTimeString();

                // Determine which sent email this is a reply to
                $inReplyTo = $this->parseMessageRef($rawHeaders, 'In-Reply-To');
                $references = $this->parseMessageRef($rawHeaders, 'References');
                $xCrmId     = $this->parseHeaderValue($rawHeaders, 'X-CRM-Email-ID');

                $parentEmail = null;

                // Match by In-Reply-To or X-CRM-Email-ID header
                foreach (array_filter([$inReplyTo, $references, $xCrmId]) as $ref) {
                    $clean = trim($ref, '<>');
                    $parentEmail = Email::where('message_id', $clean)
                        ->orWhere('message_id', '<' . $clean . '>')
                        ->first();
                    if ($parentEmail) break;
                }

                // If no match, try subject-based matching (strip Re:/Fwd: prefixes)
                if (!$parentEmail) {
                    $cleanSubject = preg_replace('/^(Re:\s*|Fwd?:\s*)+/i', '', $subject);
                    $parentEmail  = Email::where('is_sent', true)
                        ->whereRaw("LOWER(TRIM(LEADING 'Re: ' FROM LOWER(subject))) = ?", [strtolower($cleanSubject)])
                        ->latest()
                        ->first();
                }

                // If still no match, skip (not a CRM-related email)
                if (!$parentEmail) {
                    $this->line("  Skip UID {$uid} — no matching sent email for subject: {$subject}");
                    // Mark as seen so we don't process it again on next run
                    imap_setflag_full($connection, (string)$uid, '\\Seen', ST_UID);
                    $skipped++;
                    continue;
                }

                // Fetch body
                $body = $this->fetchBody($connection, $uid);

                // Create inbound Email record
                $newEmail = Email::create([
                    'user_id'      => $parentEmail->user_id,   // assign to original sender (CRM agent)
                    'from_user_id' => null,                     // customer has no User record
                    'from_email'   => $fromAddress,
                    'to_email'     => $account->smtp_from ?? $username,
                    'subject'      => $subject,
                    'body'         => $body,
                    'is_read'      => false,
                    'is_starred'   => false,
                    'is_draft'     => false,
                    'is_sent'      => false,
                    'parent_id'    => $parentEmail->id,
                    'thread_id'    => $parentEmail->thread_id ?? $parentEmail->id,
                    'imap_uid'     => $uid,
                    'created_at'   => $date,
                    'updated_at'   => $date,
                ]);

                // Mark the Gmail message as seen
                imap_setflag_full($connection, (string)$uid, '\\Seen', ST_UID);

                $this->info("  Imported UID {$uid} from {$fromAddress}: {$subject}");
                Log::info("FetchInboundEmails: imported UID {$uid} from {$fromAddress}, email_id={$newEmail->id}");
                $imported++;

            } catch (\Throwable $e) {
                $this->error("  Error processing UID {$uid}: {$e->getMessage()}");
                Log::error("FetchInboundEmails: error on UID {$uid}: " . $e->getMessage());
            }
        }

        imap_close($connection);

        $this->info("Done. Imported: {$imported} | Skipped: {$skipped}");
        return self::SUCCESS;
    }

    // ─── Helpers ────────────────────────────────────────────────────────────────

    private function fetchBody($connection, int $uid): string
    {
        $structure = imap_fetchstructure($connection, $uid, FT_UID);

        // Multipart — find the best text part
        if (isset($structure->parts) && count($structure->parts)) {
            return $this->getBodyFromParts($connection, $uid, $structure->parts, '');
        }

        // Single-part
        $encoding = $structure->encoding ?? 0;
        $raw      = imap_body($connection, $uid, FT_UID | FT_PEEK);
        return $this->decodeBody($raw, $encoding);
    }

    private function getBodyFromParts($connection, int $uid, array $parts, string $prefix): string
    {
        $html  = '';
        $plain = '';

        foreach ($parts as $i => $part) {
            $partNum = $prefix === '' ? (string)($i + 1) : $prefix . '.' . ($i + 1);

            if (isset($part->parts)) {
                $nested = $this->getBodyFromParts($connection, $uid, $part->parts, $partNum);
                if ($nested) $html = $nested;
                continue;
            }

            $subtype  = strtolower($part->subtype ?? '');
            $encoding = $part->encoding ?? 0;
            $raw      = imap_fetchbody($connection, $uid, $partNum, FT_UID | FT_PEEK);
            $decoded  = $this->decodeBody($raw, $encoding);

            // Detect charset and convert to UTF-8
            $charset = 'UTF-8';
            if (!empty($part->parameters)) {
                foreach ($part->parameters as $p) {
                    if (strtolower($p->attribute) === 'charset') {
                        $charset = strtoupper($p->value);
                        break;
                    }
                }
            }
            if ($charset !== 'UTF-8') {
                $decoded = mb_convert_encoding($decoded, 'UTF-8', $charset);
            }

            if ($subtype === 'html')  $html  = $decoded;
            if ($subtype === 'plain') $plain = $decoded;
        }

        // Prefer HTML, fall back to plain text
        $body = $html ? $this->htmlToPlain($html) : $plain;

        // Strip the quoted original message that mail clients (Gmail etc.) append
        return $this->stripQuotedReply($body);
    }

    /**
     * Convert HTML email body to clean plain text.
     */
    private function htmlToPlain(string $html): string
    {
        // Replace block-level tags with newlines before stripping
        $html = preg_replace('/<br\s*\/?>/i', "\n", $html);
        $html = preg_replace('/<\/?(p|div|blockquote|tr)[^>]*>/i', "\n", $html);
        $html = strip_tags($html);
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        // Collapse excessive blank lines
        $html = preg_replace("/\n{3,}/", "\n\n", $html);
        return trim($html);
    }

    /**
     * Strip the quoted reply chain that email clients append.
     */
    private function stripQuotedReply(string $body): string
    {
        // Normalize line endings
        $body = str_replace("\r\n", "\n", $body);

        // Remove signature blocks (-- \n ...)
        $body = preg_replace('/\n-- \n.*/s', '', $body);

        // Remove Gmail English quote: "On Date, Name <email> wrote:"
        $body = preg_replace('/\n?On\s+.{5,200}\s+wrote:\s*$/ms', '', $body);

        // Remove Gmail Arabic/RTL quote block: starts with RTL embedding character ‫
        // Gmail wraps Arabic date lines in \u202B...\u202C RTL markers
        $body = preg_replace('/\n?\x{202B}.*$/us', '', $body);
        $body = preg_replace('/\n?‫.*/s', '', $body);

        // Remove any remaining Primus CRM template content (the quoted original HTML)
        $body = preg_replace('/\n?Primus CRM\s*\n.*/s', '', $body);

        // Remove lines starting with > (standard quoted lines)
        $lines = explode("\n", $body);
        $clean = array_filter($lines, fn($line) => !str_starts_with(ltrim($line), '>'));

        // Trim trailing blank lines
        return trim(implode("\n", $clean));
    }

    /**
     * Decode IMAP body part.
     * IMAP encoding constants: 0=7BIT, 1=8BIT, 2=BINARY, 3=BASE64, 4=QUOTED-PRINTABLE
     */
    private function decodeBody(string $raw, int $encoding): string
    {
        return match ($encoding) {
            3  => base64_decode(str_replace(["\r\n", "\n", "\r"], '', $raw)), // Base64
            4  => quoted_printable_decode($raw),                               // Quoted-Printable
            default => $raw,
        };
    }

    private function extractAddress(?object $addr): string
    {
        if (!$addr) return '';
        $mailbox = $addr->mailbox ?? '';
        $host    = $addr->host    ?? '';
        return $mailbox && $host ? "{$mailbox}@{$host}" : '';
    }

    private function extractName(?object $addr): string
    {
        if (!$addr) return '';
        return isset($addr->personal) ? imap_utf8($addr->personal) : '';
    }

    private function parseMessageRef(string $rawHeaders, string $headerName): ?string
    {
        if (preg_match('/^' . preg_quote($headerName, '/') . ':\s*(.+)$/mi', $rawHeaders, $m)) {
            // References may have multiple — take last one
            $refs = preg_split('/\s+/', trim($m[1]));
            return trim(end($refs), '<>');
        }
        return null;
    }

    private function parseHeaderValue(string $rawHeaders, string $headerName): ?string
    {
        if (preg_match('/^' . preg_quote($headerName, '/') . ':\s*(.+)$/mi', $rawHeaders, $m)) {
            return trim($m[1]);
        }
        return null;
    }
}
