<?php

namespace App\Enums;

enum PeriodEnum: string
{
    use EnumTrait;

    case FIRST = 'FIRST';
    case SECOND = 'SECOND';
}
