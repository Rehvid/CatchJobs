<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_id',
        'industry_id',
        'name',
        'slug',
        'vat_number',
        'status',
        'description',
        'foundation_year',
        'employees'
    ];

    protected $casts = [
        'status' => Status::class
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
