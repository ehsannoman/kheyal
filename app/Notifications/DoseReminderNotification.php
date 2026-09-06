<?php

namespace App\Notifications;

use App\Models\DoseLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class DoseReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected DoseLog $doseLog)
    {
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $patientName = $this->doseLog->patient->name;
        $medicationName = $this->doseLog->medication->name;
        $time = substr($this->doseLog->scheduled_time, 0, 5);

        return (new WebPushMessage)
            ->title('ওষুধের সময় হয়েছে')
            ->icon('/icons/icon-192.png')
            ->body("{$patientName}-এর {$medicationName} খাওয়ার সময় হয়েছে ({$time})")
            ->action('দেখুন', 'view_tracking')
            ->data(['url' => '/tracking'])
            ->options(['TTL' => 300]);
    }
}
