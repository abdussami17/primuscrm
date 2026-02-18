<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sequence_criteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_group_id')->constrained('sequence_criteria_groups')->onDelete('cascade');
            $table->string('field_name');
            $table->string('field_type'); // text, number, date, dropdown, user, language, identifier, year, interestrate, showroomvisit
            $table->string('operator'); // is, is_not, is_between, is_not_between, is_greater_equal, is_less_equal, is_blank, is_not_blank, is_within_the_last, is_not_within_the_last
            $table->json('values')->nullable(); // Store values as JSON array
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['criteria_group_id', 'sort_order']);
            $table->index('field_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sequence_criteria');
    }
};