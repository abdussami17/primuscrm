<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Support\Facades\Auth;

class TemplateService
{
    /**
     * Create a new template
     */
    public function create(array $data): Template
    {
        $data['created_by'] = Auth::id();
        $data['is_active'] = $data['is_active'] ?? true;

        return Template::create($data);
    }

    /**
     * Update an existing template
     */
    public function update(Template $template, array $data): Template
    {
        $template->update($data);
        return $template->fresh();
    }

    /**
     * Duplicate a template
     */
    public function duplicate(Template $template, ?string $newName = null): Template
    {
        $newTemplate = $template->replicate();
        $newTemplate->name = $newName ?? ($template->name . ' (Copy)');
        $newTemplate->created_by = Auth::id();
        $newTemplate->save();

        return $newTemplate;
    }

    /**
     * Delete multiple templates
     */
    public function deleteMultiple(array $ids): int
    {
        return Template::whereIn('id', $ids)->delete();
    }

    /**
     * Get templates with filters
     */
    public function getFilteredTemplates(array $filters = [])
    {
        $query = Template::with(['category', 'creator']);

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('subject', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->latest()->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get sample data for preview
     */
    public function getSampleData(): array
    {
        return [
            'first_name' => 'Michael',
            'last_name' => 'Smith',
            'email' => 'michael.smith@email.com',
            'cell_phone' => '(555) 123-4567',
            'dealer_name' => 'Primus Motors',
            'dealer_phone' => '222-333-4444',
            'year' => '2025',
            'make' => 'Ferrari',
            'model' => 'F80',
            'selling_price' => '$50,000',
        ];
    }

    /**
     * Get merge fields configuration
     */
    public function getMergeFields(): array
    {
        return [
            'customer' => [
                'name' => 'Customer Information',
                'icon' => 'person',
                'fields' => [
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
            ],
            'vehicle' => [
                'name' => 'Vehicle Information',
                'icon' => 'car-front',
                'fields' => [
                    ['name' => 'Year', 'token' => 'year'],
                    ['name' => 'Make', 'token' => 'make'],
                    ['name' => 'Model', 'token' => 'model'],
                    ['name' => 'VIN', 'token' => 'vin'],
                    ['name' => 'Stock Number', 'token' => 'stock_number'],
                    ['name' => 'Selling Price', 'token' => 'selling_price'],
                    ['name' => 'Internet Price', 'token' => 'internet_price'],
                    ['name' => 'KMs', 'token' => 'kms'],
                ],
            ],
            'dealership' => [
                'name' => 'Dealership',
                'icon' => 'building',
                'fields' => [
                    ['name' => 'Dealership Name', 'token' => 'dealer_name'],
                    ['name' => 'Dealership Phone', 'token' => 'dealer_phone'],
                    ['name' => 'Dealership Address', 'token' => 'dealer_address'],
                    ['name' => 'Dealership Email', 'token' => 'dealer_email'],
                    ['name' => 'Dealership Website', 'token' => 'dealer_website'],
                ],
            ],
            'deal' => [
                'name' => 'Deal Information',
                'icon' => 'file-earmark-text',
                'fields' => [
                    ['name' => 'Finance Manager', 'token' => 'finance_manager'],
                    ['name' => 'Assigned To', 'token' => 'assigned_to_full_name'],
                    ['name' => 'Service Advisor', 'token' => 'service_advisor'],
                    ['name' => 'Source', 'token' => 'source'],
                    ['name' => 'Appointment Date/Time', 'token' => 'appointment_datetime'],
                ],
            ],
        ];
    }
}