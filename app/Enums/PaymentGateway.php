<?php

namespace App\Enums;

enum PaymentGateway: int
{
    case CASH_ON_DELIVERY = 1;
    case BANK_TRANSFER = 2;
    case MOBILE_BANKING = 3;
    case CARD = 4;

    public function label(): string
    {
        return match ($this) {
            self::CASH_ON_DELIVERY => 'Cash on Delivery',
            self::BANK_TRANSFER => 'Bank Transfer',
            self::MOBILE_BANKING => 'Mobile Banking',
            self::CARD => 'Card',
        };
    }
}
