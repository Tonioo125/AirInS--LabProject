<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyCategory extends Model
{
    Use HasFactory;

    protected $table = 'property_categories';

    protected $fillable = [
        'name',
    ];
}
