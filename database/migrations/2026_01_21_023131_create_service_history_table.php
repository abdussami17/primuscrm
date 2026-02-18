<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->nullable()->constrained('inventory')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->date('service_date');
            $table->string('service_type');
            $table->text('description')->nullable();
            $table->integer('mileage')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            
             $table->foreignId('deals_id')->nullable()->constrained('deals')->nullOnDelete();
            $table->foreignId('advisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('advisor_name')->nullable();
            $table->string('technician')->nullable();
            $table->json('parts_used')->nullable();
            $table->decimal('labor_hours', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->string('ro_number')->nullable(); // Repair Order number
            $table->timestamps();

            $table->index(['inventory_id', 'service_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_history');
    }
};