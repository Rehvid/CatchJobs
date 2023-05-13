<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Social extends Model
{
    use HasFactory;


    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'social_network_id',
        'url'
    ];

    public function scopeBySocialNetwork(Builder $query, int $socialNetworkId): Builder
    {
        return $query->where('social_network_id', $socialNetworkId);
    }

    public function socialNetwork(): BelongsTo {
        return $this->belongsTo(SocialNetwork::class);
    }
}
