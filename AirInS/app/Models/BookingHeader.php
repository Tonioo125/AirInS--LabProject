<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHeader extends Model
{   
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'check_in_date',
        'check_out_date',
        'total_price',
        'status',
        'booking_date',
    ];

    public function airusers()
    {
        return $this->belongsTo(AirUser::class, 'user_id');
    }

    public function bookingDetails()
    {
        return $this->hasOne(BookingDetail::class, 'booking_id');
    }

    public function reviews()
    {
        return $this->hasOne(Review::class, 'booking_id');
    }
}
