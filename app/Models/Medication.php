<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'prescription_id',
        'name',
        'dosage',
        'form',
        'frequency',
        'duration_days',
        'start_date',
        'end_date',
        'total_quantity',
        'remaining_quantity',
        'low_stock_threshold',
        'instructions',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function doseLogs()
    {
        return $this->hasMany(DoseLog::class);
    }
}