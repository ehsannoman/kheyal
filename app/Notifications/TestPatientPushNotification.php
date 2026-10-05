<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class TestPatientPushNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('খেয়াল — টেস্ট নোটিফিকেশন')
            ->icon('/icons/icon-192.png')
            ->body('Patient push notification সফলভাবে কাজ করছে।')
            ->data([
                'url' => '/patient/' . $notifiable->access_token . '/home',
            ])
            ->options([
                'TTL' => 300,
            ]);
    }
}