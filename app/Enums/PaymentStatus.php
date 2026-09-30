<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case UNPAID = 0;
    case PARTIAL = 1;
    case PAID = 2;
    case REFUNDED = 3;

    public function label(): string
    {
        return match ($this) {
            self::UNPAID => 'Unpaid',
            self::PARTIAL => 'Partial',
            self::PAID => 'Paid',
            self::REFUNDED => 'Refunded',
        };
    }
}
