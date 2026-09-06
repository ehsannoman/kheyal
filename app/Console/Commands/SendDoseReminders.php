<?php

namespace App\Console\Commands;

use App\Models\DoseLog;
use App\Notifications\DoseReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDoseReminders extends Command
{
    // Ei command ta cron/scheduler diye protita minute-e chole, dose-er shomoy hote 15 minute agei
    // reminder pathaay - jate caregiver dose miss howar age prostut hote pare
    protected $signature = 'reminders:doses';

    protected $description = 'Send push reminders for doses due within the next 15 minutes';

    public function handle(): int
    {
        $now = Carbon::now();
        $windowEnd = $now->copy()->addMinutes(15);
        $today = $now->toDateString();

        $doseLogs = DoseLog::where('status', 'pending')
            ->where('scheduled_date', $today)
            ->whereNull('reminded_at')
            ->with(['patient.caregiver', 'medication'])
            ->get()
            ->filter(function ($doseLog) use ($now, $windowEnd, $today) {
                $scheduledDateTime = Carbon::parse("{$today} {$doseLog->scheduled_time}");
                return $scheduledDateTime->between($now, $windowEnd);
            });

        $sent = 0;

        foreach ($doseLogs as $doseLog) {
            $caregiver = $doseLog->patient->caregiver ?? null;

            if (!$caregiver) {
                continue;
            }

            $caregiver->notify(new DoseReminderNotification($doseLog));
            $doseLog->update(['reminded_at' => $now]);
            $sent++;
        }

        $this->info("Sent {$sent} dose reminder(s).");

        return self::SUCCESS;
    }
}
