<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function scopeFindByName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }

}
