<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'uploaded_by',
        'image_path',
        'raw_ocr_text',
        'ai_parsed_data',
        'status',
        'doctor_name',
        'prescription_date',
        'follow_up_date',
        'notes',
    ];

    protected $casts = [
        'ai_parsed_data' => 'array',
        'prescription_date' => 'date',
        'follow_up_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }
}