<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalAdmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'hospital_name',
        'illness_name',
        'admission_date',
        'discharge_date',
        'doctor_name',
        'treatment_details',
        'notes',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'discharge_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}