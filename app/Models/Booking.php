<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'booking_code',
        'transport_type',
        'passenger_name',
        'firstname',
        'lastname',
        'email',
        'phone',
        'journey_date',
        'return_date',
        'check_in_date',
        'check_out_date',
        'from_city',
        'to_city',
        'accommodation',
        'rooms',
        'seats',
        'room_type',
        'unit_price',
        'total_price',
        'status',
        'payment_status',
        'refund_status',
        'cancellation_reason',
        'special_notes',
        'additional',
        'destination',
        'package_title',
        'package_location',
        'package_price',
    ];

    protected $casts = [
        'journey_date' => 'date',
        'return_date' => 'date',
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'package_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Helper to check if ticket can be cancelled (upcoming + not yet cancelled)
    public function canBeCancelled(): bool
    {
        $travelDate = $this->journey_date ?? $this->check_in_date;
        if (!$travelDate) {
            return false;
        }

        return $this->status !== 'cancelled' && \Carbon\Carbon::parse($travelDate)->isFuture();
    }
}
