<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTime extends Model
{
    use HasFactory;

    protected $table = 'appointment_time';

    protected $fillable = [
        'app_time',
        'created_at',
        'updated_at',
    ];

    // Define the accessor for the 'time' attribute
    public function getAppTimeAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    // If your database column is named app_time, use this instead
    public function getApp_TimeAttribute()
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $this->attributes['app_time'])->format('H:i');
    }
}
