<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'medication_id',
        'scheduled_time',
        'dose_amount',
        'days_of_week',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    public function doseLogs()
    {
        return $this->hasMany(DoseLog::class);
    }
}