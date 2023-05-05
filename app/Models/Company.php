<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function scopeByUser(Builder $query): Builder
    {
        return $query->where('user_id', Auth::user()->id);
    }
}
