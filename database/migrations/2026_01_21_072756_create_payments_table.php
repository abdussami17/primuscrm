<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained()->onDelete('cascade');
            $table->enum('payment_type', ['lease', 'finance', 'cash']);
            
            // Common fields
            $table->decimal('down_payment', 12, 2)->nullable();
            $table->decimal('deposit_received', 12, 2)->nullable();
            $table->decimal('trade_in_value', 12, 2)->nullable();
            $table->decimal('lien_payout', 12, 2)->nullable();
            $table->decimal('admin_fee', 12, 2)->nullable();
            $table->decimal('doc_fee', 12, 2)->nullable();
            $table->decimal('front_end_gross', 12, 2)->nullable();
            $table->decimal('back_end_gross', 12, 2)->nullable();
            $table->decimal('total_gross', 12, 2)->nullable();
            $table->string('credit_score')->nullable();
            
            // Lease specific fields
            $table->string('lease_company')->nullable();
            $table->string('lease_program')->nullable();
            $table->decimal('money_factor', 10, 5)->nullable();
            $table->integer('lease_term')->nullable();
            $table->string('lease_payment_frequency')->nullable();
            $table->integer('miles_per_year')->nullable();
            $table->decimal('excess_mileage', 8, 2)->nullable();
            $table->decimal('selling_price', 12, 2)->nullable();
            $table->decimal('residual_percent', 5, 2)->nullable();
            $table->decimal('residual_value', 12, 2)->nullable();
            $table->decimal('monthly_payment', 12, 2)->nullable();
            $table->decimal('due_at_signing', 12, 2)->nullable();
            $table->date('lease_start')->nullable();
            $table->date('lease_end')->nullable();
            $table->decimal('buyout_amount', 12, 2)->nullable();
            $table->decimal('lease_gross', 12, 2)->nullable();
            $table->decimal('reserve_fee', 12, 2)->nullable();
            $table->decimal('total_profit', 12, 2)->nullable();
            
            // Finance specific fields
            $table->string('lender_name')->nullable();
            $table->string('lender_code')->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->integer('finance_term')->nullable();
            $table->string('finance_payment_frequency')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('bank_fee', 12, 2)->nullable();
            $table->enum('extended_warranty', ['Yes', 'No', 'Expired'])->nullable();
            $table->decimal('warranty_amount', 12, 2)->nullable();
            
            // Cash specific fields
            $table->string('payment_method')->nullable();
            $table->decimal('total_cash_received', 12, 2)->nullable();
            $table->decimal('total_sale_amount', 12, 2)->nullable();
            $table->date('delivered_date')->nullable();
            $table->date('sold_date')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index for faster queries
            $table->index(['deal_id', 'payment_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};