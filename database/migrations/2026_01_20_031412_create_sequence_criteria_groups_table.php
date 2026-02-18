<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sequence_criteria_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('smart_sequence_id')->constrained()->onDelete('cascade');
            $table->enum('logic_type', ['AND', 'OR'])->default('AND');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['smart_sequence_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sequence_criteria_groups');
    }
};