<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'customer_id',
        'deal_id',
        'task_id',
        'created_by',
        'description',
        'type',
        'is_private',
        'metadata',
        'attachments',
    ];

    // Cast certain fields to specific data types
    protected $casts = [
        'is_private' => 'boolean',
        'metadata' => 'array',
        'attachments' => 'array', // JSON encoded/decoded automatically
    ];

    // ✅ Note belongs to a task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }


    // Optional: if you want to access the user who created the note
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Optional: if you want to access the customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

     public function taggedUsers()
    {
        return $this->belongsToMany(User::class, 'note_user', 'note_id', 'user_id');
    }

}
