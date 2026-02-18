<?php

namespace App\Exports;

use App\Models\User;

class UsersExport
{
    public function collection()
    {
        return User::with('roles')->get()->map(function($user) {
            return [
                'Employee #' => $user->employee_number ?? 'N/A',
                'Name' => $user->name,
                'Email' => $user->email,
                'Phone' => $user->work_phone ?? 'N/A',
                'Mobile' => $user->cell_phone ?? 'N/A',
                'Role' => $user->roles->pluck('name')->join(', ') ?: 'No Role',
                'Status' => $user->is_active ? 'Active' : 'Inactive',
                'Last Login' => $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : 'Never',
                'Created Date' => $user->created_at->format('M d, Y'),
            ];
        });
    }
}
