<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Add all columns you want to mass assign
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'check_in_date',
        'check_out_date',
        'accommodation',
        'rooms',
        'room_type',
        'additional',
        'destination',
        'package_title',
        'package_location',
        'package_price',
    ];
}
