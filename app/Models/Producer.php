<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producer extends Model
{
    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_producers');
    }
}
