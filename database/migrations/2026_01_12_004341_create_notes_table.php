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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            $table->text('description')->nullable();
            $table->string('type', 256)->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->integer('deal_id')->nullable();
            $table->unsignedBigInteger('customer_id');

            $table->boolean('is_private')->default(false);

            $table->text('metadata')->nullable();
            $table->text('attachments')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('created_by');
            $table->index('task_id');
            $table->index('customer_id');

            // Foreign keys
            $table->foreign('created_by')
                  ->references('id')->on('users')
                  ->nullOnDelete();

            $table->foreign('task_id')
                  ->references('id')->on('tasks')
                  ->nullOnDelete();

            $table->foreign('customer_id')
                  ->references('id')->on('customers')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
