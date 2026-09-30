<?php

namespace App\Enums;

enum Activity: int
{
    case DISABLE = 0;
    case ENABLE = 1;

    public function label(): string
    {
        return match ($this) {
            self::ENABLE => 'Enabled',
            self::DISABLE => 'Disabled',
        };
    }
}
