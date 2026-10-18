<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'prescription_id',
        'doctor_name',
        'location',
        'appointment_date',
        'notes',
        'reminder_24_at',
        'reminder_3_at',
        'reminder_1_at',
        'reminder_exact_at',
        'reminders_stopped_at',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',

        'reminder_24_at' => 'datetime',
        'reminder_3_at' => 'datetime',
        'reminder_1_at' => 'datetime',
        'reminder_exact_at' => 'datetime',
        'reminders_stopped_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}