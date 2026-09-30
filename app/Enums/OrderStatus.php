<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 1;
    case CONFIRMED = 2;
    case PROCESSING = 3;
    case SHIPPED = 4;
    case COMPLETED = 5;
    case CANCELLED = 6;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::PROCESSING => 'Processing',
            self::SHIPPED => 'Shipped',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }
}
