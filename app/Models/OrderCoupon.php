<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCoupon extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'discount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }
}
