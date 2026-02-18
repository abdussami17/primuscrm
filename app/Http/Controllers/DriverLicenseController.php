<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DriverLicenseController extends Controller
{
    /**
     * Upload driver's license images (front and back)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $request->validate([
            'front_image' => 'nullable|string',
            'back_image' => 'nullable|string',
        ]);

        $response = [
            'success' => true,
            'front_path' => null,
            'back_path' => null,
            'message' => 'Images uploaded successfully'
        ];

        try {
            // Process front image
            if ($request->filled('front_image')) {
                $response['front_path'] = $this->saveBase64Image(
                    $request->input('front_image'),
                    'license_front'
                );
            }

            // Process back image
            if ($request->filled('back_image')) {
                $response['back_path'] = $this->saveBase64Image(
                    $request->input('back_image'),
                    'license_back'
                );
            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload images: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save a base64 encoded image to storage
     *
     * @param string $base64Image
     * @param string $prefix
     * @return string The stored file path
     */
    protected function saveBase64Image(string $base64Image, string $prefix): string
    {
        // Remove data URL prefix if present (e.g., "data:image/png;base64,")
        if (str_contains($base64Image, ',')) {
            $base64Image = explode(',', $base64Image)[1];
        }

        // Decode the base64 string
        $imageData = base64_decode($base64Image);

        if ($imageData === false) {
            throw new \Exception('Invalid base64 image data');
        }

        // Generate unique filename
        $filename = $prefix . '_' . Str::uuid() . '_' . time() . '.png';
        $path = 'driver_licenses/' . date('Y/m') . '/' . $filename;

        // Store the image
        Storage::disk('public')->put($path, $imageData);

        return $path;
    }

    /**
     * Delete a driver's license image
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        try {
            $path = $request->input('path');
            
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage()
            ], 500);
        }
    }
}