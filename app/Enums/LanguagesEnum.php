<?php

namespace App\Enums;

enum LanguagesEnum: string
{
    use EnumTrait;

    case ENGLISH = 'ENGLISH';
    case LATVIAN = 'LATVIAN';
    case RUSSIAN = 'RUSSIAN';
    case SPANISH = 'SPANISH';
}
