<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Notifications\AppointmentReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    // Appointment-er 24 ghonta age ekbar reminder pathaay (reminded=true hoye gele r pathabe na)
    protected $signature = 'reminders:appointments';

    protected $description = 'Send push reminders for appointments happening within the next 24 hours';

    public function handle(): int
    {
        $now = Carbon::now();
        $windowEnd = $now->copy()->addHours(24);

        $appointments = Appointment::where('reminded', false)
            ->whereBetween('appointment_date', [$now, $windowEnd])
            ->with(['patient.caregiver'])
            ->get();

        $sent = 0;

        foreach ($appointments as $appointment) {
            $caregiver = $appointment->patient->caregiver ?? null;

            if (!$caregiver) {
                continue;
            }

            $caregiver->notify(new AppointmentReminderNotification($appointment));
            $appointment->update(['reminded' => true]);
            $sent++;
        }

        $this->info("Sent {$sent} appointment reminder(s).");

        return self::SUCCESS;
    }
}
