<?php

namespace App\Jobs;

use App\Mail\CrmEmail;
use App\Models\Customer;
use App\Models\DealershipInfo;
use App\Models\SequenceAction;
use App\Models\SequenceExecutionLog;
use App\Models\SmartSequence;
use App\Models\Task;
use App\Models\TelnyxMessage;
use App\Models\Template;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessSmartSequenceActionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(
        protected int $executionLogId
    ) {
        $this->onQueue('smart-sequences');
    }

    public function handle(): void
    {
        $log = SequenceExecutionLog::with(['sequence', 'action'])->find($this->executionLogId);

        if (!$log) {
            Log::warning("SmartSequence: Execution log #{$this->executionLogId} not found");
            return;
        }

        // Skip if not pending
        if ($log->status !== SequenceExecutionLog::STATUS_PENDING) {
            return;
        }

        // Skip if not yet due
        if ($log->scheduled_at && $log->scheduled_at->isFuture()) {
            return;
        }

        // Mark as processing
        $log->markAsProcessing();

        $customer = Customer::with(['assignedUser', 'assignedManagerUser', 'bdcAgentUser', 'secondaryAssignedUser', 'deals', 'emails'])->find($log->lead_id);
        $action = $log->action;
        $sequence = $log->sequence;

        if (!$customer || !$action || !$sequence) {
            $log->markAsFailed('Missing customer, action, or sequence');
            return;
        }

        // Check sequence is still active
        if (!$sequence->is_active) {
            $log->markAsCancelled();
            return;
        }

        try {
            $result = $this->executeAction($action, $customer, $sequence);
            $log->markAsCompleted($result);

            // Update sequence stats
            $this->updateSequenceStats($sequence, $action);

        } catch (\Throwable $e) {
            Log::error("SmartSequence: Action execution failed", [
                'log_id' => $log->id,
                'action_type' => $action->action_type,
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
            ]);

            $log->markAsFailed($e->getMessage());
        }
    }

    /**
     * Execute the action based on its type.
     */
    protected function executeAction(SequenceAction $action, Customer $customer, SmartSequence $sequence): array
    {
        return match ($action->action_type) {
            SequenceAction::TYPE_TASK            => $this->executeTask($action, $customer),
            SequenceAction::TYPE_EMAIL           => $this->executeEmail($action, $customer, $sequence),
            SequenceAction::TYPE_TEXT            => $this->executeText($action, $customer, $sequence),
            SequenceAction::TYPE_NOTIFY          => $this->executeNotify($action, $customer),
            SequenceAction::TYPE_AI_DRAFT_EMAIL,
            SequenceAction::TYPE_AI_DRAFT_TEXT   => $this->executeAiDraft($action, $customer),
            SequenceAction::TYPE_CHANGE_SALES_STATUS   => $this->changeSalesStatus($action, $customer),
            SequenceAction::TYPE_CHANGE_LEAD_STATUS     => $this->changeLeadStatus($action, $customer),
            SequenceAction::TYPE_CHANGE_STATUS_TYPE     => $this->changeStatusType($action, $customer),
            SequenceAction::TYPE_CHANGE_LEAD_TYPE       => $this->changeLeadType($action, $customer),
            SequenceAction::TYPE_CHANGE_STATUS_LOST     => $this->changeStatusLost($action, $customer),
            SequenceAction::TYPE_CHANGE_ASSIGNED_TO     => $this->changeUserField($action, $customer, 'assigned_to'),
            SequenceAction::TYPE_CHANGE_ASSIGNED_MANAGER => $this->changeUserField($action, $customer, 'assigned_manager'),
            SequenceAction::TYPE_CHANGE_BDC_AGENT       => $this->changeUserField($action, $customer, 'bdc_agent'),
            SequenceAction::TYPE_CHANGE_FINANCE_MANAGER  => $this->changeUserField($action, $customer, 'finance_manager'),
            SequenceAction::TYPE_CHANGE_SECONDARY_ASSIGNED => $this->changeUserField($action, $customer, 'secondary_assigned'),
            SequenceAction::TYPE_REASSIGN_LEAD          => $this->changeUserField($action, $customer, 'assigned_to'),
            default => throw new \RuntimeException("Unknown action type: {$action->action_type}"),
        };
    }

    /**
     * Create a task for the customer.
     */
    protected function executeTask(SequenceAction $action, Customer $customer): array
    {
        $params = $action->parameters ?? [];
        $assignedTo = $this->resolveUser($params['assigned_to'] ?? null, $customer);
        $fallback = $this->resolveUser($params['fallback'] ?? null, $customer);

        $assignedUserId = $assignedTo?->id ?? $fallback?->id;

        $task = Task::create([
            'customer_id' => $customer->id,
            'deal_id'     => $customer->deals->first()?->id,
            'assigned_to' => $assignedUserId,
            'task_type'   => $params['task_type'] ?? 'Other',
            'status_type' => 'Open',
            'priority'    => 'High',
            'description' => $params['description'] ?? "Auto-generated by Smart Sequence",
            'due_date'    => now(),
            'created_by'  => $action->sequence?->created_by,
        ]);

        return [
            'task_id' => $task->id,
            'assigned_to' => $assignedUserId,
            'task_type' => $params['task_type'] ?? 'Other',
        ];
    }

    /**
     * Send an automated email to the customer.
     */
    protected function executeEmail(SequenceAction $action, Customer $customer, SmartSequence $sequence): array
    {
        $params = $action->parameters ?? [];
        $templateId = $params['template'] ?? null;
        $template = $templateId ? Template::find($templateId) : null;

        if (!$template) {
            throw new \RuntimeException("Email template not found (ID: {$templateId})");
        }

        $toEmail = $customer->primary_email ?? $customer->email;
        if (!$toEmail) {
            throw new \RuntimeException("Customer #{$customer->id} has no email address");
        }

        // Resolve "from" user
        $fromUser = $this->resolveUser($params['from_address'] ?? null, $customer);
        $fallbackUser = $this->resolveUser($params['fallback'] ?? null, $customer);
        $sender = $fromUser ?? $fallbackUser;

        // Build merge data
        $mergeData = $this->buildMergeData($customer, $sender);
        $body = $this->replaceMergeFields($template->body ?? '', $mergeData);
        $subject = $this->replaceMergeFields($template->subject ?? 'Message from Your Dealership', $mergeData);

        // Generate a unique message ID
        $messageId = uniqid('seq-') . '@' . config('app.url', 'primuscrm.local');

        // Configure sender email if available
        $fromEmail = null;
        $fromName = null;
        if ($sender) {
            $fromEmail = $sender->email;
            $fromName = $sender->name;
        }

        // Send using CrmEmail mailable
        $mailable = new CrmEmail($subject, $body, $messageId);

        if ($fromEmail) {
            $mailable->from($fromEmail, $fromName);
        }

        Mail::to($toEmail)->send($mailable);

        // Update sequence stats
        $sequence->incrementStat('sent_count');

        return [
            'template_id' => $templateId,
            'to' => $toEmail,
            'from' => $fromEmail,
            'subject' => $subject,
            'message_id' => $messageId,
        ];
    }

    /**
     * Send an automated text/SMS to the customer.
     */
    protected function executeText(SequenceAction $action, Customer $customer, SmartSequence $sequence): array
    {
        $params = $action->parameters ?? [];
        $templateId = $params['template'] ?? null;
        $template = $templateId ? Template::find($templateId) : null;

        if (!$template) {
            throw new \RuntimeException("Text template not found (ID: {$templateId})");
        }

        $phone = $customer->cell_phone ?? $customer->phone ?? $customer->work_phone;
        if (!$phone) {
            throw new \RuntimeException("Customer #{$customer->id} has no phone number");
        }

        // Resolve sender
        $fromUser = $this->resolveUser($params['from_address'] ?? null, $customer);
        $fallbackUser = $this->resolveUser($params['fallback'] ?? null, $customer);
        $sender = $fromUser ?? $fallbackUser;

        // Build merge data and replace tokens
        $mergeData = $this->buildMergeData($customer, $sender);
        $messageText = $this->replaceMergeFields($template->body ?? '', $mergeData);
        // Strip HTML tags for SMS
        $messageText = strip_tags($messageText);

        // Send via Telnyx
        $apiKey = config('services.telnyx.api_key');
        $from = preg_replace('/[\s\-().]+/', '', config('services.telnyx.from_number') ?? '');

        if (empty($apiKey) || empty($from)) {
            // Simulate if not configured
            Log::info('SmartSequence: SMS simulated (Telnyx not configured)', [
                'customer_id' => $customer->id,
                'phone' => $phone,
            ]);

            try {
                TelnyxMessage::create([
                    'telnyx_id' => 'seq-simulated-' . time() . '-' . $customer->id,
                    'direction' => 'outbound',
                    'type' => 'sms',
                    'from' => $from ?: 'simulated',
                    'to' => $phone,
                    'body' => $messageText,
                    'status' => 'simulated',
                    'raw' => ['simulated' => true, 'source' => 'smart_sequence', 'sequence_id' => $action->smart_sequence_id],
                ]);
            } catch (\Throwable $e) {
                Log::warning('SmartSequence: simulated SMS save failed: ' . $e->getMessage());
            }

            $sequence->incrementStat('sent_count');

            return [
                'template_id' => $templateId,
                'to' => $phone,
                'simulated' => true,
            ];
        }

        // Normalize phone number
        $normalizedPhone = $this->normalizePhone($phone);

        $response = Http::withToken($apiKey)
            ->post('https://api.telnyx.com/v2/messages', [
                'from' => $from,
                'to' => $normalizedPhone,
                'text' => $messageText,
            ]);

        // Save message
        try {
            TelnyxMessage::create([
                'telnyx_id' => $response->json('data.id') ?? null,
                'direction' => 'outbound',
                'type' => 'sms',
                'from' => $from,
                'to' => $normalizedPhone,
                'body' => $messageText,
                'status' => $response->json('data.state') ?? (string) $response->status(),
                'raw' => array_merge($response->json() ?? [], [
                    'source' => 'smart_sequence',
                    'sequence_id' => $action->smart_sequence_id,
                ]),
            ]);
        } catch (\Throwable $e) {
            Log::warning('SmartSequence: SMS save failed: ' . $e->getMessage());
        }

        if (!$response->successful()) {
            throw new \RuntimeException("Telnyx SMS failed: " . $response->body());
        }

        $sequence->incrementStat('sent_count');

        return [
            'template_id' => $templateId,
            'to' => $normalizedPhone,
            'telnyx_id' => $response->json('data.id'),
        ];
    }

    /**
     * Send a notification to a user.
     */
    protected function executeNotify(SequenceAction $action, Customer $customer): array
    {
        $params = $action->parameters ?? [];
        $userId = $params['user'] ?? null;
        $message = $params['message'] ?? "Smart Sequence notification for {$customer->full_name}";

        $user = $this->resolveUser($userId, $customer);

        if (!$user) {
            throw new \RuntimeException("Notification user not found");
        }

        // Use Laravel's notification system if available, otherwise create a task as a workaround
        // Since there's no formal notification system, we create a task for the user
        Task::create([
            'customer_id' => $customer->id,
            'deal_id'     => $customer->deals->first()?->id,
            'assigned_to' => $user->id,
            'task_type'   => 'Other',
            'status_type' => 'Open',
            'priority'    => 'High',
            'description' => "[Notification] {$message}",
            'due_date'    => now(),
            'created_by'  => $action->sequence?->created_by,
        ]);

        return [
            'notified_user_id' => $user->id,
            'message' => $message,
        ];
    }

    /**
     * Create an AI draft task (placeholder - creates a task for the assigned user).
     */
    protected function executeAiDraft(SequenceAction $action, Customer $customer): array
    {
        $params = $action->parameters ?? [];
        $assignedTo = $this->resolveUser($params['assigned_to'] ?? null, $customer);
        $fallback = $this->resolveUser($params['fallback'] ?? null, $customer);
        $assignedUserId = $assignedTo?->id ?? $fallback?->id;

        $taskType = $params['task_type'] ?? 'Other';
        $draftType = $action->action_type === SequenceAction::TYPE_AI_DRAFT_EMAIL ? 'Email' : 'Text';

        $task = Task::create([
            'customer_id' => $customer->id,
            'deal_id'     => $customer->deals->first()?->id,
            'assigned_to' => $assignedUserId,
            'task_type'   => $taskType,
            'status_type' => 'Open',
            'priority'    => 'High',
            'description' => "[AI Draft {$draftType}] Review and send {$draftType} to {$customer->full_name}",
            'due_date'    => now(),
            'created_by'  => $action->sequence?->created_by,
        ]);

        return [
            'task_id' => $task->id,
            'draft_type' => $draftType,
            'assigned_to' => $assignedUserId,
        ];
    }

    /**
     * Change the sales status on the customer's most recent deal.
     */
    protected function changeSalesStatus(SequenceAction $action, Customer $customer): array
    {
        $status = $action->getParameter('status');
        $deal = $customer->deals()->latest()->first();

        if ($deal) {
            $deal->update(['sales_status' => $status]);
        }

        return ['deal_id' => $deal?->id, 'new_sales_status' => $status];
    }

    /**
     * Change the lead status (customer status).
     */
    protected function changeLeadStatus(SequenceAction $action, Customer $customer): array
    {
        $status = $action->getParameter('status');
        $customer->update(['status' => $status]);

        return ['customer_id' => $customer->id, 'new_lead_status' => $status];
    }

    /**
     * Change the status type on the customer's most recent deal.
     */
    protected function changeStatusType(SequenceAction $action, Customer $customer): array
    {
        $status = $action->getParameter('status');
        $deal = $customer->deals()->latest()->first();

        if ($deal) {
            $deal->update(['status' => $status]);
        }

        return ['deal_id' => $deal?->id, 'new_status_type' => $status];
    }

    /**
     * Change the lead type on the customer's most recent deal.
     */
    protected function changeLeadType(SequenceAction $action, Customer $customer): array
    {
        $status = $action->getParameter('status');
        $deal = $customer->deals()->latest()->first();

        if ($deal) {
            $deal->update(['lead_type' => $status]);
        }

        return ['deal_id' => $deal?->id, 'new_lead_type' => $status];
    }

    /**
     * Change status to Lost with a reason.
     */
    protected function changeStatusLost(SequenceAction $action, Customer $customer): array
    {
        $lostReason = $action->getParameter('lost_reason');

        $customer->update(['status' => 'Lost']);

        $deal = $customer->deals()->latest()->first();
        if ($deal) {
            $deal->update([
                'sales_status' => 'Lost',
                'notes' => ($deal->notes ? $deal->notes . "\n" : '') . "Lost Reason: {$lostReason} (Smart Sequence)",
            ]);
        }

        return [
            'customer_id' => $customer->id,
            'lost_reason' => $lostReason,
        ];
    }

    /**
     * Change a user-field on the customer (assigned_to, bdc_agent, etc.).
     */
    protected function changeUserField(SequenceAction $action, Customer $customer, string $field): array
    {
        $userId = $action->getParameter('user');

        if ($userId && is_numeric($userId)) {
            $customer->update([$field => $userId]);
        }

        return [
            'customer_id' => $customer->id,
            'field' => $field,
            'new_user_id' => $userId,
        ];
    }

    /**
     * Resolve a user reference to a User model.
     * Handles special strings like 'assigned_to', 'bdc_agent', role:RoleName, or a user ID.
     */
    protected function resolveUser($reference, Customer $customer): ?User
    {
        if (empty($reference)) {
            return null;
        }

        // Special references mapped to customer fields
        return match ($reference) {
            'assigned_to'        => $customer->assignedUser,
            'secondary_assigned' => $customer->secondaryAssignedUser,
            'assigned_manager'   => $customer->assignedManagerUser,
            'bdc_agent'          => $customer->bdcAgentUser,
            'finance_manager'    => $customer->finance_manager ? User::find($customer->finance_manager) : null,
            default              => $this->resolveUserFromIdOrRole($reference),
        };
    }

    /**
     * Resolve user from a numeric ID or role:RoleName string.
     */
    protected function resolveUserFromIdOrRole($reference): ?User
    {
        if (is_numeric($reference)) {
            return User::find($reference);
        }

        // Handle role:RoleName - pick the first user with that role
        if (is_string($reference) && str_starts_with($reference, 'role:')) {
            $roleName = substr($reference, 5);
            return User::role($roleName)->first();
        }

        return null;
    }

    /**
     * Build merge data for template replacements.
     */
    protected function buildMergeData(Customer $customer, ?User $sender = null): array
    {
        $dealership = DealershipInfo::first();

        $data = [
            'first_name'              => $customer->first_name ?? '',
            'last_name'               => $customer->last_name ?? '',
            'email'                   => $customer->primary_email ?? $customer->email ?? '',
            'cell_phone'              => $customer->cell_phone ?? '',
            'work_phone'              => $customer->work_phone ?? '',
            'home_phone'              => $customer->phone ?? '',
            'address'                 => $customer->address ?? '',
            'city'                    => $customer->city ?? '',
            'province'                => $customer->state ?? '',
            'postal_code'             => $customer->zip_code ?? '',
            'country'                 => $customer->country ?? '',
            'year'                    => $customer->interested_year ?? '',
            'make'                    => $customer->interested_make ?? '',
            'model'                   => $customer->interested_model ?? '',
            'tradein_year'            => $customer->tradein_year ?? '',
            'tradein_make'            => $customer->tradein_make ?? '',
            'tradein_model'           => $customer->tradein_model ?? '',
            'tradein_vin'             => $customer->tradein_vin ?? '',
            'tradein_kms'             => $customer->tradein_kms ?? '',
            'tradein_price'           => $customer->tradein_value ?? '',
            'assigned_to'             => $customer->assignedUser?->name ?? '',
            'assigned_to_email'       => $customer->assignedUser?->email ?? '',
            'assigned_manager'        => $customer->assignedManagerUser?->name ?? '',
            'secondary_assigned'      => $customer->secondaryAssignedUser?->name ?? '',
            'bdc_agent'               => $customer->bdcAgentUser?->name ?? '',
            'finance_manager'         => $customer->finance_manager ? (User::find($customer->finance_manager)?->name ?? '') : '',
            'dealer_name'             => $dealership?->name ?? '',
            'dealer_phone'            => $dealership?->phone ?? '',
            'dealer_address'          => $dealership?->address ?? '',
            'dealer_email'            => $dealership?->email ?? '',
            'dealer_website'          => $dealership?->website ?? '',
        ];

        if ($sender) {
            $data['assigned_to_full_name'] = $sender->name ?? '';
        }

        return $data;
    }

    /**
     * Replace merge fields in template content.
     */
    protected function replaceMergeFields(string $content, array $data): string
    {
        foreach ($data as $key => $value) {
            // Support both {{ key }} and @{{ key }} formatting
            $content = str_replace(["{{ {$key} }}", "@{{ {$key} }}", "{{$key}}", "{{{$key}}}"], $value, $content);
        }

        return $content;
    }

    /**
     * Normalize phone number for SMS sending.
     */
    protected function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);
        $countryCode = config('services.telnyx.default_country_code', '1');

        // If already has country code (11+ digits starting with country code)
        if (strlen($digits) >= 11 && str_starts_with($digits, $countryCode)) {
            return '+' . $digits;
        }

        return '+' . $countryCode . $digits;
    }

    /**
     * Update sequence statistics after action execution.
     */
    protected function updateSequenceStats(SmartSequence $sequence, SequenceAction $action): void
    {
        $sequence->update(['last_sent_at' => now()]);
    }
}
