<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trade_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('vin')->nullable();
            $table->integer('year')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('trim')->nullable();
            $table->integer('odometer')->nullable();
            $table->string('condition_grade')->nullable(); // excellent, good, fair, poor
            $table->decimal('trade_allowance', 12, 2)->nullable();
            $table->decimal('lien_payout', 12, 2)->nullable();
            $table->decimal('acv', 12, 2)->nullable();
            $table->decimal('market_value', 12, 2)->nullable();
            $table->decimal('recon_estimate', 12, 2)->nullable();
            $table->foreignId('appraised_by')->nullable()->constrained('users')->nullOnDelete();
            $table->datetime('appraisal_date')->nullable();
            $table->json('photos')->nullable();
            $table->string('video_walkaround')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_ins');
    }
};