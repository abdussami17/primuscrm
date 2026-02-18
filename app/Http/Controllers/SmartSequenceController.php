<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSmartSequenceRequest;
use App\Http\Requests\UpdateSmartSequenceRequest;
use App\Models\SmartSequence;
use App\Models\Template;
use App\Models\User;
use App\Services\SmartSequenceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class SmartSequenceController extends Controller
{
    public function __construct(
        protected SmartSequenceService $sequenceService
    ) {}

    /**
     * Display listing of sequences
     */
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->get('search'),
            'is_active' => $request->has('is_active') ? (bool)$request->get('is_active') : null,
            'created_by' => $request->get('created_by'),
            'sort_by' => $request->get('sort_by', 'created_at'),
            'sort_dir' => $request->get('sort_dir', 'desc'),
        ];

        $templates = Template::all();
        $sequences = $this->sequenceService->getSequences($filters, $request->get('per_page', 15));
        $users = User::with('roles')->select('id', 'name')->orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('smart-sequences.index', compact('sequences', 'users', 'filters', 'templates', 'roles'));
    }

    /**
     * Show create form with configuration data
     */
    public function create(): View
    {
        $fieldConfig = $this->sequenceService->getFieldConfiguration();
        $actionConfig = $this->sequenceService->getActionConfiguration();
        $templates = Template::active()->get();
        $users = User::with('roles')->select('id', 'name')->orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('smart-sequences.create', compact('fieldConfig', 'actionConfig', 'templates', 'users', 'roles'));
    }

    /**
     * Store a new sequence
     */
    public function store(StoreSmartSequenceRequest $request): RedirectResponse|JsonResponse
    {
        $sequence = $this->sequenceService->create(
            $request->validated(),
            auth()->id()
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Sequence created successfully.',
                'data' => $sequence->load(['criteriaGroups.criteria', 'actions', 'creator']),
            ], 201);
        }

        return redirect()
            ->route('smart-sequences.index')
            ->with('success', 'Sequence created successfully.');
    }

    /**
     * Show a single sequence
     */
    public function show(SmartSequence $smartSequence): View|JsonResponse
    {
        $smartSequence->load(['criteriaGroups.criteria', 'actions', 'creator', 'executionLogs' => function ($query) {
            $query->latest()->limit(50);
        }]);

        if (request()->wantsJson()) {
            return response()->json(['data' => $smartSequence]);
        }

        return view('smart-sequences.show', compact('smartSequence'));
    }

    /**
     * Show edit form
     */
    public function edit(SmartSequence $smartSequence): View
    {
        $smartSequence->load(['criteriaGroups.criteria', 'actions']);
        
        $fieldConfig = $this->sequenceService->getFieldConfiguration();
        $actionConfig = $this->sequenceService->getActionConfiguration();
        $templates = Template::active()->get();
        $users = User::with('roles')->select('id', 'name')->orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('smart-sequences.edit', compact('smartSequence', 'fieldConfig', 'actionConfig', 'templates', 'users', 'roles'));
    }

    /**
     * Update a sequence
     */
    public function update(UpdateSmartSequenceRequest $request, SmartSequence $smartSequence): RedirectResponse|JsonResponse
    {
        $sequence = $this->sequenceService->update($smartSequence, $request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Sequence updated successfully.',
                'data' => $sequence->load([
                    'criteriaGroups.criteria',
                    'actions',
                    'creator',
                    'editor'
                ]),
                
            ]);
        }

        return redirect()
            ->route('smart-sequences.index')
            ->with('success', 'Sequence updated successfully.');
    }

    /**
     * Delete a sequence
     */
    public function destroy(SmartSequence $smartSequence): RedirectResponse|JsonResponse
    {
        $this->sequenceService->delete($smartSequence);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sequence deleted successfully.',
            ]);
        }

        return redirect()
            ->route('smart-sequences.index')
            ->with('success', 'Sequence deleted successfully.');
    }

    /**
     * Toggle sequence active status
     */
    public function toggleStatus(SmartSequence $smartSequence): JsonResponse
    {
        $sequence = $this->sequenceService->toggleStatus($smartSequence);

        return response()->json([
            'success' => true,
            'is_active' => $sequence->is_active,
            'message' => $sequence->is_active ? 'Sequence activated.' : 'Sequence deactivated.',
        ]);
    }

    /**
     * Duplicate a sequence
     */
    public function duplicate(SmartSequence $smartSequence): RedirectResponse|JsonResponse
    {
        $newSequence = $this->sequenceService->duplicate($smartSequence);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sequence duplicated successfully.',
                'data' => $newSequence->load(['criteriaGroups.criteria', 'actions', 'creator']),
            ]);
        }

        return redirect()
            ->route('smart-sequences.edit', $newSequence)
            ->with('success', 'Sequence duplicated successfully. You can now edit the copy.');
    }

    /**
     * Bulk delete sequences by IDs
     */
    public function bulkDestroy(Request $request): RedirectResponse|JsonResponse
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No sequences selected.'], 400);
            }

            return redirect()->route('smart-sequences.index')->with('error', 'No sequences selected.');
        }

        $deleted = 0;

        $sequences = SmartSequence::whereIn('id', $ids)->get();

        foreach ($sequences as $sequence) {
            try {
                $this->sequenceService->delete($sequence);
                $deleted++;
            } catch (\Throwable $e) {
                // continue deleting others
                \Log::error('Error deleting sequence ' . $sequence->id . ': ' . $e->getMessage());
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Deleted {$deleted} sequence(s).",
                'deleted' => $deleted,
            ]);
        }

        return redirect()->route('smart-sequences.index')->with('success', "Deleted {$deleted} sequence(s).");
    }

    /**
     * Get field configuration for AJAX
     */
    public function getFieldConfig(): JsonResponse
    {
        return response()->json($this->sequenceService->getFieldConfiguration());
    }

    /**
     * Get action configuration for AJAX
     */
    public function getActionConfig(): JsonResponse
    {
        return response()->json($this->sequenceService->getActionConfiguration());
    }

    /**
     * Validate sequence actions
     */
    public function validateActions(SmartSequence $smartSequence): JsonResponse
    {
        $results = $this->sequenceService->validateSequenceActions($smartSequence);

        return response()->json([
            'success' => true,
            'validation_results' => $results,
            'all_valid' => !in_array(false, $results, true),
        ]);
    }

    /**
     * Get operators for a specific field
     */
    public function getFieldOperators(Request $request): JsonResponse
    {
        $fieldName = $request->get('field_name');
        
        if (!$fieldName) {
            return response()->json(['error' => 'Field name is required'], 400);
        }

        $operators = \App\Models\SequenceCriteria::getOperatorsForField($fieldName);
        $labels = \App\Models\SequenceCriteria::getOperatorLabels();

        $result = [];
        foreach ($operators as $op) {
            $result[] = [
                'value' => $op,
                'label' => $labels[$op] ?? $op,
            ];
        }

        return response()->json([
            'field_name' => $fieldName,
            'field_type' => \App\Models\SequenceCriteria::getFieldType($fieldName),
            'operators' => $result,
        ]);
    }

    /**
     * Export sequences
     */
    public function export(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $format = $request->get('format', 'csv');
        $sequences = SmartSequence::with('creator')->get();

        $headers = ['ID', 'Title', 'Status', 'Created By', 'Created On', 'Last Sent', 'Sent', 'Bounced', 'Invalid', 'Delivered', 'Opened', 'Clicked', 'Replied'];

        $callback = function() use ($sequences, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($sequences as $sequence) {
                fputcsv($file, [
                    $sequence->id,
                    $sequence->title,
                    $sequence->is_active ? 'Active' : 'Inactive',
                    $sequence->creator->name ?? 'N/A',
                    $sequence->created_at->format('M d, Y h:i A'),
                    $sequence->last_sent_at?->format('M d, Y') ?? 'Never',
                    $sequence->sent_count,
                    $sequence->bounced_count,
                    $sequence->invalid_count,
                    $sequence->delivered_count,
                    $sequence->opened_count,
                    $sequence->clicked_count,
                    $sequence->replied_count,
                ]);
            }

            fclose($file);
        };

        $filename = 'smart-sequences-' . now()->format('Y-m-d') . '.csv';

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}