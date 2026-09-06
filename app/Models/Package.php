<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type', // 'bus', 'train', 'tour'
        'from_location',
        'to_location',
        'departure_time',
        'available_seats',
        'description',
        'price',
        'location',
        'image',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
