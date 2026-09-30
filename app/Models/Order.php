<?php

namespace App\Models;

use App\Enums\Ask;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentGateway;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'order_datetime' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'total' => 'decimal:2',
        'edited_amount' => 'decimal:2',
        'edited_date' => 'datetime',
        'order_type' => OrderType::class,
        'payment_method' => PaymentGateway::class,
        'payment_status' => PaymentStatus::class,
        'status' => OrderStatus::class,
        'active' => Ask::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function coupons()
    {
        return $this->hasMany(OrderCoupon::class);
    }

    /**
     * Line items for this order (Stock.model morph).
     */
    public function items()
    {
        return $this->morphMany(Stock::class, 'model');
    }

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function scopeActive($query)
    {
        return $query->where('active', Ask::YES);
    }
}
