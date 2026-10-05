<?php

namespace App\Console\Commands;

use App\Models\DoseLog;
use App\Notifications\DoseReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDoseReminders extends Command
{
    protected $signature = 'reminders:doses';

    protected $description = 'Send scheduled dose reminders to patients';

    public function handle(): int
    {
        $now = Carbon::now('Asia/Dhaka');
        $today = $now->toDateString();

        $doseLogs = DoseLog::where('status', 'pending')
            ->where('scheduled_date', $today)
            ->with(['patient', 'medication'])
            ->get();

        $sent = 0;

        foreach ($doseLogs as $doseLog) {

            $scheduledAt = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $doseLog->scheduled_date->format('Y-m-d') . ' ' . $doseLog->scheduled_time,
                'Asia/Dhaka'
            );

            /*
             * 1. 5 MINUTES BEFORE
             */
            if (
                $doseLog->reminder_5_at === null &&
                $now->greaterThanOrEqualTo($scheduledAt->copy()->subMinutes(5)) &&
                $now->lessThan($scheduledAt)
            ) {
                $this->sendReminder(
                    $doseLog,
                    '5_minutes',
                    'reminder_5_at',
                    $now
                );

                $sent++;
                continue;
            }

            /*
             * 2. EXACT DOSE TIME
             */
            if (
                $doseLog->reminder_due_at === null &&
                $now->greaterThanOrEqualTo($scheduledAt) &&
                $now->lessThan($scheduledAt->copy()->addMinutes(10))
            ) {
                $this->sendReminder(
                    $doseLog,
                    'due',
                    'reminder_due_at',
                    $now
                );

                $sent++;
                continue;
            }

            /*
             * 3. 10 MINUTES AFTER
             */
            if (
                $doseLog->reminder_overdue_at === null &&
                $now->greaterThanOrEqualTo($scheduledAt->copy()->addMinutes(10)) &&
                $now->lessThan($scheduledAt->copy()->addMinutes(30))
            ) {
                $this->sendReminder(
                    $doseLog,
                    'overdue',
                    'reminder_overdue_at',
                    $now
                );

                $sent++;
                continue;
            }

            /*
             * 4. 30 MINUTES AFTER
             */
            if (
                $doseLog->reminder_late_at === null &&
                $now->greaterThanOrEqualTo($scheduledAt->copy()->addMinutes(30))
            ) {
                $this->sendReminder(
                    $doseLog,
                    'late',
                    'reminder_late_at',
                    $now
                );

                $sent++;
            }
        }

        $this->info("Sent {$sent} dose reminder(s).");

        return self::SUCCESS;
    }

    protected function sendReminder(
        DoseLog $doseLog,
        string $stage,
        string $timestampColumn,
        Carbon $now
    ): void {
        $patient = $doseLog->patient;

        if (!$patient) {
            return;
        }

        // First save the reminder marker.
        // This prevents the same reminder from being sent again
        // on the next scheduler run.
        $doseLog->{$timestampColumn} = $now;
        $doseLog->save();

        // Then send the notification.
        $patient->notify(
            new DoseReminderNotification($doseLog, $stage)
        );

        $this->line(
            "Dose #{$doseLog->id}: {$stage} reminder sent to {$patient->name}"
        );
    }
}