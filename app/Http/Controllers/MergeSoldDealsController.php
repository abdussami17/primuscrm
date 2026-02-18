<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Deal;
use App\Models\Note;
use App\Models\Task;
use App\Models\ShowroomVisit;
use App\Models\ServiceHistory;
use App\Models\TradeIn;

class MergeSoldDealsController extends Controller
{
    // Return a simple list of recent sold deals for the UI
    public function data(Request $request)
    {
        $deals = Deal::with(['customer', 'inventory', 'salesPerson', 'salesManager', 'financeManager'])
        ->orderBy('created_at', 'desc')
        ->where('status','sold')
        ->take(200)->get()->map(function($d){
            $inv = $d->inventory;
            return [
                'id' => $d->id,
                'deal_number' => $d->deal_number,
                'customer_id' => $d->customer?->id ?? null,
                'customer_name' => $d->customer?->full_name ?? '-',
                'customer_email' => $d->customer?->email ?? '',
                'customer_cell' => $d->customer?->cell_phone ?? '',
                'vehicle' => $inv ? trim(($inv->year ?? '') . ' ' . ($inv->make ?? '') . ' ' . ($inv->model ?? '')) : '',
                'inventory_id' => $inv?->id ?? null,
                'inventory_year' => $inv?->year ?? null,
                'inventory_make' => $inv?->make ?? null,
                'inventory_model' => $inv?->model ?? null,
                'inventory_stock' => $inv?->stock_number ?? null,
                'inventory_vin' => $inv?->vin ?? null,
                'lead_type' => $d->lead_type,
                'status' => $d->status,
                'sold_date' => $d->sold_date?->format('Y-m-d'),
                'delivery_date' => $d->delivery_date?->format('Y-m-d'),
                'sales_person' => $d->salesPerson?->name ?? null,
                'sales_manager' => $d->salesManager?->name ?? null,
                'finance_manager' => $d->financeManager?->name ?? null,
                'price' => $d->price ?? null,
                'down_payment' => $d->down_payment ?? null,
                'trade_in_value' => $d->trade_in_value ?? null,
                'created_at' => $d->created_at?->toDateTimeString(),
            ];
        });

        return response()->json(['success' => true, 'data' => $deals]);
    }

    // Merge two deals. selected_fields is an object: { fieldName: 'left'|'right' }
    public function merge(Request $request)
    {
        $data = $request->validate([
            'left_id' => 'required|integer|exists:deals,id',
            'right_id' => 'required|integer|exists:deals,id',
            'selected_fields' => 'required|array'
        ]);

        $left = Deal::findOrFail($data['left_id']);
        $right = Deal::findOrFail($data['right_id']);

        // pick primary deal: prefer the one with a deal_number (DMS ID)
        $primary = null; $secondary = null;
        if ($left->deal_number && !$right->deal_number) { $primary = $left; $secondary = $right; }
        elseif ($right->deal_number && !$left->deal_number) { $primary = $right; $secondary = $left; }
        else { $primary = $left; $secondary = $right; }

        DB::beginTransaction();
        try {
            // Apply selected fields
            foreach ($data['selected_fields'] as $field => $choice) {
                if (!in_array($field, ['deal_number','lead_type','status','sold_date','delivery_date','inventory_id','price'])) continue;
                if ($choice === 'left') {
                    $value = ($left->{$field} ?? null);
                } else {
                    $value = ($right->{$field} ?? null);
                }
                $primary->{$field} = $value;
            }

            $primary->save();

            // Reassign common relations from secondary -> primary
            Note::where('deal_id', $secondary->id)->update(['deal_id' => $primary->id]);
            Task::where('deal_id', $secondary->id)->update(['deal_id' => $primary->id]);
            ShowroomVisit::where('deal_id', $secondary->id)->update(['deal_id' => $primary->id]);
            ServiceHistory::where('deals_id', $secondary->id)->update(['deals_id' => $primary->id]);
            TradeIn::where('deal_id', $secondary->id)->update(['deal_id' => $primary->id]);

            // soft-delete secondary to preserve history
            $secondary->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Deals merged', 'primary_id' => $primary->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
