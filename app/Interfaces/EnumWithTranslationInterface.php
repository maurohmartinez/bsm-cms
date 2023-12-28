<?php

namespace App\Interfaces;

use BackedEnum;

interface EnumWithTranslationInterface
{
    public static function translatedOptions(): array;

    public static function getTranslatedName(BackedEnum $case): string;
}
