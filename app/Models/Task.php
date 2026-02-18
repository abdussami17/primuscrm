<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'due_date',
        'customer_id',
        'deal_id',
        'assigned_to',
        'status_type',
        'task_type',
        'priority',
        'script',
        'description',
        'created_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ✅ Task has many notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function taskNotes()
    {
        return $this->hasMany(TaskNote::class);
    }
    // Task.php
public function createdBy()
{
    return $this->belongsTo(User::class, 'created_by');
}

}
