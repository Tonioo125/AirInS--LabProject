<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'title',
        'description',
        'photos',
        'location',
        'price',
        'is_available',
    ];

    public function propertyCategories()
    {
        return $this->belongsTo(PropertyCategory::class, 'category_id');
    }

    public function airusers()
    {
        return $this->belongsTo(AirUser::class, 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'property_id');
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class, 'property_id');
    }
}
