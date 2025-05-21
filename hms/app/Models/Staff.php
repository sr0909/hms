<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    
    // Specifies the name of the database table associated with the model
    protected $table = 'staff';

    // Indicate that the id should be cast to a string
    protected $casts = [
        'id' => 'string',
    ];

    // Specifies the attributes
    protected $fillable = [
        'id',
        'role',
        'name',
        'username',
        'gender',
        'email',
        'phone',
        'dob',
        'street',
        'city',
        'state',
        'zip_code',
        'hired_date',
        'terminated_date',
        'salary',
        'status',
        'created_at',
        'updated_at',
    ];
}
