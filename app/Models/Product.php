<?php

namespace App\Models;

use App\Enums\Activity;
use App\Enums\Ask;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'buying_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'variation_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'status' => Status::class,
        'can_purchasable' => Ask::class,
        'show_stock_out' => Activity::class,
        'is_free_delivery' => Ask::class,
        'refundable' => Ask::class,
        'sell_by_fraction' => Ask::class,
        'add_to_flash_sale' => Ask::class,
        'offer_start_date' => 'datetime',
        'offer_end_date' => 'datetime',
        'maximum_purchase_quantity' => 'integer',
        'low_stock_quantity_warning' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (self $product) {
            if (! $product->isDirty('slug')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function barcode()
    {
        return $this->belongsTo(Barcode::class);
    }

    /**
     * PNG data URI of this product's barcode, or null when no type/code is set.
     */
    public function barcodeDataUri(): ?string
    {
        if (! $this->barcode || ! $this->barcode_code) {
            return null;
        }

        return $this->barcode->pngDataUri($this->barcode_code);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order');
    }

    public function seo()
    {
        return $this->hasOne(ProductSeo::class);
    }

    public function tags()
    {
        return $this->hasMany(ProductTag::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', Status::ACTIVE);
    }

    public function currentPrice(): float
    {
        $onOffer = $this->offer_start_date?->isPast() && $this->offer_end_date?->isFuture();

        return (float) ($onOffer && $this->discount > 0
            ? max($this->selling_price - $this->discount, 0)
            : $this->selling_price);
    }
}
