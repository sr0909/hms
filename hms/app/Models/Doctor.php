<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctor';

    protected $fillable = [
        'id',
        'dept_id',
        'years_of_experience',
        'created_at',
        'updated_at',
    ];
}
