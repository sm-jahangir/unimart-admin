<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'decimal:2',
        'discount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'status' => Status::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The context this stock line belongs to, e.g. Purchase or Order.
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * The item being stocked, e.g. Product or ProductVariation.
     */
    public function item()
    {
        return $this->morphTo();
    }
}
