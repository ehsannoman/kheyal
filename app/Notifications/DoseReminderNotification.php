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

    public function __construct(
        protected DoseLog $doseLog,
        protected string $stage
    ) {
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $medicationName = $this->doseLog->medication->name;
        $time = substr($this->doseLog->scheduled_time, 0, 5);

        switch ($this->stage) {

            case '5_minutes':
                $title = 'ওষুধের সময় আসছে';
                $body = "{$medicationName} খাওয়ার সময় ৫ মিনিট পর ({$time})";
                break;

            case 'due':
                $title = 'এখন ওষুধ খাওয়ার সময়';
                $body = "{$medicationName} এখন খাওয়ার সময় হয়েছে ({$time})";
                break;

            case 'overdue':
                $title = 'ওষুধ নেওয়া হয়েছে কি?';
                $body = "{$medicationName} নেওয়ার সময় ১০ মিনিট পার হয়েছে। এখনো না নিয়ে থাকলে নিয়ে নিন।";
                break;

            case 'late':
                $title = 'ওষুধ এখনো নেওয়া হয়নি';
                $body = "{$medicationName} নির্ধারিত সময়ের ৩০ মিনিট পার হয়ে গেছে।";
                break;

            default:
                $title = 'ওষুধের reminder';
                $body = "{$medicationName} খাওয়ার সময় ({$time})";
        }

        return (new WebPushMessage)
            ->title($title)
            ->icon('/icons/icon-192.png')
            ->body($body)
            ->action('দেখুন', 'view_tracking')
            ->data([
                'url' => '/patient/' . $notifiable->access_token . '/home',
                'dose_log_id' => $this->doseLog->id,
                'stage' => $this->stage,
            ])
            ->options([
                'TTL' => 300,
            ]);
    }
}