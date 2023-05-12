<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'alias',
        'postcode',
        'province',
        'city',
        'street',
        'phone',
        'email'
    ];


    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
    ];
}
