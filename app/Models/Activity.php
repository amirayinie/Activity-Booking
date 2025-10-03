<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 
        'description',
        'location',
        'price',
        'available_slots',
        'start_date'
    ];

    public function Bookings()
    {
        return $this->hasMany(Booking::class);
    }


    protected $casts = [
        'start_date' => 'datetime'
    ];
}
