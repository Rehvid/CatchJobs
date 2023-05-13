<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function scopeByName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }
}
