<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SequenceExecutionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'smart_sequence_id',
        'sequence_action_id',
        'lead_id',
        'status',
        'scheduled_at',
        'executed_at',
        'error_message',
        'execution_data',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'executed_at' => 'datetime',
        'execution_data' => 'array',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';

    // Relationships
    public function sequence(): BelongsTo
    {
        return $this->belongsTo(SmartSequence::class, 'smart_sequence_id');
    }

    public function action(): BelongsTo
    {
        return $this->belongsTo(SequenceAction::class, 'sequence_action_id');
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeReady($query)
    {
        return $query->where('status', self::STATUS_PENDING)
            ->where('scheduled_at', '<=', now());
    }

    // Methods
    public function markAsProcessing(): bool
    {
        return $this->update(['status' => self::STATUS_PROCESSING]);
    }

    public function markAsCompleted(array $data = []): bool
    {
        return $this->update([
            'status' => self::STATUS_COMPLETED,
            'executed_at' => now(),
            'execution_data' => $data,
        ]);
    }

    public function markAsFailed(string $error): bool
    {
        return $this->update([
            'status' => self::STATUS_FAILED,
            'executed_at' => now(),
            'error_message' => $error,
        ]);
    }

    public function markAsCancelled(): bool
    {
        return $this->update(['status' => self::STATUS_CANCELLED]);
    }
}