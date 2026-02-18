<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'work_phone',
        'cell_phone',
        'home_phone',
        'title',
        'employee_number',
        'profile_photo',
        'email_signature',
        'working_hours',
        'dealership_franchises',
        'is_active',
        'last_login_at',
        'assigned_manager',
        'assigned_bdc_agent',
        'assigned_service_agent',
        'assigned_finance_manager',
        'receive_internet_lead',
        'receive_off_hours',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'working_hours' => 'array',
            'dealership_franchises' => 'array',
            'is_active' => 'boolean',
            'receive_internet_lead' => 'boolean',
            'receive_off_hours' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get customers assigned to this user.
     */
    public function assignedCustomers()
    {
        return $this->hasMany(Customer::class, 'assigned_to');
    }

    /**
     * Get customers where this user is the manager.
     */
    public function managedCustomers()
    {
        return $this->hasMany(Customer::class, 'assigned_manager');
    }

    /**
     * Get customers where this user is secondary assigned.
     */
    public function secondaryCustomers()
    {
        return $this->hasMany(Customer::class, 'secondary_assigned');
    }

    /**
     * Finance manager relationship (if this user is assigned to customers as finance manager)
     */
    public function financeManagedCustomers()
    {
        return $this->hasMany(Customer::class, 'finance_manager');
    }
}
