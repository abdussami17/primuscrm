<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use App\Models\User;
use App\Models\Activity;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display tasks listing page.
     */
    public function index()
    {
        $users = User::select('id', 'name')->get();
        $customers = Customer::select('id', 'first_name', 'last_name')->get();
        return view('tasks.index', compact('users', 'customers'));
    }

    /**
     * Store a new task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'deal_id'     => 'required|integer|exists:deals,id',
            'due_date'    => 'required|date',
            'assigned_to' => 'required|integer|exists:users,id',
            'status_type' => 'required|string',
            'task_type'   => 'required|string',
            'priority'    => 'required|string|in:High,Medium,Low',
            'script'      => 'nullable|string',
            'description' => 'nullable|string|max:500',
        ]);


        // Ensure we have an authenticated user for created_by
        $userId = Auth::id() ?? $request->user()?->id;
        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated: cannot create task without a user'
            ], 401);
        }

        $task = Task::create([
            'customer_id' => $validated['customer_id'],
            'created_by' => $userId,
            'deal_id' => $validated['deal_id'],
            'due_date' => $validated['due_date'],
            'assigned_to' => $validated['assigned_to'],
            'status_type' => $validated['status_type'],
            'priority' => $validated['priority'],
            'task_type' => $validated['task_type'],
            'script' => $request->script,
            'description' => $validated['description'],
        ]);

        // Create associated note if description exists
        if (!empty($validated['description'])) {
            Note::create([
                'customer_id' => $validated['customer_id'],
                'deal_id'     => $validated['deal_id'],
                'task_id'     => $task->id,
                'description' => $validated['description'],
                'type'        => 'Task Note',
                'created_by'  => $request->user()?->id ?? auth()->user()->id,
            ]);
        }

        // Log activity
        Activity::create([
            'deal_id'     => $validated['deal_id'],
            'customer_id' => $validated['customer_id'],
            'user_id'     => $request->user()?->id ?? auth()->user()->id,
            'type'        => 'task_created',
            'description' => "Task '{$validated['task_type']}' created"
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Task created successfully',
            'data'    => $task->load(['assignedUser', 'deal'])
        ]);
    }

    /**
     * Fetch tasks via AJAX with optional filters.
     */
    public function taskFetchByAjax(Request $request)
    {
        $query = Task::with([
            'notes' => function($q) {
                $q->select('id', 'task_id', 'description', 'created_by', 'created_at')
                  ->with('createdBy:id,name');
            },
            'deal:id,deal_number,vehicle_description,status',
            'customer:id,first_name,last_name',
            'assignedUser:id,name',
            'createdBy:id,name'
        ]);

        // Filter by customer
        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by deal
        if ($request->has('deal_id')) {
            $query->where('deal_id', $request->deal_id);
        }

        // Filter by status
        if ($request->has('status_type')) {
            $query->where('status_type', $request->status_type);
        }

        // Filter by priority
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by assigned user
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by date range
        if ($request->has('from_date')) {
            $query->whereDate('due_date', '>=', $request->from_date);
        }
        if ($request->has('to_date')) {
            $query->whereDate('due_date', '<=', $request->to_date);
        }

        $tasks = $query->latest()->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Tasks fetched successfully',
            'data'    => $tasks
        ]);
    }

    /**
     * Get a single task for editing.
     */
    public function edit($id)
    {
        $task = Task::with([
            'customer.deals',
            'deal',
            'assignedUser',
            'notes'
        ])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => $task
        ]);
    }

    /**
     * Update a task.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'deal_id'     => 'required|integer|exists:deals,id',
            'due_date'    => 'required|date',
            'assigned_to' => 'required|integer|exists:users,id',
            'status_type' => 'required|string',
            'task_type'   => 'required|string',
            'priority'    => 'required|string|in:High,Medium,Low',
            'script'      => 'nullable|string',
            'description' => 'nullable|string|max:500',
        ]);

        // Track changes
        $changes = [];
        foreach ($validated as $key => $value) {
            if ($task->$key != $value) {
                $changes[$key] = ['from' => $task->$key, 'to' => $value];
            }
        }

        $task->update($validated);

        // Log activity if changes made
        if (!empty($changes)) {
            Activity::create([
                'deal_id'     => $task->deal_id,
                'customer_id' => $task->customer_id,
                'user_id'     => Auth::id(),
                'type'        => 'task_updated',
                'description' => "Task '{$task->task_type}' updated"
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Task updated successfully',
            'data'    => $task->load(['assignedUser', 'deal'])
        ]);
    }

    /**
     * Update task status only.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status_type' => 'required|string'
        ]);

        $oldStatus = $task->status_type;
        $task->status_type = $validated['status_type'];
        $task->save();

        Activity::create([
            'deal_id'     => $task->deal_id,
            'customer_id' => $task->customer_id,
            'user_id'     => Auth::id(),
            'type'        => 'task_status_change',
            'description' => "Task status changed from '{$oldStatus}' to '{$validated['status_type']}'"
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Task status updated',
            'data'    => $task
        ]);
    }

    /**
     * Delete a task.
     */
    public function destroy(Task $task)
    {
        $taskType = $task->task_type;
        $dealId = $task->deal_id;
        $customerId = $task->customer_id;

        // Delete associated notes
        Note::where('task_id', $task->id)->delete();

        $task->delete();

        Activity::create([
            'deal_id'     => $dealId,
            'customer_id' => $customerId,
            'user_id'     => Auth::id(),
            'type'        => 'task_deleted',
            'description' => "Task '{$taskType}' was deleted"
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Task deleted successfully'
        ]);
    }

    /**
     * Get tasks for calendar view.
     */
    public function calendarTasks(Request $request)
    {
        $query = Task::select('id', 'task_type', 'due_date', 'priority', 'status_type', 'customer_id', 'deal_id')
            ->with(['customer:id,first_name,last_name', 'deal:id,vehicle_description']);

        if ($request->has('start')) {
            $query->whereDate('due_date', '>=', $request->start);
        }
        if ($request->has('end')) {
            $query->whereDate('due_date', '<=', $request->end);
        }

        $tasks = $query->get()->map(function($task) {
            return [
                'id'    => $task->id,
                'title' => $task->task_type . ' - ' . ($task->customer->first_name ?? ''),
                'start' => $task->due_date,
                'color' => $this->getPriorityColor($task->priority),
                'extendedProps' => [
                    'customer' => $task->customer,
                    'deal'     => $task->deal,
                    'status'   => $task->status_type,
                    'priority' => $task->priority
                ]
            ];
        });

        return response()->json($tasks);
    }

    /**
     * Get priority color for calendar.
     */
    private function getPriorityColor($priority)
    {
        return [
            'High'   => '#dc3545',
            'Medium' => '#ffc107',
            'Low'    => '#17a2b8'
        ][$priority] ?? '#6c757d';
    }
}