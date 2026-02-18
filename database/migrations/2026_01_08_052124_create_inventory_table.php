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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            
            // Vehicle Identification
            $table->string('vin', 17)->unique()->nullable();
            $table->string('stock_number', 50)->unique();
            
            // Vehicle Details
            $table->integer('year');
            $table->string('make', 100);
            $table->string('model', 100);
            $table->string('trim', 100)->nullable();
            $table->string('body_type', 50)->nullable(); // Sedan, SUV, Truck, etc.
            $table->string('exterior_color', 50)->nullable();
            $table->string('interior_color', 50)->nullable();
            
            // Condition & Mileage
            $table->enum('condition', ['new', 'used', 'certified_pre_owned'])->default('new');
            $table->integer('mileage')->default(0);
            
            // Pricing
            $table->decimal('price', 12, 2);
            $table->decimal('msrp', 12, 2)->nullable();
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->decimal('cost', 12, 2)->nullable();
            
            // Status
            $table->enum('status', ['available', 'sold', 'pending', 'on_hold', 'in_transit'])->default('available');
            
            // Additional Info
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // Array of features
            $table->json('images')->nullable(); // Array of image URLs
            $table->string('engine', 100)->nullable();
            $table->string('transmission', 100)->nullable();
            $table->string('drivetrain', 50)->nullable();
            $table->string('fuel_type', 50)->nullable();
            
            // API Integration Fields
            $table->string('provider_id', 100)->nullable(); // Which API provider
            $table->string('external_id', 100)->nullable(); // Provider's ID for this vehicle
            $table->timestamp('last_synced_at')->nullable();
            
            // Location
            $table->string('location', 100)->nullable(); // Lot location, building, etc.
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['status', 'condition']);
            $table->index(['make', 'model']);
            $table->index('provider_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
