<?php

namespace App\Http\Controllers;

use App\Models\CustomerDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerDocumentController extends Controller
{
    public function getCustomerDocuments(Request $request, $customerId)
    {
        $dealId = $request->query('deal_id');

        $query = CustomerDocument::where('customer_id', $customerId);
        if ($dealId) $query->where('deals_id', $dealId);

        $documents = $query->with('uploader')->orderBy('created_at', 'desc')->get();

        $documentTypes = [
            'Bill of Sale',
            'Finance Agreement',
            'Lease Agreement',
            'Warranty Form',
            'Insurance Form',
            'Driver License',
            'Proof of Residence',
            'Proof of Insurance',
            'Trade-In Documents',
            'Other'
        ];

        return response()->json([
            'success' => true,
            'documents' => $documents,
            'documentTypes' => $documentTypes
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'deals_id' => 'nullable|exists:deals,id',
            'document_type' => 'required|string',
            'document_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240', // optional file
            'notes' => 'nullable|string'
        ]);

        try {
            $filePath = null;
            $fileName = null;
            $fileSize = null;

            if ($request->hasFile('document_file')) {
    $file = $request->file('document_file');
    $originalName = $file->getClientOriginalName();
    $extension = $file->getClientOriginalExtension();

    $fileName = $originalName;
    $uniqueName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;

    $fileSize = round($file->getSize() / 1024, 2) . ' KB'; // get size before moving
    $file->move(public_path('uploads/documents'), $uniqueName);
    $filePath = 'uploads/documents/' . $uniqueName;
}


            $document = CustomerDocument::create([
                'customer_id' => $validated['customer_id'],
                'deals_id' => $validated['deals_id'] ?? null,
                'document_type' => $validated['document_type'],
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'notes' => $validated['notes'] ?? null,
                'uploaded_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully',
                'document' => $document
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload document: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(CustomerDocument $document)
    {
        try {
            if ($document->file_path && file_exists(public_path($document->file_path))) {
                unlink(public_path($document->file_path));
            }

            $document->delete();

            return response()->json(['success' => true, 'message' => 'Document deleted']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function download(CustomerDocument $document)
    {
        $fullPath = public_path($document->file_path);
        if (!$document->file_path || !file_exists($fullPath)) abort(404, 'File not found');

        return response()->download($fullPath, $document->file_name);
    }
}
