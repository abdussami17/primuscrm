<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sequence_execution_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('smart_sequence_id')->constrained()->onDelete('cascade');
            $table->foreignId('sequence_action_id')->constrained()->onDelete('cascade');
            $table->foreignId('lead_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->timestamp('scheduled_at');
            $table->timestamp('executed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->json('execution_data')->nullable();
            $table->timestamps();
            
            $table->index(['smart_sequence_id', 'status']);
            $table->index(['scheduled_at', 'status']);
            $table->index('lead_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sequence_execution_logs');
    }
};