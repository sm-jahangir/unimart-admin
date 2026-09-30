<?php

namespace App\Models;

use App\Enums\PurchasePaymentStatus;
use App\Enums\PurchaseStatus;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'status' => PurchaseStatus::class,
        'payment_status' => PurchasePaymentStatus::class,
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Stock lines attached to this purchase (Stock.model morph).
     */
    public function stocks()
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
}
