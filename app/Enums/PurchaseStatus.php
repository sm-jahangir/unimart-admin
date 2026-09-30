<?php

namespace App\Enums;

enum PurchaseStatus: int
{
    case PENDING = 1;
    case ORDERED = 2;
    case RECEIVED = 3;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ORDERED => 'Ordered',
            self::RECEIVED => 'Received',
        };
    }
}
