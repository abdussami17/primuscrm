<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SecuritySetting;

class SecurityController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'min_password_length' => 'nullable|integer|min:4|max:128',
            'require_uppercase' => 'nullable|boolean',
            'require_numbers' => 'nullable|boolean',
            'require_special' => 'nullable|boolean',
            'password_expiry_days' => 'nullable|integer|min:0|max:3650',
            'password_history' => 'nullable|integer|min:0|max:100',
            'require_2fa' => 'nullable|boolean',
            'preferred_2fa_method' => 'nullable|string|max:255',
            'remember_device_days' => 'nullable|integer|min:0|max:365',
            'session_timeout_minutes' => 'nullable|integer|min:1|max:1440',
        ]);

        $payload = [
            'min_password_length' => $request->input('min_password_length', 8),
            'require_uppercase' => $request->boolean('require_uppercase'),
            'require_numbers' => $request->boolean('require_numbers'),
            'require_special' => $request->boolean('require_special'),
            'password_expiry_days' => $request->input('password_expiry_days', 90),
            'password_history' => $request->input('password_history', 5),
            'require_2fa' => $request->boolean('require_2fa'),
            'preferred_2fa_method' => $request->input('preferred_2fa_method'),
            'remember_device_days' => $request->input('remember_device_days'),
            'session_timeout_minutes' => $request->input('session_timeout_minutes', 30),
        ];

        $row = SecuritySetting::first();
        if (! $row) {
            $row = SecuritySetting::create($payload);
        } else {
            $row->update($payload);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $row]);
        }

        return redirect()->back()->with('success', 'Security settings updated.');
    }
}
