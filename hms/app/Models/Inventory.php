<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'medicine_id',
        'batch_no',
        'expiry_date',
        'quantity',
        'reorder_level',
        'reorder_quantity',
        'status',
        'created_at',
        'updated_at',
    ];

    // Define the accessor for the 'expiry_date' attribute
    public function getExpiryDateAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
    }

    // If your database column is named expiry_date, use this instead
    public function getExpiry_DateAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $this->attributes['expiry_date'])->format('d-m-Y');
    }

}
