<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SequenceAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'smart_sequence_id',
        'action_type',
        'delay_value',
        'delay_unit',
        'parameters',
        'sort_order',
        'is_valid',
    ];

    protected $casts = [
        'parameters' => 'array',
        'delay_value' => 'integer',
        'sort_order' => 'integer',
        'is_valid' => 'boolean',
    ];

    // Action Types
    public const TYPE_TASK = 'task';
    public const TYPE_EMAIL = 'email';
    public const TYPE_TEXT = 'text';
    public const TYPE_NOTIFY = 'notify';
    public const TYPE_AI_DRAFT_EMAIL = 'ai-draft-email';
    public const TYPE_AI_DRAFT_TEXT = 'ai-draft-text';
    public const TYPE_CHANGE_ASSIGNED_TO = 'change-assigned-to';
    public const TYPE_CHANGE_ASSIGNED_MANAGER = 'change-assigned-manager';
    public const TYPE_CHANGE_BDC_AGENT = 'change-bdc-agent';
    public const TYPE_CHANGE_FINANCE_MANAGER = 'change-finance-manager';
    public const TYPE_CHANGE_LEAD_STATUS = 'change-lead-status';
    public const TYPE_CHANGE_LEAD_TYPE = 'change-lead-type';
    public const TYPE_CHANGE_SALES_STATUS = 'change-sales-status';
    public const TYPE_CHANGE_SECONDARY_ASSIGNED = 'change-secondary-assigned-to';
    public const TYPE_CHANGE_STATUS_LOST = 'change-status-lost';
    public const TYPE_CHANGE_STATUS_TYPE = 'change-status-type';
    public const TYPE_REASSIGN_LEAD = 'reassign-lead';

    // Delay Units
    public const UNIT_MINUTES = 'minutes';
    public const UNIT_HOURS = 'hours';
    public const UNIT_DAYS = 'days';
    public const UNIT_MONTHS = 'months';
    public const UNIT_YEARS = 'years';

    public static function getActionTypes(): array
    {
        return [
            self::TYPE_AI_DRAFT_EMAIL => 'AI Draft Email',
            self::TYPE_AI_DRAFT_TEXT => 'AI Draft Text',
            self::TYPE_CHANGE_ASSIGNED_TO => 'Change Assigned To',
            self::TYPE_CHANGE_ASSIGNED_MANAGER => 'Change Assigned Manager',
            self::TYPE_CHANGE_BDC_AGENT => 'Change BDC Agent',
            self::TYPE_CHANGE_FINANCE_MANAGER => 'Change Finance Manager',
            self::TYPE_CHANGE_LEAD_STATUS => 'Change Lead Status',
            self::TYPE_CHANGE_LEAD_TYPE => 'Change Lead Type',
            self::TYPE_CHANGE_SALES_STATUS => 'Change Sales Status',
            self::TYPE_CHANGE_SECONDARY_ASSIGNED => 'Change Secondary Assigned To',
            self::TYPE_CHANGE_STATUS_LOST => 'Change Status to Lost',
            self::TYPE_CHANGE_STATUS_TYPE => 'Change Status Type',
            self::TYPE_TASK => 'Create Task',
            self::TYPE_EMAIL => 'Send Automated Email to Customer',
            self::TYPE_TEXT => 'Send Automated Text to Customer',
            self::TYPE_NOTIFY => 'Send Notification',
            self::TYPE_REASSIGN_LEAD => 'Reassign Lead',
        ];
    }

    public static function getDelayUnits(): array
    {
        return [
            self::UNIT_MINUTES => 'Minutes',
            self::UNIT_HOURS => 'Hours',
            self::UNIT_DAYS => 'Days',
            self::UNIT_MONTHS => 'Months',
            self::UNIT_YEARS => 'Years',
        ];
    }

    public static function getTaskTypes(): array
    {
        return [
            'Appointment',
            'CSI',
            'Inbound Call',
            'Inbound Email',
            'Inbound Text',
            'Other',
            'Outbound Call',
            'Outbound Email',
            'Outbound Text',
        ];
    }

    public static function getSalesStatusOptions(): array
    {
        return ['Uncontacted', 'Attempted', 'Contacted', 'Dealer Visit', 'Demo', 'Write-Up', 'Pending F&I', 'Delivered', 'Sold'];
    }

    public static function getStatusTypeOptions(): array
    {
        return ['Open', 'Confirmed', 'Completed', 'Missed', 'Cancelled', 'Walk-In', 'No Response', 'No Show'];
    }

    public static function getLeadStatusOptions(): array
    {
        return ['Active', 'Duplicate', 'Invalid', 'Lost', 'Sold', 'Wishlist', 'Buy-In'];
    }

    public static function getLeadTypeOptions(): array
    {
        return ['Internet', 'Walk-In', 'Phone Up', 'Text Up', 'Website Chat', 'Import', 'Wholesale', 'Lease Renewal'];
    }

    public static function getLostReasons(): array
    {
        return [
            'Bad Credit',
            'Bad Email',
            'Bad Phone Number',
            'Did Not Respond',
            'Diff Dealer, Diff Brand',
            'Diff Dealer, Same Brand',
            'Diff Dealer, Same Group',
            'Import Lead',
            'No Agreement Reached',
            'No Credit',
            'No Longer Owns',
            'Other Salesperson Lead',
            'Out of Market',
            'Requested No More Contact',
            'Service Lead',
            'Sold Privately',
        ];
    }

    // Relationships
    public function sequence(): BelongsTo
    {
        return $this->belongsTo(SmartSequence::class, 'smart_sequence_id');
    }

    public function executionLogs(): HasMany
    {
        return $this->hasMany(SequenceExecutionLog::class);
    }

    // Accessors
    public function getActionLabelAttribute(): string
    {
        return self::getActionTypes()[$this->action_type] ?? $this->action_type;
    }

    public function getDelayUnitLabelAttribute(): string
    {
        return self::getDelayUnits()[$this->delay_unit] ?? $this->delay_unit;
    }

    public function getDelayDescriptionAttribute(): string
    {
        if ($this->delay_value == 0) {
            return 'Immediately';
        }
        $unit = $this->delay_value == 1 ? rtrim($this->delay_unit_label, 's') : $this->delay_unit_label;
        return "{$this->delay_value} {$unit}";
    }

    // Get parameter by key
    public function getParameter(string $key, $default = null)
    {
        return $this->parameters[$key] ?? $default;
    }

    // Set parameter
    public function setParameter(string $key, $value): void
    {
        $params = $this->parameters ?? [];
        $params[$key] = $value;
        $this->parameters = $params;
    }

    // Validation
    public function validate(): bool
    {
        $valid = match($this->action_type) {
            self::TYPE_TASK => $this->validateTask(),
            self::TYPE_EMAIL, self::TYPE_TEXT => $this->validateEmailOrText(),
            self::TYPE_NOTIFY => $this->validateNotify(),
            self::TYPE_AI_DRAFT_EMAIL, self::TYPE_AI_DRAFT_TEXT => $this->validateAiDraft(),
            self::TYPE_CHANGE_STATUS_LOST => $this->validateStatusLost(),
            self::TYPE_CHANGE_SALES_STATUS, self::TYPE_CHANGE_LEAD_STATUS, 
            self::TYPE_CHANGE_STATUS_TYPE, self::TYPE_CHANGE_LEAD_TYPE => $this->validateStatusChange(),
            self::TYPE_CHANGE_ASSIGNED_TO, self::TYPE_CHANGE_ASSIGNED_MANAGER,
            self::TYPE_CHANGE_BDC_AGENT, self::TYPE_CHANGE_FINANCE_MANAGER,
            self::TYPE_CHANGE_SECONDARY_ASSIGNED, self::TYPE_REASSIGN_LEAD => $this->validateUserAssignment(),
            default => false,
        };

        $this->is_valid = $valid;
        return $valid;
    }

    protected function validateTask(): bool
    {
        return !empty($this->getParameter('task_type'))
            && !empty($this->getParameter('assigned_to'))
            && !empty($this->getParameter('fallback'))
            && !empty($this->getParameter('description'));
    }

    protected function validateEmailOrText(): bool
    {
        return !empty($this->getParameter('template'))
            && !empty($this->getParameter('from_address'))
            && !empty($this->getParameter('fallback'));
    }

    protected function validateNotify(): bool
    {
        return !empty($this->getParameter('user'))
            && !empty($this->getParameter('message'));
    }

    protected function validateAiDraft(): bool
    {
        return !empty($this->getParameter('task_type'))
            && !empty($this->getParameter('assigned_to'))
            && !empty($this->getParameter('fallback'));
    }

    protected function validateStatusLost(): bool
    {
        return !empty($this->getParameter('status'))
            && !empty($this->getParameter('lost_reason'));
    }

    protected function validateStatusChange(): bool
    {
        return !empty($this->getParameter('status'));
    }

    protected function validateUserAssignment(): bool
    {
        return !empty($this->getParameter('user'));
    }

    // Calculate delay in seconds
    public function getDelayInSeconds(): int
    {
        return match($this->delay_unit) {
            self::UNIT_MINUTES => $this->delay_value * 60,
            self::UNIT_HOURS => $this->delay_value * 3600,
            self::UNIT_DAYS => $this->delay_value * 86400,
            self::UNIT_MONTHS => $this->delay_value * 2592000, // 30 days
            self::UNIT_YEARS => $this->delay_value * 31536000, // 365 days
            default => 0,
        };
    }
}