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
        Schema::create('customer_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('email');
            $table->boolean('is_default')->default(false);
            $table->string('label')->nullable()->comment('e.g., personal, work, other');
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('email');
            $table->index(['customer_id', 'is_default']);
            
            // Unique constraint - each email can only exist once per customer
            $table->unique(['customer_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_emails');
    }
};