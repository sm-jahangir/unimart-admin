<?php

namespace App\Enums;

enum PurchasePaymentStatus: int
{
    case PENDING = 0;
    case PARTIAL = 1;
    case PAID = 2;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PARTIAL => 'Partial',
            self::PAID => 'Paid',
        };
    }
}
