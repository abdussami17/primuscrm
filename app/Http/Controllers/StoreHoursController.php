<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreHours;
use App\Models\Holiday;

class StoreHoursController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'hours' => 'nullable|string', // JSON string
            'show_hours' => 'nullable|boolean',
            'holiday_overrides' => 'nullable|string', // JSON string
        ]);

        $payload = [];
        $payload['hours'] = !empty($data['hours']) ? json_decode($data['hours'], true) : null;
        $payload['holiday_overrides'] = !empty($data['holiday_overrides']) ? json_decode($data['holiday_overrides'], true) : null;
        $payload['show_hours'] = $request->has('show_hours') ? (bool) $request->input('show_hours') : false;

        $row = StoreHours::first();
        if (! $row) {
            $row = StoreHours::create($payload);
        } else {
            $row->update($payload);
        }

        // Also persist holiday overrides into holidays table (upsert by id when provided)
        if (!empty($payload['holiday_overrides']) && is_array($payload['holiday_overrides'])) {
            foreach ($payload['holiday_overrides'] as $h) {
                if (empty($h['name']) || empty($h['date'])) continue;

                $start = $h['startTime'] ?? $h['start_time'] ?? null;
                $end = $h['endTime'] ?? $h['end_time'] ?? null;

                // Normalize HH:MM to HH:MM:00 if needed
                if ($start && preg_match('/^\d{1,2}:\d{2}(?!:)/', $start)) $start = $start . ':00';
                if ($end && preg_match('/^\d{1,2}:\d{2}(?!:)/', $end)) $end = $end . ':00';

                $values = [
                    'name' => $h['name'],
                    'date' => $h['date'],
                    'is_closed' => isset($h['isClosed']) ? (bool)$h['isClosed'] : (isset($h['is_closed']) ? (bool)$h['is_closed'] : false),
                    'start_time' => $start,
                    'end_time' => $end,
                ];

                if (!empty($h['id'])) {
                    Holiday::updateOrCreate(['id' => $h['id']], $values);
                } else {
                    // avoid duplicates by unique date+name if desired — using simple create for now
                    Holiday::create($values);
                }
            }
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $row]);
        }

        return redirect()->back()->with('success', 'Store hours updated.');
    }
}
