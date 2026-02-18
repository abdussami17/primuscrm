<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateRequest;
use App\Models\Template;
use App\Models\TemplateCategory;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Validator;
use Auth;

class PhoneTemplateController extends Controller
{
     public function index(Request $request)
    {
        $query = Template::with(['category', 'creator'])
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('subject', 'like', "%{$request->search}%");
            })->where('type', 'text')
            ->when($request->category_id, function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });

        $templates = $query->latest()->paginate(15);
        $categories = TemplateCategory::active()->ordered()->get();
        $mergeFields = $this->getMergeFields();
        $sampleData = $this->getSampleData();
        $type='script';

        return view('templates.mobile.index', compact('templates', 'categories', 'mergeFields', 'sampleData'));
    }

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
