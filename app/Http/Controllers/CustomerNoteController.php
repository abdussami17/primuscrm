<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerNote;
use Illuminate\Support\Facades\Auth;

class CustomerNoteController extends Controller
{
    // Store new note via AJAX
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'note' => 'required|string|max:1000',
        ]);

        $note = CustomerNote::create([
            'customer_id' => $request->customer_id,
            'user_id' => Auth::id(),
            'note' => $request->note,
        ]);

        // Return the newly added note for front-end
        return response()->json([
            'id' => $note->id,
            'user_name' => $note->user->name,
            'note' => $note->note,
            'created_at' => $note->created_at->format('M d, Y — h:i A'),
        ]);
    }

    // Fetch notes for a customer
    public function index($customerId)
    {
        $notes = CustomerNote::where('customer_id', $customerId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notes);
    }
}
