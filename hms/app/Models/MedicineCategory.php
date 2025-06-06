<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineCategory extends Model
{
    use HasFactory;

    protected $table = 'medicine_category';

    protected $fillable = [
        'category_name',
        'category_description',
        'created_at',
        'updated_at',
    ];
}
