<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $fillable = ['name', 'slug'];

    protected $casts = [
        'genres' => 'array'
    ];

    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_genres');
    }
}
