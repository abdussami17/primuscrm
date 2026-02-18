<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\EmailAttachment;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
            ->with(['sender', 'attachments']);

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

        // Get users for autocomplete
        $users = User::where('id', '!=', $user->id)
            ->select('id', 'name', 'email')
            ->get();

        return view('emails.inbox', compact(
            'emails',
            'counts',
            'templates',
            'users',
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
        $users = User::where('id', '!=', $user->id)->select('id', 'name', 'email')->get();

        return view('emails.inbox', compact('emails', 'counts', 'templates', 'users'))
            ->with('currentFolder', 'starred');
    }

    /**
     * Display sent emails
     */
    public function sent(Request $request)
    {
        $user = Auth::user();

        $emails = Email::sent($user->id)
            ->with(['user', 'attachments'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $counts = $this->getEmailCounts($user->id);
        $templates = Template::get();
        $users = User::where('id', '!=', $user->id)->select('id', 'name', 'email')->get();

        return view('emails.inbox', compact('emails', 'counts', 'templates', 'users'))
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
        $users = User::where('id', '!=', $user->id)->select('id', 'name', 'email')->get();

        return view('emails.inbox', compact('emails', 'counts', 'templates', 'users'))
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
        $users = User::where('id', '!=', $user->id)->select('id', 'name', 'email')->get();

        return view('emails.inbox', compact('emails', 'counts', 'templates', 'users'))
            ->with('currentFolder', 'deleted');
    }

    /**
     * Show email thread/reply view
     */
    public function show(Email $email)
    {
        $user = Auth::user();

        // Ensure user owns this email
        if ($email->user_id !== $user->id && $email->from_user_id !== $user->id) {
            abort(403);
        }

        // Mark as read
        if (!$email->is_read && $email->user_id === $user->id) {
            $email->update(['is_read' => true]);
        }

        // Get thread emails
        $threadEmails = [];
        if ($email->thread_id) {
            $threadEmails = Email::where('thread_id', $email->thread_id)
                ->with(['sender', 'user', 'attachments'])
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $threadEmails = collect([$email->load(['sender', 'user', 'attachments'])]);
        }

        // Get people in thread
        $peopleInThread = $threadEmails->map(function ($e) {
            return $e->sender ?? $e->user;
        })->unique('id')->values();

        $counts = $this->getEmailCounts($user->id);
        $templates = Template::get();
        $users = User::where('id', '!=', $user->id)->select('id', 'name', 'email')->get();

        return view('emails.reply', compact(
            'email',
            'threadEmails',
            'peopleInThread',
            'counts',
            'templates',
            'users'
        ));
    }

    /**
     * Store a new email (send or save as draft)
     */
    public function store(Request $request)
    {
        $request->validate([
            'to_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',

            'cc' => 'nullable|array',
            'cc.*' => 'nullable|email',

            'bcc' => 'nullable|array',
            'bcc.*' => 'nullable|email',

            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240',

            'is_draft' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:emails,id',
        ]);


        $user = Auth::user();
        $isDraft = $request->boolean('is_draft', false);

        // Find recipient user
        $recipient = User::where('email', $request->to_email)->first();

        DB::beginTransaction();
        try {
            // Determine thread_id
            $threadId = null;
            if ($request->parent_id) {
                $parentEmail = Email::find($request->parent_id);
                $threadId = $parentEmail->thread_id ?? $parentEmail->id;
            }

            // Create email for sender (sent copy)
            $senderEmail = Email::create([
                'user_id' => $user->id,
                'from_user_id' => $user->id,
                'to_email' => $request->to_email,
                'cc' => $request->cc,
                'bcc' => $request->bcc,
                'subject' => $request->subject,
                'body' => $request->body,
                'is_read' => true,
                'is_starred' => false,
                'is_draft' => $isDraft,
                'is_sent' => !$isDraft,
                'parent_id' => $request->parent_id,
                'thread_id' => $threadId,
            ]);

            // If not draft and recipient exists, create email for recipient
            if (!$isDraft && $recipient) {
                $recipientEmail = Email::create([
                    'user_id' => $recipient->id,
                    'from_user_id' => $user->id,
                    'to_email' => $request->to_email,
                    'cc' => $request->cc,
                    'bcc' => $request->bcc,
                    'subject' => $request->subject,
                    'body' => $request->body,
                    'is_read' => false,
                    'is_starred' => false,
                    'is_draft' => false,
                    'is_sent' => false,
                    'parent_id' => $request->parent_id,
                    'thread_id' => $threadId ?? $senderEmail->id,
                ]);

                // Update thread_id if this is the first email
                if (!$threadId) {
                    $senderEmail->update(['thread_id' => $senderEmail->id]);
                    $recipientEmail->update(['thread_id' => $senderEmail->id]);
                }

                // Handle attachments
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $path = $file->store('email-attachments', 'public');

                        // Create attachment for both emails
                        foreach ([$senderEmail, $recipientEmail] as $email) {
                            EmailAttachment::create([
                                'email_id' => $email->id,
                                'filename' => basename($path),
                                'original_filename' => $file->getClientOriginalName(),
                                'file_path' => $path,
                                'file_size' => $file->getSize(),
                                'mime_type' => $file->getMimeType(),
                            ]);
                        }
                    }
                }
            } else {
                // Handle attachments for draft
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $path = $file->store('email-attachments', 'public');
                        EmailAttachment::create([
                            'email_id' => $senderEmail->id,
                            'filename' => basename($path),
                            'original_filename' => $file->getClientOriginalName(),
                            'file_path' => $path,
                            'file_size' => $file->getSize(),
                            'mime_type' => $file->getMimeType(),
                        ]);
                    }
                }
            }

            DB::commit();

            if ($isDraft) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                    ]);
                }
                return redirect()->route('email.drafts')
                    ->with('success', 'Email saved as draft.');
            }

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                ]);
            }
            return redirect()->route('email.inbox')
                ->with('success', 'Email sent successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                ]);
            }
            return back()->with('error', 'Failed to send email. Please try again.');
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
            'email_ids' => 'required|array',
            'email_ids.*' => 'exists:emails,id',
        ]);

        $user = Auth::user();
        $emailIds = $request->email_ids;

        // Only allow deleting own emails or if manager
        $query = Email::whereIn('id', $emailIds);
        // if (!$user->isManager()) {
        //     $query->where('user_id', $user->id);
        // }

        $query->delete();

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
     * Search users for autocomplete
     */
    public function searchUsers(Request $request)
    {
        $search = $request->get('q', '');
        $user = Auth::user();

        $users = User::where('id', '!=', $user->id)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->select('id', 'name', 'email')
            ->limit(10)
            ->get();

        return response()->json($users);
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
