<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->timestamp('reminder_24_at')->nullable()->after('reminded');
            $table->timestamp('reminder_3_at')->nullable()->after('reminder_24_at');
            $table->timestamp('reminder_1_at')->nullable()->after('reminder_3_at');
            $table->timestamp('reminder_exact_at')->nullable()->after('reminder_1_at');

            $table->timestamp('reminders_stopped_at')
                ->nullable()
                ->after('reminder_exact_at');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'reminder_24_at',
                'reminder_3_at',
                'reminder_1_at',
                'reminder_exact_at',
                'reminders_stopped_at',
            ]);
        });
    }
};