<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $table = 'medicine';

    protected $fillable = [
        'medicine_id',
        'medicine_name',
        'medicine_description',
        'category_id',
        'dosage_form',
        'strength',
        'package_size',
        'price',
        'manufacturer',
        'created_at',
        'updated_at',
    ];
}
