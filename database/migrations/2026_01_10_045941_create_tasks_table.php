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
        Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->dateTime('due_date');
        $table->string('assigned_to');
        $table->string('status_type');
        $table->string('task_type');
        $table->string('priority');
        $table->text('description')->nullable();
        $table->foreignId('created_by')->constrained('users')->nullable();
        $table->foreignId('customer_id')->constrained('customers')->nullable();
        $table->foreignId('deal_id')->constrained('deals')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
