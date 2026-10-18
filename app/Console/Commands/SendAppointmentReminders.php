<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Notifications\AppointmentReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    protected $signature = 'reminders:appointments';

    protected $description = 'Send appointment reminders at 24h, 3h, 1h and exact time';

    public function handle(): int
    {
        $now = Carbon::now('Asia/Dhaka');

        $appointments = Appointment::whereNull('reminders_stopped_at')
            ->whereBetween(
                'appointment_date',
                [
                    $now->copy()->subMinutes(2),
                    $now->copy()->addHours(24)->addMinutes(2),
                ]
            )
            ->with(['patient.caregiver'])
            ->get();

        $sent = 0;

        foreach ($appointments as $appointment) {

            if (!$appointment->patient) {
                continue;
            }

            $appointmentTime = Carbon::parse(
                $appointment->appointment_date
            )->setTimezone('Asia/Dhaka');

            /*
            |--------------------------------------------------------------------------
            | 24 HOURS BEFORE
            |--------------------------------------------------------------------------
            */

            if (
                $appointment->reminder_24_at === null &&
                $now->greaterThanOrEqualTo(
                    $appointmentTime->copy()->subHours(24)
                ) &&
                $now->lessThan(
                    $appointmentTime->copy()->subHours(3)
                )
            ) {
                $this->sendReminder(
                    $appointment,
                    '24_hours',
                    'reminder_24_at'
                );

                $sent++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 3 HOURS BEFORE
            |--------------------------------------------------------------------------
            */

            if (
                $appointment->reminder_3_at === null &&
                $now->greaterThanOrEqualTo(
                    $appointmentTime->copy()->subHours(3)
                ) &&
                $now->lessThan(
                    $appointmentTime->copy()->subHour()
                )
            ) {
                $this->sendReminder(
                    $appointment,
                    '3_hours',
                    'reminder_3_at'
                );

                $sent++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 1 HOUR BEFORE
            |--------------------------------------------------------------------------
            */

            if (
                $appointment->reminder_1_at === null &&
                $now->greaterThanOrEqualTo(
                    $appointmentTime->copy()->subHour()
                ) &&
                $now->lessThan(
                    $appointmentTime
                )
            ) {
                $this->sendReminder(
                    $appointment,
                    '1_hour',
                    'reminder_1_at'
                );

                $sent++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | EXACT TIME
            |--------------------------------------------------------------------------
            */

            if (
                $appointment->reminder_exact_at === null &&
                $now->greaterThanOrEqualTo(
                    $appointmentTime
                ) &&
                $now->lessThan(
                    $appointmentTime->copy()->addMinutes(2)
                )
            ) {
                $this->sendReminder(
                    $appointment,
                    'exact',
                    'reminder_exact_at'
                );

                $sent++;
            }
        }

        $this->info(
            "Sent {$sent} appointment reminder(s)."
        );

        return self::SUCCESS;
    }

    protected function sendReminder(
        Appointment $appointment,
        string $stage,
        string $timestampColumn
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Mark first
        |--------------------------------------------------------------------------
        | Prevents duplicate notification on next scheduler run.
        */

        $appointment->{$timestampColumn} = now();
        $appointment->save();

        /*
        |--------------------------------------------------------------------------
        | Patient PWA
        |--------------------------------------------------------------------------
        */

        $patient = $appointment->patient;

        if ($patient) {
            $patient->notify(
                new AppointmentReminderNotification(
                    $appointment,
                    $stage
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Caregiver
        |--------------------------------------------------------------------------
        */

        $caregiver = $patient?->caregiver;

        if ($caregiver) {
            $caregiver->notify(
                new AppointmentReminderNotification(
                    $appointment,
                    $stage
                )
            );
        }

        $this->line(
            "Appointment #{$appointment->id}: {$stage} reminder sent."
        );
    }
}