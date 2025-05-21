<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $table = 'medical_record';

    protected $fillable = [
        'medical_record_id',
        'patient_id',
        'doctor_id',
        'medical_record_date',
        'notes',
        'status',
        'created_at',
        'updated_at',
    ];
}
