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
        'description',
        'foundation_year',
        'employees'
    ];

    protected $casts = [
        'status' => Status::class,
        'description' =>  CleanHtmlInput::class,
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

    public function socialByNetworkId(int $socialNetworkId): ?string
    {
        $socials = $this->socials()->get();

        return $socials
            ->filter(fn (?Social $social) => $social->social_network_id === $socialNetworkId)
            ?->value('url');
    }

    public function getImageByCollection(string $collection): ?string
    {
        $files = $this->files()->get();

        $pathToImage =  $files->filter( fn(?File $file) => $file->collection === $collection)?->value('path');

        if ($pathToImage) {
            return url('/' . 'storage/' . $pathToImage);
        }

        return null;
    }

    public function getGalleryImages(): Collection
    {
        $files = $this->files()->get();

        $galleries = $files->filter(fn(?File $file) => $file->collection === 'gallery');

        return $galleries->map(fn (File $file) => url('/' . 'storage/' . $file->path));
    }
}
