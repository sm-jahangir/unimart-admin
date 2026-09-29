<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::deleting(fn (self $brand) => $brand->deleteLogo());
    }

    /**
     * Keep the slug in sync with the name when none is given.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (self $brand) {
            if (! $brand->isDirty('slug')) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }

    public function deleteLogo(): void
    {
        if ($this->logo && Storage::disk('public')->exists($this->logo)) {
            Storage::disk('public')->delete($this->logo);
        }
    }

    public function logoUrl(): string
    {
        return $this->logo
            ? Storage::disk('public')->url($this->logo)
            : '';
    }

    /**
     * Two-letter fallback monogram for the logo tile, e.g. "Acme Audio" -> "AA".
     */
    public function initials(): string
    {
        return strtoupper(collect(explode(' ', $this->name))
            ->filter()
            ->map(fn (string $word) => mb_substr($word, 0, 1))
            ->take(2)
            ->implode(''));
    }
}
