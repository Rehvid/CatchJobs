<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Casts\CleanHtmlInput;

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
        'status' => Status::class,
        'description' =>  CleanHtmlInput::class,
    ];

    protected $with = ['industry'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeByUser(Builder $query): Builder
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(Benefit::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }
}
