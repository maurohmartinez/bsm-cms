<?php

namespace App\Enums;

use BackedEnum;

trait EnumTrait
{
    public static function options(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toString(): string
    {
        return implode(',', self::options());
    }

    public static function getTranslatedName(BackedEnum $case): string
    {
        return __('enum.'.self::class.'.'.$case->value);
    }
}
