<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'disk',
        'path',
        'mime_type',
        'collection'
    ];

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function getPublicPath(): string
    {
        return url('/' . 'storage/' . $this->path);
    }
}
