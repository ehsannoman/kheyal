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
}