<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->get('view', 'week');
        $currentDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        $date = Carbon::parse($currentDate);

        // Get users for filters
        $users = User::select('id', 'name')->orderBy('name')->get();

        // Build task query with filters
        $taskQuery = Task::with(['customer','taskNotes', 'deal', 'assignedUser', 'createdBy']);

        // Apply filters
        if ($request->filled('status_type')) {
            $taskQuery->whereIn('status_type', (array) $request->status_type);
        }
        if ($request->filled('task_type')) {
            $taskQuery->whereIn('task_type', (array) $request->task_type);
        }
        if ($request->filled('assigned_to')) {
            $taskQuery->whereIn('assigned_to', (array) $request->assigned_to);
        }
        if ($request->filled('created_by')) {
            $taskQuery->whereIn('created_by', (array) $request->created_by);
        }
        if ($request->filled('priority')) {
            $taskQuery->whereIn('priority', (array) $request->priority);
        }
        // Lead Status (customer)
if ($request->filled('lead_status')) {
    $taskQuery->whereHas('customer', function ($q) use ($request) {
        $q->whereIn('status', (array) $request->lead_status);
    });
}

// Lead Type
if ($request->filled('lead_type')) {
    $taskQuery->whereHas('deal', function ($q) use ($request) {
        $q->whereIn('lead_type', (array) $request->lead_type);
    });
}

// Inventory Type
if ($request->filled('inventory_type')) {
    $taskQuery->whereHas('deal', function ($q) use ($request) {
        $q->whereIn('inventory_type', (array) $request->inventory_type);
    });
}

// Sales Status
if ($request->filled('sales_status')) {
    $taskQuery->whereHas('deal', function ($q) use ($request) {
        $q->whereIn('status', (array) $request->sales_status);
    });
}

// Assigned By
if ($request->filled('assigned_by')) {
    $taskQuery->whereIn('created_by', (array) $request->assigned_by);
}

// Automated (boolean)
if ($request->filled('automated')) {
    $taskQuery->whereIn('is_automated', (array) $request->automated);
}


        // Calculate date ranges and navigation dates based on view
        switch ($view) {
            case 'month':
                $startDate = $date->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
                $endDate = $date->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);
                $prevDate = $date->copy()->subMonth()->format('Y-m-d');
                $nextDate = $date->copy()->addMonth()->format('Y-m-d');
                $dateDisplay = $date->format('F Y');
                break;

            case 'day':
                $startDate = $date->copy()->startOfDay();
                $endDate = $date->copy()->endOfDay();
                $prevDate = $date->copy()->subDay()->format('Y-m-d');
                $nextDate = $date->copy()->addDay()->format('Y-m-d');
                $dateDisplay = $date->format('l, F j, Y');
                break;

            default: // week
                $startDate = $date->copy()->startOfWeek(Carbon::SUNDAY);
                $endDate = $date->copy()->endOfWeek(Carbon::SATURDAY);
                $prevDate = $date->copy()->subWeek()->format('Y-m-d');
                $nextDate = $date->copy()->addWeek()->format('Y-m-d');
                
                if ($startDate->month === $endDate->month) {
                    $dateDisplay = $startDate->format('M j') . ' – ' . $endDate->format('j, Y');
                } else {
                    $dateDisplay = $startDate->format('M j') . ' – ' . $endDate->format('M j, Y');
                }
                break;
        }

        // Get tasks within date range
        $tasks = $taskQuery->whereDate('due_date', '>=', $startDate)
            ->whereDate('due_date', '<=', $endDate)
            ->orderBy('due_date')
            ->get();

        // Add computed properties to tasks
        $tasks->each(function ($task) {
            $task->due_time = $task->due_date ? Carbon::parse($task->due_date)->format('g:i A') : '';
            $task->task_type_class = $this->getTaskTypeClass($task->task_type);
        });

        // Prepare view-specific data
        $calendarWeeks = [];
        $weekDays = [];
        $dayTasks = collect();

        if ($view === 'month') {
            $calendarWeeks = $this->buildMonthCalendar($startDate, $endDate, $date, $tasks);
        } elseif ($view === 'week') {
            $weekDays = $this->buildWeekCalendar($startDate, $tasks);
        } else {
            $dayTasks = $tasks;
        }

        // Get all tasks for modals (within current view range)
        $allTasks = $tasks;

        return view('calendar.index', compact(
            'view',
            'currentDate',
            'prevDate',
            'nextDate',
            'dateDisplay',
            'users',
            'calendarWeeks',
            'weekDays',
            'dayTasks',
            'allTasks'
        ));
    }

    private function buildMonthCalendar($startDate, $endDate, $currentMonth, $tasks)
    {
        $weeks = [];
        $current = $startDate->copy();
        $today = Carbon::today();

        while ($current <= $endDate) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dayDate = $current->copy();
                $dayTasks = $tasks->filter(function ($task) use ($dayDate) {
                    return $task->due_date && Carbon::parse($task->due_date)->isSameDay($dayDate);
                });

                $week[] = [
                    'date' => $dayDate->format('Y-m-d'),
                    'day' => $dayDate->day,
                    'isCurrentMonth' => $dayDate->month === $currentMonth->month,
                    'isToday' => $dayDate->isSameDay($today),
                    'tasks' => $dayTasks,
                ];
                $current->addDay();
            }
            $weeks[] = $week;
        }

        return $weeks;
    }

    private function buildWeekCalendar($startDate, $tasks)
    {
        $days = [];
        $current = $startDate->copy();
        $today = Carbon::today();

        for ($i = 0; $i < 7; $i++) {
            $dayDate = $current->copy();
            $dayTasks = $tasks->filter(function ($task) use ($dayDate) {
                return $task->due_date && Carbon::parse($task->due_date)->isSameDay($dayDate);
            });

            $days[] = [
                'date' => $dayDate->format('Y-m-d'),
                'dayName' => $dayDate->format('D'),
                'dayNum' => $dayDate->format('M j'),
                'isToday' => $dayDate->isSameDay($today),
                'tasks' => $dayTasks,
            ];
            $current->addDay();
        }

        return $days;
    }

    private function getTaskTypeClass($taskType)
    {
        if (!$taskType) {
            return 'other';
        }

        $type = strtolower($taskType);

        if (str_contains($type, 'call') || str_contains($type, 'phone')) {
            return 'call';
        }
        if (str_contains($type, 'email')) {
            return 'email';
        }
        if (str_contains($type, 'text') || str_contains($type, 'sms')) {
            return 'text';
        }
        if (str_contains($type, 'appointment') || str_contains($type, 'meeting')) {
            return 'appointment';
        }

        return 'other';
    }

    public function updateTask(Request $request, Task $task)
    {
        $validated = $request->validate([
            'due_date_date' => 'nullable|date',
            'due_date_time' => 'nullable',
            'assigned_to' => 'nullable|exists:users,id',
            'task_type' => 'nullable|string|max:255',
            'status_type' => 'nullable|string|max:255',
            'priority' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'script' => 'nullable|string',
        ]);

        // Combine date and time
        if ($request->filled('due_date_date')) {
            $time = $request->get('due_date_time', '09:00');
            $validated['due_date'] = $request->due_date_date . ' ' . $time . ':00';
        }

        unset($validated['due_date_date'], $validated['due_date_time']);

        $task->update($validated);

        return redirect()->back()->with('success', 'Task updated successfully');
    }
}