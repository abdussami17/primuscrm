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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('assigned_manager')->nullable()->after('is_active')->constrained('users')->onDelete('set null');
            $table->foreignId('assigned_bdc_agent')->nullable()->after('assigned_manager')->constrained('users')->onDelete('set null');
            $table->foreignId('assigned_service_agent')->nullable()->after('assigned_bdc_agent')->constrained('users')->onDelete('set null');
            $table->boolean('receive_internet_lead')->default(false)->after('assigned_service_agent');
            $table->boolean('receive_off_hours')->default(false)->after('receive_internet_lead');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['assigned_manager']);
            $table->dropForeign(['assigned_bdc_agent']);
            $table->dropForeign(['assigned_service_agent']);
            $table->dropColumn(['assigned_manager', 'assigned_bdc_agent', 'assigned_service_agent', 'receive_internet_lead', 'receive_off_hours']);
        });
    }
};
