<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateRequest;
use App\Models\Template;
use App\Models\TemplateCategory;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Validator;
use Auth;
class TemplateController extends Controller
{
    protected $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    /**
     * Display a listing of the templates.
     */
    public function index(Request $request)
    {
        // Default to showing email templates when no explicit type is provided
        $type = $request->get('type', 'email');

        $query = Template::with(['category', 'creator'])
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('subject', 'like', "%{$request->search}%");
            })
            ->when($type, function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->when($request->category_id, function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });

        $templates = $query->latest()->get();
        $categories = TemplateCategory::active()->ordered()->get();
        $mergeFields = $this->getMergeFields();
        $sampleData = $this->getSampleData();

        return view('templates.index', compact('templates', 'categories', 'mergeFields', 'sampleData'));
    }
    
    /**
     * Return JSON for DataTables server-side processing
     */
    public function data(Request $request)
    {
        $columnsMap = [0 => null, 1 => 'name', 2 => 'type', 3 => 'created_at', 4 => null];

        $draw = intval($request->input('draw'));
        $start = intval($request->input('start'));
        $length = intval($request->input('length', 10));
        $search = $request->input('search.value');
        $type = $request->input('type');

        // Base query — respect optional 'type' filter (used by mobile view)
        $baseQuery = Template::query();
        if ($type) {
            $baseQuery->where('type', $type);
        }

        // Total records for this base filter (before search)
        $recordsTotal = $baseQuery->count();

        // Work on a fresh query for applying search/ordering/pagination
        $query = Template::query();
        if ($type) {
            $query->where('type', $type);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // Count after applying search
        $recordsFiltered = $query->count();

        // Ordering
        if ($request->has('order')) {
            $order = $request->input('order')[0];
            $colIdx = intval($order['column']);
            $dir = $order['dir'] === 'asc' ? 'asc' : 'desc';
            $colName = $columnsMap[$colIdx] ?? null;
            if ($colName) $query->orderBy($colName, $dir);
        } else {
            $query->latest('created_at');
        }

        $rows = $query->skip($start)->take($length)->get(['id', 'name', 'type', 'created_at']);

        $data = $rows->map(function ($t) {
            return [
                'id' => $t->id,
                'name' => $t->name,
                'type' => ucfirst($t->type),
                'created_at' => $t->created_at->format('Y-m-d'),
            ];
        });

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }



    /**
     * Show the form for creating a new template.
     */
    public function create()
    {
        $categories = TemplateCategory::active()->ordered()->get();
        $mergeFields = $this->getMergeFields();
        
        return view('templates.create', compact('categories', 'mergeFields'));
    }

    /**
     * Store a newly created template in storage.
     */
    public function store(Request $request)
    {
        // Log incoming request for debugging
        \Log::info('Template Store Request', [
            'all_data' => $request->all(),
            'body_field' => $request->input('body'),
            'has_body' => $request->has('body'),
        ]);
       $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:500',
            'type' => 'nullable|in:email,text',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:template_categories,id',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed', ['errors' => $validator->errors()->toArray()]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $template = Template::create([
            'name' => $request->input('name'),
            'subject' => $request->input('subject'),
            'type' => $request->input('type'),
            'body' => $request->input('body'),
            'category_id' => $request->input('category_id'),
            'is_active' => $request->input('is_active', true),
            'created_by' => Auth::id(),
        ]);

        \Log::info('Template created', ['id' => $template->id]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Template created successfully!',
                'template' => $template
            ]);
        }

        return redirect()->route('templates.index')
            ->with('success', 'Template created successfully!');
    }

    /**
     * Display the specified template.
     */
    public function show(Template $template)
    {
        $template->load(['category', 'creator']);
        $sampleData = $this->getSampleData();
        $preview = $template->replaceMergeFields($sampleData);

        return view('templates.show', compact('template', 'preview'));
    }

    /**
     * Show the form for editing the specified template.
     */
    public function edit(Request $request, Template $template)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'id' => $template->id,
                'name' => $template->name,
                'subject' => $template->subject,
                'type' => $template->type,
                'body' => $template->body,
                'category_id' => $template->category_id,
                'is_active' => $template->is_active,
            ]);
        }

        $categories = TemplateCategory::active()->ordered()->get();
        $mergeFields = $this->getMergeFields();
        $sampleData = $this->getSampleData();
        
        return view('templates.edit', compact('template', 'categories', 'mergeFields', 'sampleData'));
    }

    /**
     * Update the specified template in storage.
     */
    public function update(Request $request, Template $template)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:500',
            'type' => 'required|in:email,text',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:template_categories,id',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $template->update([
            'name' => $request->name,
            'subject' => $request->subject,
            'type' => $request->type ?? 'email',
            'body' => $request->body,
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active') ? true : true,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Template updated successfully!',
                'template' => $template
            ]);
        }

        return redirect()->route('templates.index')
            ->with('success', 'Template updated successfully!');
    }

    /**
     * Remove the specified template from storage.
     */
    public function destroy(Template $template)
    {
        $template->delete();

        return redirect()->route('templates.index')
            ->with('success', 'Template deleted successfully!');
    }

    /**
     * Duplicate a template
     */
    public function duplicate(Template $template)
    {
        $newTemplate = $template->replicate();
        $newTemplate->name = $template->name . ' (Copy)';
        $newTemplate->created_by = Auth::id();
        $newTemplate->save();

        return redirect()->route('templates.index')
            ->with('success', 'Template duplicated successfully!');
    }

    /**
     * Delete multiple templates
     */
    public function destroyMultiple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:templates,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid template IDs'], 422);
        }

        Template::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => 'Templates deleted successfully!']);
    }

    /**
     * Preview template with sample data
     */
    public function preview(Request $request, Template $template)
    {
        $sampleData = $this->getSampleData();
        $preview = $template->replaceMergeFields($sampleData);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => $preview,
                'subject' => str_replace(
                    array_map(fn($k) => "@{{ {$k} }}", array_keys($sampleData)),
                    array_values($sampleData),
                    $template->subject
                ),
            ]);
        }

        return view('templates.preview', compact('template', 'preview'));
    }

    /**
     * Get merge fields organized by category
     */
    private function getMergeFields(): array
    {
        return [
            'customer' => [
                ['name' => 'First Name', 'token' => 'first_name'],
                ['name' => 'Last Name', 'token' => 'last_name'],
                ['name' => 'Email', 'token' => 'email'],
                ['name' => 'Alternative Email', 'token' => 'alt_email'],
                ['name' => 'Cell Phone', 'token' => 'cell_phone'],
                ['name' => 'Work Phone', 'token' => 'work_phone'],
                ['name' => 'Home Phone', 'token' => 'home_phone'],
                ['name' => 'Street Address', 'token' => 'street_address'],
                ['name' => 'City', 'token' => 'city'],
                ['name' => 'Province', 'token' => 'province'],
                ['name' => 'Postal Code', 'token' => 'postal_code'],
                ['name' => 'Country', 'token' => 'country'],
            ],
            'vehicle' => [
                ['name' => 'Year', 'token' => 'year'],
                ['name' => 'Make', 'token' => 'make'],
                ['name' => 'Model', 'token' => 'model'],
                ['name' => 'VIN', 'token' => 'vin'],
                ['name' => 'Stock Number', 'token' => 'stock_number'],
                ['name' => 'Selling Price', 'token' => 'selling_price'],
                ['name' => 'Internet Price', 'token' => 'internet_price'],
                ['name' => 'KMs', 'token' => 'kms'],
            ],
            'dealership' => [
                ['name' => 'Dealership Name', 'token' => 'dealer_name'],
                ['name' => 'Dealership Phone', 'token' => 'dealer_phone'],
                ['name' => 'Dealership Address', 'token' => 'dealer_address'],
                ['name' => 'Dealership Email', 'token' => 'dealer_email'],
                ['name' => 'Dealership Website', 'token' => 'dealer_website'],
            ],
            'deal' => [
                ['name' => 'Finance Manager', 'token' => 'finance_manager'],
                ['name' => 'Assigned To', 'token' => 'assigned_to_full_name'],
                ['name' => 'Assigned To Email', 'token' => 'assigned_to_email'],
                ['name' => 'Service Advisor', 'token' => 'service_advisor'],
                ['name' => 'Source', 'token' => 'source'],
                ['name' => 'Appointment Date/Time', 'token' => 'appointment_datetime'],
            ],
        ];
    }

    /**
     * Get sample data for preview
     */
    private function getSampleData(): array
    {
        return [
            'first_name' => 'Michael',
            'last_name' => 'Smith',
            'email' => 'michael.smith@email.com',
            'alt_email' => 'm.smith@work.com',
            'cell_phone' => '(555) 123-4567',
            'work_phone' => '(555) 890-1234',
            'home_phone' => '(555) 567-8901',
            'street_address' => '611 Padget Lane',
            'city' => 'Saskatoon',
            'province' => 'Saskatchewan',
            'postal_code' => 'S7W 0H3',
            'country' => 'Canada',
            'dealer_name' => 'Primus Motors',
            'dealer_phone' => '222-333-4444',
            'dealer_address' => '123 Main Street, Vancouver, BC, V5K 2X8',
            'dealer_email' => 'dealer@dealer.com',
            'dealer_website' => 'www.primusmotors.ca',
            'year' => '2025',
            'make' => 'Ferrari',
            'model' => 'F80',
            'vin' => '12345678ABCDEFGHI',
            'stock_number' => '10101',
            'selling_price' => '$50,000',
            'internet_price' => '$49,000',
            'kms' => '35,000',
            'finance_manager' => 'Robert Wilson',
            'assigned_to_full_name' => 'Michael Scott',
            'assigned_to_email' => 'michael.scott@dealership.com',
            'service_advisor' => 'Lisa Thompson',
            'source' => 'Website Inquiry',
            'appointment_datetime' => 'Oct 14, 2025 10:00AM',
        ];
    }
}