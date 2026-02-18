<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Add your authorization logic here
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'payment_type' => ['required', Rule::in(['lease', 'finance', 'cash'])],
            
            // Common fields
            'down_payment' => ['nullable', 'numeric', 'min:0'],
            'deposit_received' => ['nullable', 'numeric', 'min:0'],
            'trade_in_value' => ['nullable', 'numeric', 'min:0'],
            'trade_in' => ['nullable', 'numeric', 'min:0'], // Alias used in lease form
            'lien_payout' => ['nullable', 'numeric', 'min:0'],
            'admin_fee' => ['nullable', 'numeric', 'min:0'],
            'doc_fee' => ['nullable', 'numeric', 'min:0'],
            'front_end_gross' => ['nullable', 'numeric'],
            'back_end_gross' => ['nullable', 'numeric'],
            'total_gross' => ['nullable', 'numeric'],
            'credit_score' => ['nullable', 'string', 'max:50'],
        ];

        // Add type-specific rules based on payment_type
        $paymentType = $this->input('payment_type');

        if ($paymentType === 'lease') {
            $rules = array_merge($rules, $this->leaseRules());
        } elseif ($paymentType === 'finance') {
            $rules = array_merge($rules, $this->financeRules());
        } elseif ($paymentType === 'cash') {
            $rules = array_merge($rules, $this->cashRules());
        }

        return $rules;
    }

    /**
     * Lease-specific validation rules.
     */
    private function leaseRules(): array
    {
        return [
            'lease_company' => ['nullable', 'string', 'max:255'],
            'lease_program' => ['nullable', 'string', 'max:255'],
            'money_factor' => ['nullable', 'numeric', 'min:0', 'max:1'],
            'term' => ['nullable', 'integer', 'min:12', 'max:84'],
            'payment_frequency' => ['nullable', 'string', Rule::in(['Monthly', 'Bi-weekly', 'Weekly'])],
            'miles_per_year' => ['nullable', 'integer', 'min:0'],
            'excess_mileage' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'residual_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'residual_value' => ['nullable', 'numeric', 'min:0'],
            'monthly_payment' => ['nullable', 'numeric', 'min:0'],
            'due_at_signing' => ['nullable', 'numeric', 'min:0'],
            'lease_start' => ['nullable', 'date'],
            'lease_end' => ['nullable', 'date', 'after_or_equal:lease_start'],
            'buyout_amount' => ['nullable', 'numeric', 'min:0'],
            'lease_gross' => ['nullable', 'numeric'],
            'reserve_fee' => ['nullable', 'numeric'],
            'backend_gross' => ['nullable', 'numeric'],
            'total_profit' => ['nullable', 'numeric'],
        ];
    }

    /**
     * Finance-specific validation rules.
     */
    private function financeRules(): array
    {
        return [
            'lender_name' => ['nullable', 'string', 'max:255'],
            'lender_code' => ['nullable', 'string', 'max:100'],
            'interest_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'term' => ['nullable', 'integer', 'min:12', 'max:120'],
            'payment_frequency' => ['nullable', 'string', Rule::in(['Monthly', 'Bi-weekly', 'Weekly'])],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'monthly_payment' => ['nullable', 'numeric', 'min:0'],
            'bank_fee' => ['nullable', 'numeric', 'min:0'],
            'extended_warranty' => ['nullable', 'string', Rule::in(['Yes', 'No', 'Expired'])],
            'warranty_amount' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Cash-specific validation rules.
     */
    private function cashRules(): array
    {
        return [
            'payment_method' => ['nullable', 'string', Rule::in([
                'certified_cheque', 'wire', 'debit', 'eft', 'cash', 'credit_card'
            ])],
            'total_cash_received' => ['nullable', 'numeric', 'min:0'],
            'total_sale_amount' => ['nullable', 'numeric', 'min:0'],
            'delivered_date' => ['nullable', 'date'],
            'sold_date' => ['nullable', 'date'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'payment_type.required' => 'Payment type is required.',
            'payment_type.in' => 'Payment type must be lease, finance, or cash.',
            'lease_end.after_or_equal' => 'Lease end date must be after or equal to start date.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'money_factor.max' => 'Money factor seems too high. Please enter a value like 0.00125.',
            'residual_percent.max' => 'Residual percent cannot exceed 100%.',
            'interest_rate.max' => 'Interest rate cannot exceed 100%.',
        ];
    }

    /**
     * Prepare data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert empty strings to null for numeric fields
        $numericFields = [
            'down_payment', 'deposit_received', 'trade_in_value', 'trade_in',
            'lien_payout', 'admin_fee', 'doc_fee', 'front_end_gross',
            'back_end_gross', 'total_gross', 'money_factor', 'excess_mileage',
            'selling_price', 'residual_percent', 'residual_value',
            'monthly_payment', 'due_at_signing', 'buyout_amount', 'lease_gross',
            'reserve_fee', 'backend_gross', 'total_profit', 'interest_rate',
            'bank_fee', 'warranty_amount', 'total_cash_received', 'total_sale_amount',
        ];

        $data = [];
        foreach ($numericFields as $field) {
            if ($this->has($field) && $this->input($field) === '') {
                $data[$field] = null;
            }
        }

        if (!empty($data)) {
            $this->merge($data);
        }
    }
}