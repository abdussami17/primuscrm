<?php

namespace App\Http\Controllers;

use App\Mail\CrmEmail;
use App\Models\Customer;
use App\Models\Email;
use App\Models\DealershipInfo;
use App\Models\EmailAccount;
use App\Models\EmailAttachment;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    /**
     * Display inbox
     */
    public function inbox(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'date_high');
        $search = $request->get('search');

        $query = Email::inbox($user->id)
            ->with(['sender', 'customer', 'attachments']);

        // Apply search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhereHas('sender', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Apply filter
        if ($filter === 'date_low') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $emails = $query->paginate(20);

        // Get counts
        $counts = $this->getEmailCounts($user->id);

        // Get templates for compose modal
        $templates = Template::get();

        // Get customers for compose autocomplete
        $customers = Customer::whereNotNull('email')
            ->where('email', '!=', '')
            ->select('id', 'first_name', 'last_name', 'email')
            ->orderBy('first_name')
            ->get()
            ->map(fn($c) => [
                'id'    => $c->id,
                'name'  => trim($c->first_name . ' ' . $c->last_name),
                'email' => $c->email,
            ]);

        return view('emails.inbox', compact(
            'emails',
            'counts',
            'templates',
            'customers',
            'filter',
            'search'
        ));
    }

    /**
     * Display starred emails
     */
    public function starred(Request $request)
    {
        $user = Auth::user();

        $emails = Email::starred($user->id)
            ->with(['sender', 'attachments'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $counts = $this->getEmailCounts($user->id);
        $templates = Template::get();
        $customers = Customer::whereNotNull('email')->where('email', '!=', '')->select('id', 'first_name', 'last_name', 'email')->orderBy('first_name')->get()->map(fn($c) => ['id' => $c->id, 'name' => trim($c->first_name . ' ' . $c->last_name), 'email' => $c->email]);

        return view('emails.inbox', compact('emails', 'counts', 'templates', 'customers'))
            ->with('currentFolder', 'starred');
    }

    /**
     * Display sent emails
     */
    public function sent(Request $request)
    {
        $user = Auth::user();

        // Order threads by the latest activity (most recent reply or the email itself)
        $emails = Email::sent($user->id)
            ->with(['user', 'attachments', 'customer'])
            ->withCount('replies')
            ->orderByRaw('COALESCE((SELECT MAX(r.created_at) FROM emails r WHERE r.thread_id = emails.thread_id AND r.deleted_at IS NULL), emails.created_at) DESC')
            ->paginate(20);

        $counts    = $this->getEmailCounts($user->id);
        $templates = Template::get();
        $customers = Customer::whereNotNull('email')->where('email', '!=', '')->select('id', 'first_name', 'last_name', 'email')->orderBy('first_name')->get()->map(fn($c) => ['id' => $c->id, 'name' => trim($c->first_name . ' ' . $c->last_name), 'email' => $c->email]);

        return view('emails.inbox', compact('emails', 'counts', 'templates', 'customers'))
            ->with('currentFolder', 'sent');
    }

    /**
     * Display drafts
     */
    public function drafts(Request $request)
    {
        $user = Auth::user();

        $emails = Email::drafts($user->id)
            ->with(['attachments'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $counts = $this->getEmailCounts($user->id);
        $templates = Template::get();
        $customers = Customer::whereNotNull('email')->where('email', '!=', '')->select('id', 'first_name', 'last_name', 'email')->orderBy('first_name')->get()->map(fn($c) => ['id' => $c->id, 'name' => trim($c->first_name . ' ' . $c->last_name), 'email' => $c->email]);

        return view('emails.inbox', compact('emails', 'counts', 'templates', 'customers'))
            ->with('currentFolder', 'drafts');
    }

    /**
     * Display deleted emails
     */
    public function deleted(Request $request)
    {
        $user = Auth::user();

        $emails = Email::with(['sender', 'attachments'])
            ->orderBy('deleted_at', 'desc')
            ->onlyTrashed()
            ->where(fn($q) => $q->where('user_id', $user->id)
                ->orWhere('from_user_id', $user->id))
            ->paginate(20);

        $counts = $this->getEmailCounts($user->id);
        $templates = Template::get();
        $customers = Customer::whereNotNull('email')->where('email', '!=', '')->select('id', 'first_name', 'last_name', 'email')->orderBy('first_name')->get()->map(fn($c) => ['id' => $c->id, 'name' => trim($c->first_name . ' ' . $c->last_name), 'email' => $c->email]);

        return view('emails.inbox', compact('emails', 'counts', 'templates', 'customers'))
            ->with('currentFolder', 'deleted');
    }

    /**
     * Show email thread/reply view
     */
    public function show(Email $email)
    {
        $user = Auth::user();

        // Ensure user owns this email (inbound replies have user_id = agent, from_user_id = null)
        if ($email->user_id !== $user->id && $email->from_user_id !== $user->id) {
            abort(403);
        }

        // Resolve thread_id — if email has no thread_id yet, use its own id
        $threadId = $email->thread_id ?? $email->id;

        // Load all emails in this thread (sent by CRM + inbound replies from customers)
        $threadEmails = Email::where('thread_id', $threadId)
            ->with(['sender', 'customer', 'user', 'attachments'])
            ->orderBy('created_at', 'asc')
            ->get();

        // If the email itself isn't in the thread (edge case: thread_id not yet set), add it
        if ($threadEmails->isEmpty()) {
            $threadEmails = collect([$email->load(['sender', 'user', 'attachments'])]);
        }

        // Mark all unread emails in the thread as read for this user
        Email::where('thread_id', $threadId)
            ->where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Build participants list — handle inbound emails where from_user_id is null
        $peopleInThread = $threadEmails->map(function ($e) {
            if ($e->sender) {
                return (object)['id' => $e->sender->id, 'name' => $e->sender->name, 'email' => $e->sender->email];
            }
            // Inbound customer email — no User record
            return (object)['id' => 'ext_' . $e->from_email, 'name' => $e->from_email, 'email' => $e->from_email];
        })->unique('id')->values();

        $counts = $this->getEmailCounts($user->id);
        $templates = Template::get();
        $customers = Customer::whereNotNull('email')->where('email', '!=', '')->select('id', 'first_name', 'last_name', 'email')->orderBy('first_name')->get()->map(fn($c) => ['id' => $c->id, 'name' => trim($c->first_name . ' ' . $c->last_name), 'email' => $c->email]);

        // Strip leftover <span class="token"> wrappers from the body before display
        $preview = preg_replace('/<span[^>]*class=["\']token["\'][^>]*>(.*?)<\/span>/is', '$1', $email->body ?? '');

        return view('emails.reply', compact(
            'email',
            'threadEmails',
            'peopleInThread',
            'counts',
            'templates',
            'customers',
            'preview'
        ));
    }

    /**
     * Store a new email (send or save as draft)
     */
    public function store(Request $request)
    {
        $request->validate([
            'to_email'     => 'required|email',
            'subject'      => 'required|string|max:255',
            'body'         => 'required|string',
            'cc'           => 'nullable|array',
            'cc.*'         => 'nullable|email',
            'bcc'          => 'nullable|array',
            'bcc.*'        => 'nullable|email',
            'attachments'  => 'nullable|array',
            'attachments.*'=> 'file|max:10240',
            'is_draft'     => 'nullable|boolean',
            'parent_id'    => 'nullable|exists:emails,id',
        ]);

        $user     = Auth::user();
        $isDraft  = $request->boolean('is_draft', false);

        // Sanitize to_email: accept plain 'email@domain' or 'Name <email@domain>' format
        $rawTo  = trim($request->to_email ?? '');
        if (preg_match('/<([^>]+)>/', $rawTo, $m)) {
            $toEmail = trim($m[1]); // extracted from "Name <email>"
        } else {
            $toEmail = $rawTo;
        }
        if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['success' => false, 'message' => 'Invalid recipient email address: ' . $rawTo], 422);
        }

        // Resolve template tokens in subject / body
        $resolvedBody    = $request->body;
        $resolvedSubject = $request->subject;
        {
            $tokenCustomer = Customer::where('email', $toEmail)->first()
                             ?? ($request->filled('customer_id') ? Customer::find($request->customer_id) : null);
            $dealership    = DealershipInfo::first();

            $firstName   = $tokenCustomer?->first_name ?? '';
            $lastName    = $tokenCustomer?->last_name  ?? '';
            $advisorName = $user->name;
            $dealerName  = $dealership?->name  ?? config('app.name');
            $dealerPhone = $dealership?->phone ?? '';

            // Support both {{ token }} and @{{ token }} formats used by the template builder
            $tokens = [
                '@{{ first_name }}'   => $firstName,
                '@{{ last_name }}'    => $lastName,
                '@{{ advisor_name }}' => $advisorName,
                '@{{ dealer_name }}'  => $dealerName,
                '@{{ dealer_phone }}' => $dealerPhone,
                '{{ first_name }}'    => $firstName,
                '{{ last_name }}'     => $lastName,
                '{{ advisor_name }}'  => $advisorName,
                '{{ dealer_name }}'   => $dealerName,
                '{{ dealer_phone }}'  => $dealerPhone,
            ];
            $resolvedBody    = str_replace(array_keys($tokens), array_values($tokens), $resolvedBody);
            $resolvedSubject = str_replace(array_keys($tokens), array_values($tokens), $resolvedSubject);

            // Strip <span class="token">...</span> wrappers left over from the template editor
            // but keep their inner content intact
            $resolvedBody    = preg_replace('/<span[^>]*class=["\']token["\'][^>]*>(.*?)<\/span>/is', '$1', $resolvedBody);
            $resolvedSubject = preg_replace('/<span[^>]*class=["\']token["\'][^>]*>(.*?)<\/span>/is', '$1', $resolvedSubject);
        }

        // Generate a unique SMTP Message-ID for reply tracking
        $messageId = Str::uuid() . '@' . parse_url(config('app.url'), PHP_URL_HOST);

        // Resolve parent message_id for In-Reply-To header
        $parentMessageId = null;
        $threadId        = null;
        if ($request->parent_id) {
            $parentEmail     = Email::find($request->parent_id);
            $threadId        = $parentEmail->thread_id ?? $parentEmail->id;
            $parentMessageId = $parentEmail->message_id;
        }

        DB::beginTransaction();
        try {
            // Collect uploaded attachment paths first (outside loop)
            $attachmentPaths = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $attachmentPaths[] = $file->store('email-attachments', 'public');
                }
            }

            // Create email record for sender (sent copy)
            $senderEmail = Email::create([
                'user_id'      => $user->id,
                'from_user_id' => $user->id,
                'from_email'   => $user->email,
                'to_email'     => $toEmail,
                'cc'           => $request->cc,
                'bcc'          => $request->bcc,
                'subject'      => $resolvedSubject,
                'body'         => $resolvedBody,
                'is_read'      => true,
                'is_starred'   => false,
                'is_draft'     => $isDraft,
                'is_sent'      => !$isDraft,
                'parent_id'    => $request->parent_id,
                'thread_id'    => $threadId,
                'message_id'   => $messageId,
            ]);

            // Attach stored files to sender record
            foreach ($attachmentPaths as $path) {
                EmailAttachment::create([
                    'email_id'          => $senderEmail->id,
                    'filename'          => basename($path),
                    'original_filename' => basename($path),
                    'file_path'         => $path,
                    'file_size'         => Storage::disk('public')->size($path),
                    'mime_type'         => mime_content_type(Storage::disk('public')->path($path)) ?: 'application/octet-stream',
                ]);
            }

            // Update thread_id if this is a root email
            if (!$threadId) {
                $senderEmail->update(['thread_id' => $senderEmail->id]);
            }

            DB::commit();

            // Send the real SMTP email (not for drafts)
            if (!$isDraft) {
                try {
                    // Load active email account from DB and configure SMTP dynamically
                    $account = EmailAccount::active();

                    if (!$account) {
                        throw new \RuntimeException('No active email account configured. Please set one up in Settings.');
                    }

                    // Override the default SMTP mailer config at runtime
                    Config::set('mail.mailers.smtp', $account->toSmtpConfig());
                    Config::set('mail.from.address', $account->smtp_from);
                    Config::set('mail.from.name', $account->smtp_from_name ?? config('mail.from.name'));

                    // Update sender record with the actual from address
                    $senderEmail->update(['from_email' => $account->smtp_from]);

                    Mail::mailer('smtp')
                        ->to($toEmail)
                        ->send(new CrmEmail(
                            subject:         $resolvedSubject,
                            body:            $resolvedBody,
                            messageId:       $messageId,
                            inReplyTo:       $parentMessageId,
                            cc:              $request->cc ?? [],
                            bcc:             $request->bcc ?? [],
                            attachmentPaths: $attachmentPaths,
                        ));

                } catch (\Exception $mailException) {
                    // Email saved in DB but SMTP failed — log but don't roll back
                    Log::error('SMTP send failed: ' . $mailException->getMessage());
                    if (request()->ajax()) {
                        return response()->json([
                            'success' => true,
                            'warning' => 'Email saved but could not be delivered: ' . $mailException->getMessage(),
                        ]);
                    }
                    return redirect()->route('email.inbox')
                        ->with('warning', 'Email saved but delivery failed: ' . $mailException->getMessage());
                }
            }

            if ($isDraft) {
                if (request()->ajax()) {
                    return response()->json(['success' => true]);
                }
                return redirect()->route('email.drafts')
                    ->with('success', 'Email saved as draft.');
            }

            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }
            return redirect()->route('email.inbox')
                ->with('success', 'Email sent successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    /**
     * Manually trigger IMAP inbound email fetch (also runs on schedule every 2 min).
     */
    public function fetchInbound(): \Illuminate\Http\JsonResponse
    {
        try {
            $beforeCount = \App\Models\Email::count();
            \Illuminate\Support\Facades\Artisan::call('email:fetch-inbound', ['--limit' => 50]);
            $output   = \Illuminate\Support\Facades\Artisan::output();
            $imported = \App\Models\Email::count() - $beforeCount;
            return response()->json(['success' => true, 'imported' => $imported, 'output' => trim($output)]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Toggle star status
     */
    public function toggleStar(Email $email)
    {
        $user = Auth::user();

        if ($email->user_id !== $user->id) {
            abort(403);
        }

        $email->update(['is_starred' => !$email->is_starred]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_starred' => $email->is_starred
            ]);
        }

        return back();
    }

    /**
     * Mark email as read/unread
     */
    public function toggleRead(Email $email)
    {
        $user = Auth::user();

        if ($email->user_id !== $user->id) {
            abort(403);
        }

        $email->update(['is_read' => !$email->is_read]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_read' => $email->is_read
            ]);
        }

        return back();
    }

    /**
     * Delete email (soft delete)
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $email = Email::withTrashed()->findOrFail($id); // load even soft-deleted emails

        // Only allow if the user owns the email or is admin
        if ($email->user_id !== $user->id && !$user->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        if ($email->trashed()) {
            // Permanently delete from database
            $email->forceDelete();
        } else {
            // Soft delete
            $email->delete();
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('email.inbox')
            ->with('success', 'Email deleted successfully.');
    }
        /**
     * Bulk delete emails
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'email_ids'   => 'required|array',
            'email_ids.*' => 'integer',
        ]);

        $user = Auth::user();
        $emailIds = $request->email_ids;

        $emails = Email::withTrashed()->whereIn('id', $emailIds)->get();

        foreach ($emails as $email) {
            if ($email->trashed()) {
                $email->forceDelete();
            } else {
                $email->delete();
            }
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Emails deleted successfully.');
    }

    /**
     * Restore deleted email
     */
    public function restore($id)
    {
        $user = Auth::user();
        $email = Email::onlyTrashed()->findOrFail($id);

        if ($email->user_id !== $user->id && $email->from_user_id !== $user->id) {
            abort(403);
        }

        $email->restore();


        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Email restored successfully.');
    }

    /**
     * Permanently delete email
     */
    public function forceDelete($id)
    {
        $user = Auth::user();
        $email = Email::onlyTrashed()->findOrFail($id);

        if ($email->user_id !== $user->id && !$user->hasRole('admin')) {
            abort(403);
        }

        // Delete attachments
        foreach ($email->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }

        $email->forceDelete();

        return back()->with('success', 'Email permanently deleted.');
    }

    /**
     * Search customers for compose autocomplete
     */
    public function searchUsers(Request $request)
    {
        $search = $request->get('q', '');

        $customers = Customer::whereNotNull('email')
            ->where('email', '!=', '')
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->select('id', 'first_name', 'last_name', 'email')
            ->limit(10)
            ->get()
            ->map(fn($c) => [
                'id'    => $c->id,
                'name'  => trim($c->first_name . ' ' . $c->last_name),
                'email' => $c->email,
            ]);

        return response()->json($customers);
    }

    /**
     * Get email template
     */
    public function getTemplate(Template $template)
    {
        $user = Auth::user();

        if (!$template->is_global && $template->user_id !== $user->id) {
            abort(403);
        }

        return response()->json([
            'subject' => $template->subject,
            'body' => $template->body,
        ]);
    }

    /**
     * Download attachment
     */
    public function downloadAttachment(EmailAttachment $attachment)
    {
        $user = Auth::user();
        $email = $attachment->email;

        if ($email->user_id !== $user->id && $email->from_user_id !== $user->id) {
            abort(403);
        }

        return Storage::disk('public')->download(
            $attachment->file_path,
            $attachment->original_filename
        );
    }

    /**
     * Get email counts for sidebar
     */
    private function getEmailCounts($userId)
    {
        if (!$userId) {
            $userId = Auth::user()->id;
        }

        $deleted = Email::onlyTrashed()
            ->where(fn($q) => $q->where('user_id', $userId)
                ->orWhere('from_user_id', $userId));

        return [
            'inbox' => Email::inbox($userId)->count(),
            'unread' => Email::inbox($userId)->unread()->count(),
            'starred' => Email::starred($userId)->count(),
            'sent' => Email::sent($userId)->count(),
            'drafts' => Email::drafts($userId)->count(),
            'deleted' => $deleted->count(),
        ];
    }

    public function liveEmailCounts()
    {
        $userId = Auth::user()->id;


        $deleted = Email::onlyTrashed()
            ->where(fn($q) => $q->where('user_id', $userId)
                ->orWhere('from_user_id', $userId));

        return response()->json([
            'inbox' => Email::inbox($userId)->count(),
            'unread' => Email::inbox($userId)->unread()->count(),
            'starred' => Email::starred($userId)->count(),
            'sent' => Email::sent($userId)->count(),
            'drafts' => Email::drafts($userId)->count(),
            'deleted' => $deleted->count(),
        ]);
    }
}
