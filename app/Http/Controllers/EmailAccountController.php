<?php

namespace App\Http\Controllers;

use App\Mail\CrmEmail;
use App\Models\EmailAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailAccountController extends Controller
{
    /**
     * GET /settings/email-account/data
     */
    public function show(): JsonResponse
    {
        $account = EmailAccount::active() ?? new EmailAccount();

        return response()->json([
            'success'          => true,
            'data' => [
                'id'               => $account->id,
                'name'             => $account->name,
                'smtp_host'        => $account->smtp_host,
                'smtp_port'        => $account->smtp_port,
                'smtp_user'        => $account->smtp_user,
                'smtp_pass'        => $account->exists && $account->smtp_pass ? '••••••••' : '',
                'smtp_enc'         => $account->smtp_enc ?? 'tls',
                'smtp_from'        => $account->smtp_from,
                'smtp_from_name'   => $account->smtp_from_name,
                'imap_host'        => $account->imap_host,
                'imap_port'        => $account->imap_port ?? 993,
                'imap_encryption'  => $account->imap_encryption ?? 'ssl',
                'imap_username'    => $account->imap_username,
                'imap_password'    => $account->exists && $account->imap_password ? '••••••••' : '',
                'imap_mailbox'     => $account->imap_mailbox ?? 'INBOX',
                'is_active'        => $account->is_active ?? true,
            ],
        ]);
    }

    /**
     * POST /settings/email-account/update
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'smtp_host'       => 'required|string|max:255',
            'smtp_port'       => 'required|integer|min:1|max:65535',
            'smtp_user'       => 'required|string|max:255',
            'smtp_pass'       => 'nullable|string|max:500',
            'smtp_enc'        => 'nullable|string|in:tls,ssl,none',
            'smtp_from'       => 'required|email|max:255',
            'smtp_from_name'  => 'nullable|string|max:120',
            'name'            => 'nullable|string|max:120',
            'imap_host'       => 'nullable|string|max:255',
            'imap_port'       => 'nullable|integer|min:1|max:65535',
            'imap_encryption' => 'nullable|string|in:ssl,tls,none',
            'imap_username'   => 'nullable|string|max:255',
            'imap_password'   => 'nullable|string|max:500',
            'imap_mailbox'    => 'nullable|string|max:120',
        ]);

        $account = EmailAccount::active() ?? new EmailAccount(['is_active' => true]);

        // Map any legacy field aliases
        $fill = [
            'name'            => $request->input('name'),
            'smtp_host'       => $request->input('smtp_host', $request->input('host')),
            'smtp_port'       => $request->input('smtp_port', $request->input('port')),
            'smtp_user'       => $request->input('smtp_user', $request->input('username')),
            'smtp_enc'        => $request->input('smtp_enc', $request->input('encryption', 'tls')),
            'smtp_from'       => $request->input('smtp_from'),
            'smtp_from_name'  => $request->input('smtp_from_name', $request->input('from_name')),
            'imap_host'       => $request->input('imap_host'),
            'imap_port'       => $request->input('imap_port', 993),
            'imap_encryption' => $request->input('imap_encryption', 'ssl'),
            'imap_username'   => $request->input('imap_username'),
            'imap_mailbox'    => $request->input('imap_mailbox', 'INBOX'),
        ];

        // Only update password fields when a real value is submitted
        $smtpPass = $request->input('smtp_pass');
        if ($smtpPass && $smtpPass !== '••••••••') {
            $fill['smtp_pass'] = str_replace(' ', '', $smtpPass); // strip spaces from app passwords
        }

        $imapPass = $request->input('imap_password');
        if ($imapPass && $imapPass !== '••••••••') {
            $fill['imap_password'] = $imapPass;
        }

        $account->fill(array_filter($fill, fn($v) => !is_null($v)));
        $account->save();

        return response()->json(['success' => true, 'message' => 'Email account saved successfully.']);
    }

    /**
     * GET /settings/email-account/test
     * Sends a test email using the saved SMTP settings.
     */
    public function test(Request $request): JsonResponse
    {
        $account = EmailAccount::active();

        if (!$account) {
            return response()->json(['success' => false, 'message' => 'No email account configured.'], 422);
        }

        try {
            config(['mail.mailers.smtp'  => $account->toSmtpConfig()]);
            config(['mail.from.address' => $account->smtp_from]);
            config(['mail.from.name'    => $account->smtp_from_name ?? 'Primus CRM']);

            Mail::mailer('smtp')
                ->to($account->smtp_from)
                ->send(new CrmEmail(
                    subject:    'Primus CRM — SMTP Test',
                    body:       'This is an automated test email confirming your SMTP settings are working correctly.',
                    messageId:  'test-' . Str::uuid() . '@primuscrm',
                ));

            return response()->json(['success' => true, 'message' => 'Test email sent to ' . $account->smtp_from]);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}


