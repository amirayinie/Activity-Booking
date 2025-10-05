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
        'image',
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

      public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['name'] ?? false, function ($q, $value) {
                $q->where('name', 'like', "%{$value}%");
            })
            ->when($filters['location'] ?? false, function ($q, $value) {
                $q->where('location', 'like', "%{$value}%");
            })
            ->when($filters['min_price'] ?? false, function ($q, $value) {
                $q->where('price', '>=', $value);
            })
            ->when($filters['max_price'] ?? false, function ($q, $value) {
                $q->where('price', '<=', $value);
            })
            ->when($filters['available'] ?? false, function ($q, $value) {
                if ($value) {
                    $q->where('available_slots', '>', 0);
                }
            });
    }
}
