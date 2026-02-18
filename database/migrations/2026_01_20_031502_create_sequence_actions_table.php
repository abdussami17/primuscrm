<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sequence_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('smart_sequence_id')->constrained()->onDelete('cascade');
            $table->string('action_type'); // task, email, text, notify, ai-draft-email, ai-draft-text, change-* types, reassign-lead
            $table->unsignedInteger('delay_value')->default(0);
            $table->enum('delay_unit', ['minutes', 'hours', 'days', 'months', 'years'])->default('days');
            $table->json('parameters')->nullable(); // Store action-specific parameters
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_valid')->default(false);
            $table->timestamps();
            
            $table->index(['smart_sequence_id', 'sort_order']);
            $table->index('action_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sequence_actions');
    }
};