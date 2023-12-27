<?php

namespace App\Http\Interfaces;

use BackedEnum;

interface EnumWithTranslationInterface
{
    public static function translatedOptions(): array;

    public static function getTranslatedName(BackedEnum $case): string;
}
