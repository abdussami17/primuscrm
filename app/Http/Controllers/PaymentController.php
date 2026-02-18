<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Deal;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Store or update a payment for a deal.
     */
    public function store(StorePaymentRequest $request, Deal $deal): JsonResponse
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $paymentType = $validated['payment_type'];

            // Map form fields to database columns based on payment type
            $paymentData = $this->mapPaymentData($validated, $paymentType);
            $paymentData['deal_id'] = $deal->id;
            $paymentData['payment_type'] = $paymentType;

            // Update or create payment (one payment per deal per type, or just one per deal)
            $payment = Payment::updateOrCreate(
                [
                    'deal_id' => $deal->id,
                    'payment_type' => $paymentType,
                ],
                $paymentData
            );

            // Optionally update deal status
            $deal->update(['payment_type' => $paymentType]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ucfirst($paymentType) . ' payment saved successfully',
                'data' => $payment,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment save failed', [
                'deal_id' => $deal->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save payment',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred',
            ], 500);
        }
    }

    /**
     * Get payment details for a deal.
     */
    public function show(Deal $deal): JsonResponse
    {
        $payment = Payment::where('deal_id', $deal->id)->latest()->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'No payment found for this deal',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }

    /**
     * Delete a payment.
     */
    public function destroy(Deal $deal): JsonResponse
    {
        try {
            $deleted = Payment::where('deal_id', $deal->id)->delete();

            if ($deleted) {
                $deal->update(['payment_type' => null]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment deleted successfully',
            ]);

        } catch (\Exception $e) {
            Log::error('Payment delete failed', [
                'deal_id' => $deal->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete payment',
            ], 500);
        }
    }

    /**
     * Map incoming form data to database columns based on payment type.
     */
    private function mapPaymentData(array $data, string $paymentType): array
    {
        $mapped = [];

        // Common fields mapping
        $commonFields = [
            'down_payment',
            'deposit_received',
            'trade_in_value',
            'lien_payout',
            'admin_fee',
            'doc_fee',
            'front_end_gross',
            'back_end_gross',
            'total_gross',
            'credit_score',
        ];

        foreach ($commonFields as $field) {
            if (isset($data[$field])) {
                $mapped[$field] = $data[$field];
            }
        }

        // Also map 'trade_in' to 'trade_in_value' (lease form uses 'trade_in')
        if (isset($data['trade_in'])) {
            $mapped['trade_in_value'] = $data['trade_in'];
        }

        switch ($paymentType) {
            case 'lease':
                $mapped = array_merge($mapped, $this->mapLeaseData($data));
                break;
            case 'finance':
                $mapped = array_merge($mapped, $this->mapFinanceData($data));
                break;
            case 'cash':
                $mapped = array_merge($mapped, $this->mapCashData($data));
                break;
        }

        return $mapped;
    }

    /**
     * Map lease-specific fields.
     */
    private function mapLeaseData(array $data): array
    {
        return [
            'lease_company' => $data['lease_company'] ?? null,
            'lease_program' => $data['lease_program'] ?? null,
            'money_factor' => $data['money_factor'] ?? null,
            'lease_term' => $data['term'] ?? null,
            'lease_payment_frequency' => $data['payment_frequency'] ?? null,
            'miles_per_year' => $data['miles_per_year'] ?? null,
            'excess_mileage' => $data['excess_mileage'] ?? null,
            'selling_price' => $data['selling_price'] ?? null,
            'residual_percent' => $data['residual_percent'] ?? null,
            'residual_value' => $data['residual_value'] ?? null,
            'monthly_payment' => $data['monthly_payment'] ?? null,
            'due_at_signing' => $data['due_at_signing'] ?? null,
            'lease_start' => $data['lease_start'] ?? null,
            'lease_end' => $data['lease_end'] ?? null,
            'buyout_amount' => $data['buyout_amount'] ?? null,
            'lease_gross' => $data['lease_gross'] ?? null,
            'reserve_fee' => $data['reserve_fee'] ?? null,
            'total_profit' => $data['total_profit'] ?? null,
            'backend_gross' => $data['backend_gross'] ?? null,
        ];
    }

    /**
     * Map finance-specific fields.
     */
    private function mapFinanceData(array $data): array
    {
        return [
            'lender_name' => $data['lender_name'] ?? null,
            'lender_code' => $data['lender_code'] ?? null,
            'interest_rate' => $data['interest_rate'] ?? null,
            'finance_term' => $data['term'] ?? null,
            'finance_payment_frequency' => $data['payment_frequency'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'monthly_payment' => $data['monthly_payment'] ?? null,
            'bank_fee' => $data['bank_fee'] ?? null,
            'extended_warranty' => $data['extended_warranty'] ?? null,
            'warranty_amount' => $data['warranty_amount'] ?? null,
        ];
    }

    /**
     * Map cash-specific fields.
     */
    private function mapCashData(array $data): array
    {
        return [
            'payment_method' => $data['payment_method'] ?? null,
            'total_cash_received' => $data['total_cash_received'] ?? null,
            'total_sale_amount' => $data['total_sale_amount'] ?? null,
            'delivered_date' => $data['delivered_date'] ?? null,
            'sold_date' => $data['sold_date'] ?? null,
            'front_end_gross' => $data['front_end_gross'] ?? null,
            'back_end_gross' => $data['back_end_gross'] ?? null,
        ];
    }
}