<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'booking_id',
        'rating',
        'comment',
    ];

    public function bookingHeaders()
    {
        return $this->belongsTo(BookingHeader::class, 'booking_id');
    }
}