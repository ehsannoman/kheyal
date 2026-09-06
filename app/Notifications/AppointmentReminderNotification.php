<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class AppointmentReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Appointment $appointment)
    {
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $patientName = $this->appointment->patient->name;
        $doctor = $this->appointment->doctor_name ? " ({$this->appointment->doctor_name})" : '';
        $when = $this->appointment->appointment_date->format('d M, h:i A');

        return (new WebPushMessage)
            ->title('আসন্ন অ্যাপয়েন্টমেন্ট')
            ->icon('/icons/icon-192.png')
            ->body("{$patientName}-এর অ্যাপয়েন্টমেন্ট{$doctor} — {$when}")
            ->action('দেখুন', 'view_appointments')
            ->data(['url' => '/appointments'])
            ->options(['TTL' => 300]);
    }
}
