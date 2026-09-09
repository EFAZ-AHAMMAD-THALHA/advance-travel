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

    /**
     * Get the accessible public URL for the package thumbnail.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (file_exists(public_path('uploads/packages/' . $this->image))) {
                return asset('uploads/packages/' . $this->image);
            }
            if (file_exists(public_path('assets/files/' . $this->image))) {
                return asset('assets/files/' . rawurlencode($this->image));
            }
        }

        return match ($this->type) {
            'flight' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80',
            'train'  => 'https://images.unsplash.com/photo-1474487548417-781cb71495f3?auto=format&fit=crop&w=800&q=80',
            'bus'    => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80',
            default  => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
        };
    }
}
