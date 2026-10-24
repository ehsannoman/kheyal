<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Notifications\Notifiable;


class Patient extends Model
{
     use HasFactory, Notifiable, HasPushSubscriptions;

    protected $fillable = [
        'caregiver_id',
        'name',
        'age',
        'gender',
        'relation',
        'caregiver_phone',
        'photo',
        'access_token',
    ];

    public function caregiver()
    {
        return $this->belongsTo(User::class, 'caregiver_id');
    }
    
    public function illnessHistories()
    {
        return $this->hasMany(IllnessHistory::class);
    }
    
    public function hospitalAdmissions()
    {
        return $this->hasMany(HospitalAdmission::class);
    }

    // Patient-er PWA link-er jonno ekta unique, na-guess-jogyo token toiri kore
    // (already thakle notun kore banay na, ekbari toiri hoy)
    public function ensureAccessToken(): string
    {
        if (!$this->access_token) {
            $this->access_token = Str::random(48);
            $this->save();
        }

        return $this->access_token;
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    public function doseLogs()
    {
        return $this->hasMany(DoseLog::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function sosAlerts()
    {
        return $this->hasMany(SosAlert::class);
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }
}