<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AirUser extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'airusers';

    protected $fillable = [
        'name', 'email', 'phone', 'gender', 'role', 'password'
    ];

    protected $hidden = [
        'password',
    ];

    // Role checking methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    public function hasRole($role): bool
    {
        return $this->role === $role;
    }

    // Relationships
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

    public function bookingHeaders()
    {
        return $this->hasMany(BookingHeader::class, 'user_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'user_id', 'id');
    }
}
