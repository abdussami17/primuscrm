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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // recipient
            $table->foreignId('from_user_id')->constrained('users')->onDelete('cascade'); // sender
            $table->string('to_email');
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->string('subject');
            $table->longText('body');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_starred')->default(false);
            $table->boolean('is_draft')->default(false);
            $table->boolean('is_sent')->default(false);
            $table->foreignId('parent_id')->nullable()->constrained('emails')->onDelete('set null');
            $table->unsignedBigInteger('thread_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'is_starred']);
            $table->index(['user_id', 'is_draft']);
            $table->index(['from_user_id', 'is_sent']);
            $table->index('thread_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};