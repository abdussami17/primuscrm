<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SmartSequence extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'is_active',
        'created_by',
        'last_sent_at',
        'sent_count',
        'bounced_count',
        'invalid_count',
        'casl_restricted_count',
        'appointments_count',
        'unsubscribed_count',
        'delivered_count',
        'opened_count',
        'clicked_count',
        'replied_count',
    ];
    protected static function booted()
    {
        static::updating(function ($model) {
            $model->edited_at = now();
            $model->edited_by = Auth::id();
        });
    }
    protected $casts = [
        'is_active' => 'boolean',
        'last_sent_at' => 'datetime',
        'sent_count' => 'integer',
        'bounced_count' => 'integer',
        'invalid_count' => 'integer',
        'casl_restricted_count' => 'integer',
        'appointments_count' => 'integer',
        'unsubscribed_count' => 'integer',
        'delivered_count' => 'integer',
        'opened_count' => 'integer',
        'clicked_count' => 'integer',
        'replied_count' => 'integer',
        'edited_at' => 'datetime',
    ];

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
    
    public function criteriaGroups(): HasMany
    {
        return $this->hasMany(SequenceCriteriaGroup::class)->orderBy('sort_order');
    }

    public function actions(): HasMany
    {
        return $this->hasMany(SequenceAction::class)->orderBy('sort_order');
    }

    public function executionLogs(): HasMany
    {
        return $this->hasMany(SequenceExecutionLog::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCreator($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    // Methods
    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }

    public function incrementStat(string $stat, int $amount = 1): bool
    {
        $validStats = [
            'sent_count', 'bounced_count', 'invalid_count', 'casl_restricted_count',
            'appointments_count', 'unsubscribed_count', 'delivered_count',
            'opened_count', 'clicked_count', 'replied_count'
        ];

        if (!in_array($stat, $validStats)) {
            return false;
        }

        return $this->increment($stat, $amount);
    }

    public function duplicateSequence(): SmartSequence
    {
        $newSequence = $this->replicate();
        $newSequence->title = $this->title . '-(copy)';
        $newSequence->is_active = false;
        $newSequence->sent_count = 0;
        $newSequence->bounced_count = 0;
        $newSequence->invalid_count = 0;
        $newSequence->casl_restricted_count = 0;
        $newSequence->appointments_count = 0;
        $newSequence->unsubscribed_count = 0;
        $newSequence->delivered_count = 0;
        $newSequence->opened_count = 0;
        $newSequence->clicked_count = 0;
        $newSequence->replied_count = 0;
        $newSequence->last_sent_at = null;
        $newSequence->save();

        // Duplicate criteria groups
        foreach ($this->criteriaGroups as $group) {
            $newGroup = $group->replicate();
            $newGroup->smart_sequence_id = $newSequence->id;
            $newGroup->save();

            // Duplicate criteria
            foreach ($group->criteria as $criterion) {
                $newCriterion = $criterion->replicate();
                $newCriterion->criteria_group_id = $newGroup->id;
                $newCriterion->save();
            }
        }

        // Duplicate actions
        foreach ($this->actions as $action) {
            $newAction = $action->replicate();
            $newAction->smart_sequence_id = $newSequence->id;
            $newAction->save();
        }

        return $newSequence;
    }
}