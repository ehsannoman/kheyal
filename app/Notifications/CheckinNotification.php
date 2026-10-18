<?php

namespace App\Notifications;

use App\Models\Checkin;
use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CheckinNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Checkin $checkin,
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
        switch ($this->checkin->status) {

            case 'fine':
                $title = 'দৈনিক চেক-ইন';
                $body = "{$this->patient->name} জানিয়েছেন তিনি ভালো আছেন।";
                break;

            case 'not_well':
                $title = 'স্বাস্থ্য সংক্রান্ত সতর্কতা';
                $body = "{$this->patient->name} জানিয়েছেন তিনি ভালো বোধ করছেন না।";
                break;

            case 'need_help':
                $title = 'সাহায্য প্রয়োজন';
                $body = "{$this->patient->name} জানিয়েছেন তার সাহায্য প্রয়োজন।";
                break;

            default:
                $title = 'দৈনিক চেক-ইন';
                $body = "{$this->patient->name} আজকের চেক-ইন দিয়েছেন।";
        }

        return (new WebPushMessage)
            ->title($title)
            ->icon('/icons/icon-192.png')
            ->body($body)
            ->action('দেখুন', 'view_checkin')
            ->data([
                'type' => 'checkin',
                'checkin_id' => $this->checkin->id,
                'patient_id' => $this->patient->id,
                'status' => $this->checkin->status,
                'url' => '/dashboard',
            ])
            ->options([
                'TTL' => 300,
            ]);
    }
}