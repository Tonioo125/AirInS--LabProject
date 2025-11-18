<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory; 

    protected $fillable = [
        'booking_id', 'property_id', 'guest_count', 'price_per_night'
    ];

    public function bookingHeader(){
        return $this->belongsTo(BookingHeader::class, 'booking_id');
    }

    public function property(){
        return $this->belongsTo(Property::class, 'property_id');
    }
}
