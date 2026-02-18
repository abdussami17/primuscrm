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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('profile_image')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('work_phone')->nullable();

            // Address Information
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->default('Canada');

            // CRM Fields
            $table->string('status')->default('new');
            $table->string('lead_source')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('assigned_manager')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('secondary_assigned')->nullable()->constrained('users')->onDelete('set null');

            // Vehicle Interest
            $table->string('interested_make')->nullable();
            $table->string('interested_model')->nullable();
            $table->string('interested_year')->nullable();
            $table->decimal('budget', 10, 2)->nullable();

            // Trade-in Information
            $table->string('tradein_year')->nullable();
            $table->string('tradein_make')->nullable();
            $table->string('tradein_model')->nullable();
            $table->string('tradein_vin')->nullable();
            $table->integer('tradein_kms')->nullable();
            $table->decimal('tradein_value', 10, 2)->nullable();

            // Additional Fields
            $table->text('notes')->nullable();
            $table->json('tags')->nullable();
            $table->json('preferences')->nullable();
            $table->boolean('consent_marketing')->default(false);
            $table->boolean('consent_sms')->default(false);
            $table->boolean('consent_email')->default(false);

            // Dealership Assignment
            $table->json('dealership_franchises')->nullable();
            $table->string('inventory_type')->nullable();
            $table->string('finance_manager')->nullable();
            $table->string('driver_license_front')->nullable();
            $table->string('driver_license_back')->nullable();
            // Timestamps
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamp('next_follow_up_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
