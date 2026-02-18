<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'deals_id',
        'document_type',
        'file_name',
        'file_path',
        'file_size',
        'notes',
        'uploaded_by'
    ];

    /**
     * Get the customer that owns the document.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user who uploaded the document.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

      public function getFileUrlAttribute()
    {
        return $this->file_path ? asset($this->file_path) : null;
    }
}
