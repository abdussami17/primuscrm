<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::orderBy('date', 'asc')->get();
        return response()->json(['success' => true, 'data' => $holidays]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'isClosed' => 'nullable|boolean',
            'startTime' => 'nullable|string',
            'endTime' => 'nullable|string',
        ]);

        $holiday = Holiday::create([
            'name' => $data['name'],
            'date' => $data['date'],
            'is_closed' => $request->boolean('isClosed'),
            'start_time' => $data['startTime'] ?? null,
            'end_time' => $data['endTime'] ?? null,
        ]);

        return response()->json(['success' => true, 'data' => $holiday]);
    }

    public function update(Request $request, Holiday $holiday)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'isClosed' => 'nullable|boolean',
            'startTime' => 'nullable|string',
            'endTime' => 'nullable|string',
        ]);

        $holiday->update([
            'name' => $data['name'],
            'date' => $data['date'],
            'is_closed' => $request->boolean('isClosed'),
            'start_time' => $data['startTime'] ?? null,
            'end_time' => $data['endTime'] ?? null,
        ]);

        return response()->json(['success' => true, 'data' => $holiday]);
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return response()->json(['success' => true]);
    }
}
