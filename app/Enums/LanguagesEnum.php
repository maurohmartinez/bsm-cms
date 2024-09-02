<?php

namespace App\Enums;

enum LanguagesEnum: string
{
    use EnumTrait;

    case LATVIAN = 'LATVIAN';
    case ENGLISH = 'ENGLISH';
    case RUSSIAN = 'RUSSIAN';

    public static function translatedOption(self $option): string
    {
        return match($option) {
            self::LATVIAN => 'Latvian',
            self::ENGLISH => 'English',
            self::RUSSIAN => 'Russian',
        };
    }
}
