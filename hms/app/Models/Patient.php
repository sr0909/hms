<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient';

    protected $fillable = [
        'patient_id',
        'patient_name',
        'username',
        'gender',
        'email',
        'phone',
        'ic',
        'dob',
        'street',
        'city',
        'state',
        'zip_code',
        'emergency_contact',
        'emergency_contact_relationship',
        'created_at',
        'updated_at',
    ];
}
