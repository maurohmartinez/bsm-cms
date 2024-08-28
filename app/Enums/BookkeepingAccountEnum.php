<?php

namespace App\Enums;

enum BookkeepingAccountEnum: string
{
    use EnumTrait;

    case BANK = 'BANK';
    case CASH = 'CASH';

    public static function translatedOption(self $option): string
    {
        return match($option) {
            self::BANK => 'Bank',
            self::CASH => 'Cash',
        };
    }
}
