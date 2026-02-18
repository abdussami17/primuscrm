<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskNote extends Model
{
    use HasFactory;

    protected $table = 'task_notes';

    protected $fillable = [
        'task_id',
        'user_id',
        'note',
        'metadata',
        'attachments'
    ];

    protected $casts = [
        'metadata' => 'array',
        'attachments' => 'array'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
