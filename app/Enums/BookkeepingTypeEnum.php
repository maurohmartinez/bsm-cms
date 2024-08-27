<?php

namespace App\Enums;

enum BookkeepingTypeEnum: string
{
    use EnumTrait;

    case INCOME = 'INCOME';
    case EXPENSE = 'EXPENSE';

    public static function translatedOption(self $option): string
    {
        return match($option) {
            self::INCOME => 'Income',
            self::EXPENSE => 'Expense',
        };
    }
}
