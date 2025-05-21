<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescription';

    protected $fillable = [
        'treatment_id',
        'medicine_id',
        'dosage',
        'frequency',
        'duration',
        'instructions',
        'created_at',
        'updated_at',
    ];
}
