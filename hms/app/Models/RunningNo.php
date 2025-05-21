<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunningNo extends Model
{
    use HasFactory;

    protected $table = 'running_no';

    protected $fillable = [
        'type',
        'prefix',
        'running_no',
        'created_at',
        'updated_at',
    ];
}
