<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateApiController extends Controller
{
    /**
     * Get template preview with custom data
     */
    public function preview(Request $request, Template $template)
    {
        $data = $request->validate([
            'merge_data' => 'required|array',
        ]);

        $preview = $template->replaceMergeFields($data['merge_data']);

        return response()->json([
            'success' => true,
            'preview' => $preview,
            'subject' => str_replace(
                array_map(fn($k) => "@{{ {$k} }}", array_keys($data['merge_data'])),
                array_values($data['merge_data']),
                $template->subject
            ),
        ]);
    }

    /**
     * Toggle template status
     */
    public function toggleStatus(Template $template)
    {
        $template->update([
            'is_active' => !$template->is_active,
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $template->is_active,
            'message' => 'Template status updated successfully',
        ]);
    }

    /**
     * Get merge fields
     */
    public function mergeFields()
    {
        $fields = [
            'customer' => [
                'name' => 'Customer Information',
                'icon' => 'person',
                'fields' => [
                    ['name' => 'First Name', 'token' => 'first_name'],
                    ['name' => 'Last Name', 'token' => 'last_name'],
                    ['name' => 'Email', 'token' => 'email'],
                    ['name' => 'Cell Phone', 'token' => 'cell_phone'],
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
                ],
            ],
        ];

        return response()->json($fields);
    }
}