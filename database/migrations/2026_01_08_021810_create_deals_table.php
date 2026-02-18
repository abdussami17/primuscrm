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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            // Temporarily storing inventory_id as unsignedBigInteger until inventory table is created
            $table->unsignedBigInteger('inventory_id')->nullable();
            
            // Deal Information
            $table->string('deal_number')->unique();
            $table->string('status')->default('pending'); // pending, negotiation, sold, lost, cancelled
            $table->string('lead_type')->nullable(); // walk-in, online, referral, phone
            $table->string('inventory_type')->nullable(); // new, used
            
            // Vehicle Information
            $table->string('vehicle_description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('down_payment', 10, 2)->nullable();
            $table->decimal('trade_in_value', 10, 2)->nullable();
            
            // Deal Dates
            $table->timestamp('sold_date')->nullable();
            $table->timestamp('delivery_date')->nullable();
            
            // Assignments
            $table->foreignId('sales_person_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('sales_manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('finance_manager_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
