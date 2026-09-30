<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'discount' => 'decimal:2',
        'minimum_order' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'limit_per_user' => 'integer',
    ];

    public function orderCoupons()
    {
        return $this->hasMany(OrderCoupon::class);
    }

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function scopeRunning($query)
    {
        return $query->where('start_date', '<=', now())->where('end_date', '>=', now());
    }
}
