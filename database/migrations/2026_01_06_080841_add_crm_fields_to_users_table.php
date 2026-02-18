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
            $table->string('work_phone')->nullable()->after('email');
            $table->string('cell_phone')->nullable()->after('work_phone');
            $table->string('home_phone')->nullable()->after('cell_phone');
            $table->string('title')->nullable()->after('home_phone');
            $table->string('profile_photo')->nullable()->after('title');
            $table->text('email_signature')->nullable()->after('profile_photo');
            $table->json('working_hours')->nullable()->after('email_signature');
            $table->json('dealership_franchises')->nullable()->after('working_hours');
            $table->boolean('is_active')->default(true)->after('dealership_franchises');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'work_phone',
                'cell_phone',
                'home_phone',
                'title',
                'profile_photo',
                'email_signature',
                'working_hours',
                'dealership_franchises',
                'is_active',
                'last_login_at',
            ]);
        });
    }
};
