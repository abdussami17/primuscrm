<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deal;
use App\Models\Customer;
use App\Models\User;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if customer with ID 1 exists
        $customer = Customer::find(1);
        
        if (!$customer) {
            $this->command->error('Customer with ID 1 not found. Please create a customer first.');
            return;
        }

        // Get first user for sales person (if exists)
        $user = User::first();

        // Create a sample deal for customer ID 1
        Deal::create([
            'customer_id' => 1,
            'deal_number' => 'DEAL-' . now()->format('Ymd') . '-001',
            'status' => 'Active',
            'lead_type' => 'Walk-In',
            'inventory_type' => 'New',
            'vehicle_description' => '2025 Toyota Camry XLE',
            'price' => 32500.00,
            'down_payment' => 5000.00,
            'trade_in_value' => 8000.00,
            'sales_person_id' => $user?->id,
            'sales_manager_id' => $user?->id,
            'finance_manager_id' => $user?->id,
            'notes' => 'Customer interested in financing options. Approved for 5-year term.',
        ]);

        $this->command->info('Deal created successfully for Customer ID 1');
    }
}
