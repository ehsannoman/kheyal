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

    public function __construct(
        protected Appointment $appointment,
        protected string $stage
    ) {
    }

    public function via($notifiable)
    {
        return [
            WebPushChannel::class,
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        $patientName = $this->appointment->patient->name;

        $doctor = $this->appointment->doctor_name
            ? " — {$this->appointment->doctor_name}"
            : '';

        $when = $this->appointment
            ->appointment_date
            ->setTimezone('Asia/Dhaka')
            ->format('d M, h:i A');

        switch ($this->stage) {

            case '24_hours':
                $title = 'আগামীকাল ডাক্তার দেখাতে হবে';
                $body = "{$patientName}-এর ডাক্তার দেখানোর সময় আগামীকাল {$when}{$doctor}";
                break;

            case '3_hours':
                $title = 'ডাক্তারের অ্যাপয়েন্টমেন্ট কাছে';
                $body = "{$patientName}-এর অ্যাপয়েন্টমেন্ট আর ৩ ঘণ্টা পর — {$when}{$doctor}";
                break;

            case '1_hour':
                $title = 'ডাক্তারের অ্যাপয়েন্টমেন্ট ১ ঘণ্টা পর';
                $body = "{$patientName}-এর অ্যাপয়েন্টমেন্ট আর ১ ঘণ্টা পর — {$when}{$doctor}";
                break;

            case 'exact':
                $title = 'এখন ডাক্তারের সময়';
                $body = "{$patientName}-এর অ্যাপয়েন্টমেন্টের সময় এখন — {$when}{$doctor}";
                break;

            default:
                $title = 'ডাক্তারের অ্যাপয়েন্টমেন্ট';
                $body = "{$patientName}-এর অ্যাপয়েন্টমেন্ট — {$when}{$doctor}";
        }

        return (new WebPushMessage)
            ->title($title)
            ->icon('/icons/icon-192.png')
            ->body($body)
            ->action('দেখুন', 'view_appointments')
            ->data([
                'type' => 'appointment',
                'appointment_id' => $this->appointment->id,
                'stage' => $this->stage,
                'url' => $notifiable instanceof \App\Models\Patient
                    ? '/patient/' . $notifiable->access_token . '/home'
                    : '/dashboard',
            ])
            ->options([
                'TTL' => 300,
            ]);
    }
}