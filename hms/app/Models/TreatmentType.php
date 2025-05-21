<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentType extends Model
{
    use HasFactory;

    protected $table = 'treatment_type';

    protected $fillable = [
        'type',
        'type_description',
        'created_at',
        'updated_at',
    ];
}
