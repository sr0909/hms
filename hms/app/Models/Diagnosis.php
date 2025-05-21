<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $table = 'diagnosis';

    protected $fillable = [
        'diagnosis_id',
        'medical_record_id',
        'diagnosis_name',
        'diagnosis_description',
        'created_at',
        'updated_at',
    ];

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }
}
