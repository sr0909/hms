<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $table = 'treatment';

    protected $fillable = [
        'treatment_id',
        'diagnosis_id',
        'treatment_name',
        'treatment_description',
        'type_id',
        'start_date',
        'end_date',
        'status',
        'created_at',
        'updated_at',
    ];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }
}
