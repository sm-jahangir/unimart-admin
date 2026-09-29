<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check a permission slug against the role's permissions.
     * Uses the loaded relation when present (set by AuthGates),
     * otherwise falls back to a single query.
     */
    public function hasPermission(string $slug): bool
    {
        if ($this->relationLoaded('role')) {
            return $this->role?->permissions->contains('slug', $slug) ?? false;
        }

        return (bool) $this->role?->permissions()->where('slug', $slug)->exists();
    }

    /**
     * Delete the user's avatar file when it is replaced or the user is removed.
     */
    protected static function booted(): void
    {
        static::deleting(fn (self $user) => $user->deleteAvatar());
    }

    public function deleteAvatar(): void
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            Storage::disk('public')->delete($this->avatar);
        }
    }

    public function avatarUrl(): string
    {
        return $this->avatar
            ? Storage::disk('public')->url($this->avatar)
            : asset('backend/assets/avatars/admin-avatar.svg');
    }
}
