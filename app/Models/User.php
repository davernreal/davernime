<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'user_favorites', 'user_id', 'anime_id', 'id', 'anime_id')
            ->withTimestamps();
    }

    public function histories(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'user_histories', 'user_id', 'anime_id')
            ->withTimestamps()->withPivot('id');
    }

    public function saveHistory($animeId)
    {
        if (!$this->histories()->where('user_histories.anime_id', $animeId)->exists()) {
            $this->histories()->attach($animeId);
        } else {
            $this->histories()->updateExistingPivot($animeId, [
                'updated_at' => now()
            ]);
        }
    }
}
