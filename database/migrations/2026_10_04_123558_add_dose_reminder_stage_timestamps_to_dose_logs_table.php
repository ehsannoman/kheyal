<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dose_logs', function (Blueprint $table) {
            $table->timestamp('reminder_5_at')
                ->nullable()
                ->after('reminded_at');

            $table->timestamp('reminder_due_at')
                ->nullable()
                ->after('reminder_5_at');

            $table->timestamp('reminder_overdue_at')
                ->nullable()
                ->after('reminder_due_at');

            $table->timestamp('reminder_late_at')
                ->nullable()
                ->after('reminder_overdue_at');
        });
    }

    public function down(): void
    {
        Schema::table('dose_logs', function (Blueprint $table) {
            $table->dropColumn([
                'reminder_5_at',
                'reminder_due_at',
                'reminder_overdue_at',
                'reminder_late_at',
            ]);
        });
    }
};