<?php

namespace App\Http\Controllers;

use App\Models\TradeIn;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TradeInController extends Controller
{
    /**
     * Get trade-in for a deal
     */
    public function show($dealId)
    {
        $tradeIn = TradeIn::where('deal_id', $dealId)
            ->with('appraiser:id,name')
            ->first();

        return response()->json([
            'success' => true,
            'data' => $tradeIn
        ]);
    }

    /**
     * Store or update trade-in
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'deal_id' => 'required|exists:deals,id',
            'customer_id' => 'nullable|exists:customers,id',
            'vin' => 'nullable|string|max:17',
            'year' => 'nullable|integer|min:1900|max:2100',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'trim' => 'nullable|string|max:100',
            'odometer' => 'nullable|integer',
            'condition_grade' => 'nullable|string|in:excellent,good,fair,poor',
            'trade_allowance' => 'nullable|numeric|min:0',
            'lien_payout' => 'nullable|numeric|min:0',
            'acv' => 'nullable|numeric|min:0',
            'market_value' => 'nullable|numeric|min:0',
            'recon_estimate' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['appraised_by'] = Auth::id();
        $validated['appraisal_date'] = now();

        $tradeIn = TradeIn::updateOrCreate(
            ['deal_id' => $validated['deal_id']],
            $validated
        );

        // Log activity
        Activity::create([
            'deal_id' => $validated['deal_id'],
            'customer_id' => $validated['customer_id']??null,
            'user_id' => Auth::id(),
            'type' => 'trade_in_updated',
            'description' => 'Trade-in information updated'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trade-in saved successfully',
            'data' => $tradeIn
        ]);
    }

    /**
     * Upload trade-in photos
     */
    public function uploadPhotos(Request $request, TradeIn $tradeIn)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|max:5120' // 5MB max per image
        ]);

        $photos = $tradeIn->photos ?? [];

        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('trade-ins/' . $tradeIn->id, 'public');
            $photos[] = Storage::url($path);
        }

        $tradeIn->update(['photos' => $photos]);

        return response()->json([
            'success' => true,
            'message' => 'Photos uploaded',
            'photos' => $photos
        ]);
    }

    /**
     * Upload video walkaround
     */
    public function uploadVideo(Request $request, TradeIn $tradeIn)
    {
        $request->validate([
            'video' => 'required|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:102400' // 100MB max
        ]);

        $path = $request->file('video')->store('trade-ins/' . $tradeIn->id . '/videos', 'public');
        $tradeIn->update(['video_walkaround' => Storage::url($path)]);

        return response()->json([
            'success' => true,
            'message' => 'Video uploaded',
            'video_url' => Storage::url($path)
        ]);
    }

    /**
     * Decode VIN (placeholder - integrate with VIN decoder API)
     */
    public function decodeVin(Request $request)
    {
        $request->validate(['vin' => 'required|string|size:17']);

        // TODO: Integrate with actual VIN decoder API (NHTSA, DataOne, etc.)
        // This is a placeholder response
        return response()->json([
            'success' => true,
            'data' => [
                'vin' => $request->vin,
                'year' => null,
                'make' => null,
                'model' => null,
                'trim' => null,
                'message' => 'VIN decoder integration required'
            ]
        ]);
    }
}