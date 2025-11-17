<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AirUser extends Authenticatable
{
    protected $table = 'airusers';

    protected $fillable = [
        'name', 'email', 'phone', 'gender', 'role', 'password'
    ];

    protected $hidden = [
        'password',
    ];
}
