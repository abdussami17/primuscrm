<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulkTaskDeleteController extends Controller
{
    /**
     * Get filter options for bulk delete
     */
    public function getFilters()
    {
        try {
            $users = User::where('is_active', 1)
                ->select('id', 'name')
                ->orderBy('name')
                ->get()
                ->toArray();
            
            $taskTypes = Task::distinct()
                ->whereNotNull('task_type')
                ->where('task_type', '!=', '')
                ->pluck('task_type')
                ->filter()
                ->values()
                ->toArray();
            
            $statuses = Task::distinct()
                ->whereNotNull('status_type')
                ->where('status_type', '!=', '')
                ->pluck('status_type')
                ->filter()
                ->values()
                ->toArray();
            
            $priorities = Task::distinct()
                ->whereNotNull('priority')
                ->where('priority', '!=', '')
                ->pluck('priority')
                ->filter()
                ->values()
                ->toArray();
            
            $response = [
                'users' => $users,
                'task_types' => $taskTypes,
                'statuses' => $statuses,
                'priorities' => $priorities,
            ];
            
            \Log::info('Task filters loaded:', $response);
            
            return response()->json($response);
        } catch (\Exception $e) {
            \Log::error('Error loading task filters: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'users' => [],
                'task_types' => [],
                'statuses' => [],
                'priorities' => [],
            ], 500);
        }
    }

    /**
     * Get tasks with filters
     */
    public function getTasks(Request $request)
    {
        $query = Task::with([
            'assignedUser:id,name',
            'createdBy:id,name',
            'customer:id,first_name,last_name',
            'deal:id,deal_number'
        ]);

        // Apply filters
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        if ($request->filled('task_type')) {
            $query->where('task_type', $request->task_type);
        }

        if ($request->filled('status')) {
            $query->where('status_type', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('due_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('due_date', '<=', $request->end_date);
        }

        $tasks = $query->latest()->get();

        $data = $tasks->map(function($task) {
            return [
                'id' => $task->id,
                'task_name' => $task->description ?? 'N/A',
                'task_type' => $task->task_type ?? 'N/A',
                'status' => $task->status_type ?? 'N/A',
                'priority' => $task->priority ?? 'N/A',
                'due_date' => $task->due_date ? date('M d, Y', strtotime($task->due_date)) : 'N/A',
                'assigned_to' => $task->assignedUser ? $task->assignedUser->name : 'N/A',
                'created_by' => $task->createdBy ? $task->createdBy->name : 'N/A',
                'customer' => $task->customer ? $task->customer->first_name . ' ' . $task->customer->last_name : 'N/A',
                'deal' => $task->deal ? $task->deal->deal_number : 'N/A',
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'items' => $data,
        ]);
    }

    /**
     * Get deletion history (grouped by deleted_at timestamps)
     */
    public function getDeletionHistory()
    {
        $history = Task::onlyTrashed()
            ->select('id', 'description', 'deleted_at', 'deleted_by')
            ->orderBy('deleted_at', 'desc')
            ->get()
            ->map(function($item) {
                $datetime = $item->deleted_at->format('M d, Y; h:i A');
                $taskName = $item->description ?? 'Unnamed Task';
                
                return [
                    'value' => $item->deleted_at->format('Y-m-d H:i:s') . '|' . ($item->deleted_by ?? ''),
                    'label' => $datetime . ' - ' . $taskName,
                ];
            });

        return response()->json($history);
    }

    /**
     * Get deleted tasks
     */
    public function getDeletedTasks(Request $request)
    {
        $query = Task::onlyTrashed()
            ->with([
                'assignedUser:id,name',
                'createdBy:id,name',
                'customer:id,first_name,last_name',
                'deal:id,deal_number'
            ]);

        // Filter by deletion history (datetime + user)
        if ($request->filled('deletion_date')) {
            $parts = explode('|', $request->deletion_date);
            if (count($parts) === 2) {
                $query->where('deleted_at', $parts[0])
                      ->where('deleted_by', $parts[1]);
            }
        }

        // Apply filters
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        if ($request->filled('task_type')) {
            $query->where('task_type', $request->task_type);
        }

        if ($request->filled('status')) {
            $query->where('status_type', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('due_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('due_date', '<=', $request->end_date);
        }

        $tasks = $query->latest('deleted_at')->get();

        $data = $tasks->map(function($task) {
            return [
                'id' => $task->id,
                'task_name' => $task->description ?? 'N/A',
                'task_type' => $task->task_type ?? 'N/A',
                'status' => $task->status_type ?? 'N/A',
                'priority' => $task->priority ?? 'N/A',
                'due_date' => $task->due_date ? date('M d, Y', strtotime($task->due_date)) : 'N/A',
                'assigned_to' => $task->assignedUser ? $task->assignedUser->name : 'N/A',
                'created_by' => $task->createdBy ? $task->createdBy->name : 'N/A',
                'customer' => $task->customer ? $task->customer->first_name . ' ' . $task->customer->last_name : 'N/A',
                'deal' => $task->deal ? $task->deal->deal_number : 'N/A',
                'deleted_date' => $task->deleted_at ? $task->deleted_at->format('M d, Y') : 'N/A',
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'items' => $data,
        ]);
    }

    /**
     * Bulk delete tasks
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'required|integer|exists:tasks,id',
        ]);

        try {
            $userId = Auth::id();
            
            // Update deleted_by before soft delete
            Task::whereIn('id', $request->task_ids)
                ->update(['deleted_by' => $userId]);
            
            $deletedCount = Task::whereIn('id', $request->task_ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "{$deletedCount} task(s) deleted successfully",
                'deleted_count' => $deletedCount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete tasks: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk restore tasks
     */
    public function bulkRestore(Request $request)
    {
        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'required|integer',
        ]);

        try {
            $restoredCount = Task::onlyTrashed()
                ->whereIn('id', $request->task_ids)
                ->restore();

            return response()->json([
                'success' => true,
                'message' => "{$restoredCount} task(s) restored successfully",
                'restored_count' => $restoredCount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore tasks: ' . $e->getMessage(),
            ], 500);
        }
    }
}
