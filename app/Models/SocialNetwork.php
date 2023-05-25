<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SocialNetwork extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function scopeByName(Builder $builder, string $name): Builder
    {
        return $builder->where('name', $name);
    }
}
