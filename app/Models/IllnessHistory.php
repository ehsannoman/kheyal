<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IllnessHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'illness_name',
        'diagnosed_at',
        'status',
        'doctor_name',
        'hospital_name',
        'notes',
        'follow_up_date',
    ];

    protected $casts = [
        'diagnosed_at' => 'date',
        'follow_up_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}