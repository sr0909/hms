<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointment';

    protected $fillable = [
        'id',
        'patient_id',
        'doctor_id',
        'dept_id',
        'app_date',
        'app_start_time_id',
        'app_end_time',
        'duration',
        'type',
        'notes',
        'status',
        'created_at',
        'updated_at',
    ];
}
