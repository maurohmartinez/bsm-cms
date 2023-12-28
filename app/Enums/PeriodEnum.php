<?php

namespace App\Enums;

enum PeriodEnum: string
{
    use EnumTrait;

    case FIRST = 'FIRST';
    case SECOND = 'SECOND';

    public static function translatedOption(self $option): string
    {
        return match($option) {
            self::FIRST => 'First',
            self::SECOND => 'Second',
        };
    }
}
