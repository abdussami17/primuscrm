<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Activity;
use App\Models\ShowroomVisit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    /**
     * Get notes for a customer/deal.
     */
    public function index(Request $request)
    {
        $query = Note::with(['createdBy:id,name', 'taggedUsers:id,name']);

        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
/*
        if ($request->has('deal_id')) {
            $query->where('deal_id', $request->deal_id);
        }*/

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter private notes
       /* if (!Auth::user()->hasRole('admin')) {
            $query->where(function($q) {
                $q->where('is_private', false)
                  ->orWhere('created_by', Auth::id())
                  ->orWhereHas('taggedUsers', function($q2) {
                      $q2->where('user_id', Auth::id());
                  });
            });
        }
*/
        $limit = $request->get('limit', 10);
        $notes = $query->orderBy('created_at', 'desc')->limit($limit)->get();

        return response()->json([
            'status' => 'success',
            'data'   => $notes
        ]);
    }

    /**
     * Store a new note.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'  => 'required|exists:customers,id',
            'deal_id'      => 'nullable|exists:deals,id',
            'task_id'      => 'nullable|exists:tasks,id',
            'description'  => 'required|string|max:2000',
            'type'         => 'nullable|string',
            'is_private'   => 'nullable|boolean',
            'tagged_users' => 'nullable|array',
            'tagged_users.*' => 'exists:users,id',
            'metadata'     => 'nullable|array',
            'attachments'  => 'nullable|array',
            'attachments.*' => 'file|max:10240', // 10MB max
        ]);

        $validated['created_by'] = Auth::id();
        $validated['type'] = $validated['type'] ?? 'Note';
        $validated['is_private'] = $validated['is_private'] ?? false;

        // Handle file attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('notes/attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'url'  => Storage::url($path),
                    'type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ];
            }
        }
        $validated['attachments'] = json_encode($attachments);

        $note = Note::create($validated);

        // Attach tagged users
        if (!empty($validated['tagged_users'])) {
            $note->taggedUsers()->attach($validated['tagged_users']);
        }

        // Log activity
        Activity::create([
            'deal_id'     => $validated['deal_id'],
            'customer_id' => $validated['customer_id'],
            'user_id'     => Auth::id(),
            'type'        => 'note_added',
            'description' => "Note added: " . substr($validated['description'], 0, 50) . '...'
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Note created successfully',
            'data'    => $note->load(['createdBy', 'taggedUsers'])
        ]);
    }

    /**
     * Fetch notes for a specific task (used by Tasks UI).
     */
    public function fetch($taskId)
    {
        $notes = Note::where('task_id', $taskId)
            ->with('createdBy:id,name')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($n) {
                return [
                    'id' => $n->id,
                    'text' => $n->description,
                    'createdBy' => $n->createdBy->name ?? null,
                    'date' => $n->created_at
                ];
            });

        return response()->json([
            'status' => 'success',
            'notes'  => $notes
        ]);
    }

    /**
     * Fetch task-specific notes (task_notes table)
     */
    
    public function fetchTaskNotes($taskId)
    {
        // Fetch legacy notes attached to tasks
        $normalNotes = Note::where('task_id', $taskId)
            ->with('createdBy:id,name')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($n) {
                return [
                    'id' => 'note-' . $n->id,
                    'text' => $n->description,
                    'createdBy' => $n->createdBy->name ?? null,
                    'date' => $n->created_at,
                    'source' => 'note'
                ];
            });

        // Fetch newer task-specific notes from task_notes table
        $taskNotes = \App\Models\TaskNote::where('task_id', $taskId)
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($n) {
                return [
                    'id' => 'tasknote-' . $n->id,
                    'text' => $n->note,
                    'createdBy' => $n->user->name ?? null,
                    'date' => $n->created_at,
                    'source' => 'task_note'
                ];
            });

        // Merge both collections and sort by date desc
        $notes = $normalNotes->concat($taskNotes)
            ->sortByDesc(function($item) {
                return $item['date'];
            })->values();

        return response()->json([
            'status' => 'success',
            'notes'  => $notes
        ]);
    }

    /**
     * Store a task note in `task_notes` table.
     */
    public function storeTaskNotes(Request $request, $taskId)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:2000',
            'metadata' => 'nullable|array',
            'attachments' => 'nullable|array'
        ]);

        $note = \App\Models\TaskNote::create([
            'task_id' => $taskId,
            'user_id' => Auth::id(),
            'note' => $validated['description'],
            'metadata' => $validated['metadata'] ?? null,
            'attachments' => $validated['attachments'] ?? null
        ]);

        return response()->json([
            'status' => 'success',
            'note' => [
                'id' => $note->id,
                'description' => $note->note,
                'created_at' => $note->created_at,
                'createdBy' => Auth::user()->name ?? null
            ]
        ]);
    }

    /**
     * Update a note.
     */
    public function update(Request $request, Note $note)
    {
        // Only creator or admin can edit
        if ($note->created_by !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'description'  => 'required|string|max:2000',
            'is_private'   => 'nullable|boolean',
            'tagged_users' => 'nullable|array',
        ]);

        $note->update($validated);

        // Sync tagged users
        if (isset($validated['tagged_users'])) {
            $note->taggedUsers()->sync($validated['tagged_users']);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Note updated successfully',
            'data'    => $note
        ]);
    }

    /**
     * Delete a note.
     */
    public function destroy(Note $note)
    {
        // Only creator or admin can delete
        if ($note->created_by !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Delete attachments
        if (!empty($note->attachments)) {
            foreach ($note->attachments as $attachment) {
                $path = str_replace('/storage/', '', $attachment['url']);
                Storage::disk('public')->delete($path);
            }
        }

        $note->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Note deleted successfully'
        ]);
    }

    /**
     * Start a showroom visit.
     */
    public function startVisit(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'deal_id'     => 'nullable|exists:deals,id',
        ]);

        $visit = ShowroomVisit::create([
            'customer_id' => $validated['customer_id'],
            'deal_id'     => $validated['deal_id'],
            'user_id'     => Auth::id(),
            'start_time'  => now(),
            'status'      => 'in_progress'
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Visit started',
            'data'    => $visit
        ]);
    }

    /**
     * Stop a showroom visit.
     */
    public function stopVisit(Request $request, ShowroomVisit $visit)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
            // legacy individual flags (kept for backward compatibility)
            'demo' => 'nullable|boolean',
            'write_up' => 'nullable|boolean',
            'touch_desk' => 'nullable|boolean',
            'pending_fi' => 'nullable|boolean',
            'trade_appraisal' => 'nullable|boolean',
            'sold' => 'nullable|boolean',
            'lost' => 'nullable|boolean',
            // dynamic flags payload
            'flags' => 'nullable|array',
            'flags.*' => 'nullable|boolean',
        ]);
        // ensure we have the latest data
        $visit->refresh();

        // compute duration in seconds safely (use timestamps to avoid timezone issues)
        if ($visit->start_time) {
            $startTs = $visit->start_time->getTimestamp();
            $nowTs = now()->getTimestamp();
            $duration = max(0, $nowTs - $startTs);
        } else {
            $duration = 0;
        }

        $updateData = [
            'end_time' => now(),
            'duration' => $duration,
            'notes'    => $validated['notes'] ?? null,
            'status'   => 'completed'
        ];

        // Consolidate flags into a single JSON collection. Prefer explicit `flags` payload,
        // but also include any legacy boolean fields by merging them into the JSON.
        $flags = [];
        $legacyKeys = ['demo','write_up','touch_desk','pending_fi','trade_appraisal','sold','lost'];
        foreach ($legacyKeys as $f) {
            if (array_key_exists($f, $validated)) {
                $flags[$f] = (bool) $validated[$f];
            }
        }

        if (array_key_exists('flags', $validated) && is_array($validated['flags'])) {
            // merge provided flags, letting provided `flags` values override legacy inputs
            $flags = array_merge($flags, $validated['flags']);
        }

        if (!empty($flags)) {
            $updateData['flags'] = $flags;
        }

        $visit->update($updateData);

        // format duration as H:i:s
        $h = floor($duration / 3600);
        $m = floor(($duration % 3600) / 60);
        $s = $duration % 60;
        $durationFormatted = sprintf('%02d:%02d:%02d', $h, $m, $s);

        // If user provided additional notes in the edit form, save them as a separate Note
        if (!empty($validated['notes'])) {
            Note::create([
                'customer_id' => $visit->customer_id,
                'deal_id'     => $visit->deal_id,
                'type'        => 'Note',
                'description' => $validated['notes'],
                'created_by'  => Auth::id(),
                'metadata'    => [
                    'visit_id' => $visit->id,
                    'start_time' => $visit->start_time,
                    'end_time'   => now(),
                    'duration_seconds' => $visit->duration
                ],
            ]);
            
        }
        // else{
        //             // Create an automated note for the visit summary
        // Note::create([
        //     'customer_id' => $visit->customer_id,
        //     'deal_id'     => $visit->deal_id,
        //     'type'        => 'Showroom Visit',
        //     'description' => "Showroom visit completed. Duration: " . $durationFormatted,
        //     'created_by'  => Auth::id(),
        //     'metadata'    => array_merge([
        //         'visit_id'   => $visit->id,
        //         'start_time' => $visit->start_time,
        //         'end_time'   => $visit->end_time,
        //         'duration'   => $duration
        //     ], ['flags' => $updateData['flags'] ?? null])
        // ]);
        // }

        // Log activity
        Activity::create([
            'deal_id'     => $visit->deal_id,
            'customer_id' => $visit->customer_id,
            'user_id'     => Auth::id(),
            'type'        => 'showroom_visit',
            'description' => "Showroom visit completed (" . gmdate('H:i:s', $visit->duration) . ")"
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Visit completed',
            'data'    => $visit
        ]);
    }

    /**
     * Update a showroom visit.
     */
    public function updateVisit(Request $request, ShowroomVisit $visit)
    {
        $validated = $request->validate([
            'start_time' => 'nullable|date',
            'end_time'   => 'nullable|date',
            'duration'   => 'nullable|integer',
            'notes'      => 'nullable|string|max:500',
            'demo' => 'nullable|boolean',
            'write_up' => 'nullable|boolean',
            'touch_desk' => 'nullable|boolean',
            'pending_fi' => 'nullable|boolean',
            'trade_appraisal' => 'nullable|boolean',
            'sold' => 'nullable|boolean',
            'lost' => 'nullable|boolean',
            'flags' => 'nullable|array',
            'flags.*' => 'nullable|boolean',
        ]);

        // normalize flags into booleans if present
        foreach (['demo','write_up','touch_desk','pending_fi','trade_appraisal','sold','lost'] as $f) {
            if (array_key_exists($f, $validated)) $validated[$f] = (bool) $validated[$f];
        }

        // Normalize flags into a single JSON collection on update. Merge any legacy boolean fields
        // into `flags` and do not mirror into separate columns.
        $legacyKeys = ['demo','write_up','touch_desk','pending_fi','trade_appraisal','sold','lost'];
        $flags = [];
        foreach ($legacyKeys as $f) {
            if (array_key_exists($f, $validated)) $flags[$f] = (bool) $validated[$f];
        }
        if (array_key_exists('flags', $validated) && is_array($validated['flags'])) {
            $flags = array_merge($flags, $validated['flags']);
        }
        if (!empty($flags)) $validated['flags'] = $flags;

        $visit->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Visit updated',
            'data'    => $visit
        ]);
    }

    /**
     * Return a showroom visit's data for editing.
     */
    public function showVisit(ShowroomVisit $visit)
    {
        return response()->json([
            'status' => 'success',
            'data' => array_merge($visit->toArray(), [
                'duration_formatted' => $visit->getDurationFormattedAttribute()
            ])
        ]);
    }

    /**
     * Return the latest showroom visit for a customer/deal (if any).
     */
    public function latestVisit(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'deal_id' => 'nullable|exists:deals,id',
        ]);

        $q = ShowroomVisit::where('customer_id', $validated['customer_id']);
        if (!empty($validated['deal_id'])) {
            $q->where('deal_id', $validated['deal_id']);
        }

        $visit = $q->orderByDesc('start_time')->first();

        if (! $visit) {
            return response()->json(['status' => 'success', 'data' => null]);
        }

        return response()->json(['status' => 'success', 'data' => $visit]);
    }

    /**
     * Get combined history (notes, calls, emails, visits).
     */
    public function getHistory(Request $request)
    {
        $customerId = $request->customer_id;
        $dealId = $request->deal_id;
        $limit = $request->get('limit', 20);

        // Combine different history sources
        $history = collect();

        // Notes
        $notes = Note::where('customer_id', $customerId)
            ->when($dealId, fn($q) => $q->where('deal_id', $dealId))
            ->with('createdBy:id,name')
            ->get()
            ->map(fn($n) => [
                'id'          => $n->id,
                'type'        => $n->type ?? 'Note',
                'description' => $n->description,
                'created_at'  => $n->created_at,
                'user'        => $n->createdBy,
                'attachments' => $n->attachments
            ]);

        $history = $history->merge($notes);

        // Sort by date and limit
        $history = $history->sortByDesc('created_at')->take($limit)->values();

        return response()->json([
            'status' => 'success',
            'data'   => $history
        ]);
    }
}