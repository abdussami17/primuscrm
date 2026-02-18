<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DealershipInfo;
use App\Models\User;
use App\Models\IpRestriction;
use App\Models\StoreHours;
use App\Models\SecuritySetting;
use App\Models\NotificationSetting;
use App\Models\EmailAccount;

class DealershipInfoController extends Controller
{
    public function index()
    {
        $dealership = DealershipInfo::first();
        $ipRestriction = IpRestriction::first();
        $storeHours = StoreHours::first();
        $securitySetting = SecuritySetting::first();
        $notificationSetting = NotificationSetting::first();
        $emailAccount = EmailAccount::first();
        $users = User::orderBy('name')->get();
        $leadStatuses = ['new' => 'New', 'qualified' => 'Qualified', 'prospect' => 'Prospect', 'customer' => 'Customer'];
        $leadTypes = ['inbound' => 'Inbound', 'outbound' => 'Outbound', 'referral' => 'Referral', 'website' => 'Website'];
        $inventoryTypes = ['sedan' => 'Sedan', 'suv' => 'SUV', 'truck' => 'Truck', 'convertible' => 'Convertible'];
        $salesStatuses = ['pending' => 'Pending', 'in_progress' => 'In Progress', 'negotiation' => 'Negotiation', 'closed_won' => 'Closed Won'];
        $sources = ['website' => 'Website', 'walk_in' => 'Walk-in', 'referral' => 'Referral', 'phone' => 'Phone', 'email' => 'Email'];
        $dealTypes = ['retail' => 'Retail', 'lease' => 'Lease', 'finance' => 'Finance'];
        $salesTypes = ['cash' => 'Cash', 'finance' => 'Finance', 'lease' => 'Lease'];

        return view('settings.index', compact('dealership', 'ipRestriction', 'storeHours', 'securitySetting', 'notificationSetting', 'emailAccount', 'users', 'leadStatuses', 'leadTypes', 'inventoryTypes', 'salesStatuses', 'sources', 'dealTypes', 'salesTypes'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:50',
            'timezone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'tax_id' => 'nullable|string|max:100',
            'license_number' => 'nullable|string|max:100',
        ]);

        $dealership = DealershipInfo::first();
        if (! $dealership) {
            $dealership = DealershipInfo::create($data);
        } else {
            $dealership->update($data);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $dealership]);
        }

        return redirect()->back()->with('success', 'Dealership information updated.');
    }
}
