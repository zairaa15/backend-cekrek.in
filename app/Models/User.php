<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function layouts(): HasMany
    {
        return $this->hasMany(Layout::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function customFrames(): HasMany
    {
        return $this->hasMany(CustomFrame::class);
    }

    public function drafts(): HasMany
    {
        return $this->hasMany(Draft::class);
    }
}

