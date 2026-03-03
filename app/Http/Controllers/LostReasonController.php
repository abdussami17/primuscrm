<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LostReason;

class LostReasonController extends Controller
{
    // Return all lost reasons; seed defaults if empty
    public function index()
    {
        $items = LostReason::orderBy('sort_order')->get();

        if ($items->isEmpty()) {
            $defaults = [
                "Bad Credit",
                "Bad Email",
                "Bad Phone Number",
                "Did Not Respond",
                "Diff Dealer, Diff Brand",
                "Diff Dealer, Same Brand",
                "Diff Dealer, Same Group",
                "Import Lead",
                "No Agreement Reached",
                "No Credit",
                "No Longer Owns",
                "Other Salesperson Lead",
                "Out of Market",
                "Requested No More Contact",
                "Service Lead",
                "Sold Privately"
            ];

            foreach ($defaults as $i => $name) {
                LostReason::create(['name' => $name, 'sort_order' => $i]);
            }

            $items = LostReason::orderBy('sort_order')->get();
        }

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $maxOrder = LostReason::max('sort_order') ?? 0;
        $reason = LostReason::create(['name' => $request->name, 'sort_order' => $maxOrder + 1]);

        return response()->json(['success' => true, 'data' => $reason], 201);
    }

    public function update(Request $request, LostReason $lostReason)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $lostReason->update(['name' => $request->name]);
        return response()->json(['success' => true, 'data' => $lostReason]);
    }

    public function destroy(LostReason $lostReason)
    {
        $lostReason->delete();
        return response()->json(['success' => true]);
    }
}
