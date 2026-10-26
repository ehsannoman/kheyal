<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VitalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'systolic',
        'diastolic',
        'heart_rate',
        'temperature',
        'spo2',
        'blood_glucose',
        'weight',
        'measured_at',
        'notes',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'temperature' => 'decimal:1',
            'spo2' => 'decimal:2',
            'blood_glucose' => 'decimal:2',
            'weight' => 'decimal:2',
            'measured_at' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
