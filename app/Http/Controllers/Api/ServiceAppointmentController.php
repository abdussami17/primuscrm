<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Deal;
class ServiceAppointmentController extends Controller
{

    public function serviceHistoryPartial(Deal $deal)
    {
        $serviceHistory = $deal->serviceHistory()
            ->latest()
            ->get();

        return response()
            ->view(
                'customers.partials.vehicles.service-history',
                compact('serviceHistory'),
                200
            );
    }

    public function store(Request $request)
    {
        // ✅ Validate incoming data
        $validator = Validator::make($request->all(), [
            'roNumber'         => 'required|string|max:255',
            'deals_id'         =>'required',
            'serviceDate'      => 'required|date',
            'serviceType'      => 'required|string|max:255',
            'laborCost'        => 'nullable|numeric|min:0',
            'partsCost'        => 'nullable|numeric|min:0',
            'totalCost'        => 'required|numeric|min:0',
            'description'      => 'nullable|string',
            'technician'       => 'nullable|string|max:255',
            'completedDate'    => 'nullable|date',
            'currentKms'       => 'nullable|integer|min:0',
            'serviceAdvisor'   => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error'   => $validator->errors()->first()
            ], 422);
        }

        try {
            $service = ServiceHistory::create([
                'inventory_id' => $request->inventory_id ?? null,
                'deals_id'  => $request->deals_id ?? null,
                'customer_id'  => $request->customer_id ?? null,

                'service_date' => $request->serviceDate,
                'service_type' => $request->serviceType,
                'description'  => $request->description,

                'mileage'      => $request->currentKms,
                'cost'         => $request->totalCost,

                'advisor_name' => $request->serviceAdvisor,
                'technician'   => $request->technician,

                // optional structured data
                'parts_used'   => [
                    'parts_cost' => (float) $request->partsCost,
                    'labor_cost' => (float) $request->laborCost,
                ],

                'labor_hours'  => null,
                'notes'        => $request->internalDepartment ?? null,
                'ro_number'    => $request->roNumber,
            ]);

            return response()->json([
                'success' => true,
                'data'    => $service
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
