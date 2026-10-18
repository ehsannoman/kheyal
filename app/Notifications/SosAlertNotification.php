<?php

namespace App\Notifications;

use App\Models\Patient;
use App\Models\SosAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class SosAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected SosAlert $alert,
        protected Patient $patient
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
        return (new WebPushMessage)
            ->title('জরুরি SOS সতর্কতা')
            ->icon('/icons/icon-192.png')
            ->body(
                "{$this->patient->name} জরুরি SOS alert পাঠিয়েছেন।"
            )
            ->action('দেখুন', 'view_sos')
            ->data([
                'type' => 'sos',
                'sos_alert_id' => $this->alert->id,
                'patient_id' => $this->patient->id,
                'url' => '/dashboard',
            ])
            ->options([
                'TTL' => 300,
            ]);
    }
}