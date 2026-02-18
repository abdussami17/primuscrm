<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SequenceCriteriaGroup extends Model
{
    use HasFactory;

    protected $table = 'sequence_criteria_groups';

    protected $fillable = [
        'smart_sequence_id',
        'logic_type',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public const LOGIC_AND = 'AND';
    public const LOGIC_OR = 'OR';

    // Relationships
    public function sequence(): BelongsTo
    {
        return $this->belongsTo(SmartSequence::class, 'smart_sequence_id');
    }

    public function criteria(): HasMany
    {
        return $this->hasMany(SequenceCriteria::class, 'criteria_group_id')->orderBy('sort_order');
    }

    // Scopes
    public function scopeAnd($query)
    {
        return $query->where('logic_type', self::LOGIC_AND);
    }

    public function scopeOr($query)
    {
        return $query->where('logic_type', self::LOGIC_OR);
    }

    // Methods
    public function isOrGroup(): bool
    {
        return $this->logic_type === self::LOGIC_OR;
    }

    public function isAndGroup(): bool
    {
        return $this->logic_type === self::LOGIC_AND;
    }
}