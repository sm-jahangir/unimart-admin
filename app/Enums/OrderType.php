<?php

namespace App\Enums;

enum OrderType: int
{
    case DELIVERY = 1;
    case PICKUP = 2;
    case POS = 3;

    public function label(): string
    {
        return match ($this) {
            self::DELIVERY => 'Delivery',
            self::PICKUP => 'Pickup',
            self::POS => 'POS',
        };
    }
}
