<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'caregiver_id',
        'name',
        'age',
        'gender',
        'relation',
        'photo',
    ];

    public function caregiver()
    {
        return $this->belongsTo(User::class, 'caregiver_id');
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