<?php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use Illuminate\Http\Request;

class NotificationSettingController extends Controller
{
    public function show()
    {
        $setting = NotificationSetting::first();
        return response()->json(['success' => true, 'data' => $setting ? $setting->data : []]);
    }

    public function update(Request $request)
    {
        $payload = $request->input('data', []);
        $setting = NotificationSetting::first();
        if (! $setting) {
            $setting = NotificationSetting::create(['data' => $payload]);
        } else {
            $setting->data = $payload;
            $setting->save();
        }

        return response()->json(['success' => true, 'data' => $setting->data]);
    }
}
