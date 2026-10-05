<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoseLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'medication_id',
        'patient_id',
        'scheduled_date',
        'scheduled_time',
        'status',
        'taken_at',
        'marked_by_type',
        'marked_by_id',
        'notes',
        'reminded_at',
        'reminder_5_at',
        'reminder_due_at',
        'reminder_overdue_at',
        'reminder_late_at',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'taken_at' => 'datetime',
        'reminded_at' => 'datetime',
        'reminder_5_at' => 'datetime',
        'reminder_due_at' => 'datetime',
        'reminder_overdue_at' => 'datetime',
        'reminder_late_at' => 'datetime',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function markedBy()
    {
        return $this->belongsTo(User::class, 'marked_by_id');
    }
}