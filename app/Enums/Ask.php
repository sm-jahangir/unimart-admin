<?php

namespace App\Enums;

enum Ask: int
{
    case NO = 0;
    case YES = 1;

    public function label(): string
    {
        return match ($this) {
            self::YES => 'Yes',
            self::NO => 'No',
        };
    }
}
