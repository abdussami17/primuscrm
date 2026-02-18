<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IpRestriction;

class IpRestrictionController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'mode' => 'nullable|string|max:50',
            'allowed_ips' => 'nullable|string',
            'bypass_admin' => 'nullable|boolean',
            'log_blocked' => 'nullable|boolean',
        ]);

        // Ensure boolean fields are set
        $data['bypass_admin'] = $request->has('bypass_admin') ? (bool) $request->input('bypass_admin') : false;
        $data['log_blocked'] = $request->has('log_blocked') ? (bool) $request->input('log_blocked') : false;

        $ip = IpRestriction::first();
        if (! $ip) {
            $ip = IpRestriction::create($data);
        } else {
            $ip->update($data);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $ip]);
        }

        return redirect()->back()->with('success', 'IP restriction settings updated.');
    }
}
