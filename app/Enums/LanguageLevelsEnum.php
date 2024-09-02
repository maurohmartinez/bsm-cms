<?php

namespace App\Enums;

enum LanguageLevelsEnum: string
{
    use EnumTrait;

    case NONE = 'NONE';
    case A1 = 'A1';
    case A2 = 'A2';
    case B1 = 'B1';
    case B2 = 'B2';
    case C1 = 'C1';
    case C2 = 'C2';

    public static function translatedOption(self $option): string
    {
        return match($option) {
            self::NONE => 'NONE',
            self::A1 => 'A1',
            self::A2 => 'A2',
            self::B1 => 'B1',
            self::B2 => 'B2',
            self::C1 => 'C1',
            self::C2 => 'C2',
        };
    }
}
