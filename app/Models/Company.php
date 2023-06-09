<?php
declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
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
        'status_message',
        'description',
        'foundation_year',
        'employees'
    ];

    protected $casts = [
        'status' => Status::class,
        'description' => CleanHtmlInput::class,
    ];

    protected $with = ['industry', 'location'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeByUser(Builder $query): Builder
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('status', Status::ACCEPT->value);
    }

    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(Benefit::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function socials(): HasMany
    {
        return $this->hasMany(Social::class);
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }

    public function socialByNetworkId(int $socialNetworkId): ?Social
    {
        return $this->socials()
            ->get()
            ->first(fn(?Social $social) => $social->social_network_id === $socialNetworkId);
    }

    public function getWebsiteSocial(): ?Social
    {
        $socialNetwork = SocialNetwork::byName('website')->first();

        if ($socialNetwork) {
            return $this->socialByNetworkId($socialNetwork->id);
        }
        return null;
    }

    public function fileByCollection(string $collection): ?File
    {
        return $this->files()
            ->get()
            ->first(fn(?File $file) => $file->collection === $collection);
    }

    public function getGalleryImages(): Collection
    {
        return $this->files()
            ->get()
            ->filter(fn(?File $file) => $file->collection === 'gallery');
    }

}
