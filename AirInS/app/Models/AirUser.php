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
}
