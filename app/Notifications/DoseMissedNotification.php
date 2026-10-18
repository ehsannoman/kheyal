<?php

namespace App\Notifications;

use App\Models\DoseLog;
use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class DoseMissedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected DoseLog $doseLog,
        protected Patient $patient
    ) {
    }

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $medicationName = $this->doseLog->medication?->name
            ?? 'নির্ধারিত ওষুধ';

        $time = substr(
            (string) $this->doseLog->scheduled_time,
            0,
            5
        );

        return (new WebPushMessage)
            ->title('ওষুধ মিস হয়েছে')
            ->icon('/icons/icon-192.png')
            ->body(
                "{$this->patient->name}-এর {$medicationName} "
                . "ওষুধের নির্ধারিত সময় {$time}। "
                . "৩০ মিনিটেও ওষুধ নেওয়া হয়নি।"
            )
            ->action('দেখুন', 'view_tracking')
            ->data([
                'type' => 'dose_missed',
                'dose_log_id' => $this->doseLog->id,
                'patient_id' => $this->patient->id,
                'url' => '/dashboard',
            ])
            ->options([
                'TTL' => 300,
            ]);
    }
}
