<?php

namespace App\Enums;

enum LessonStatusEnum: string
{
    use EnumTrait;

    case AVAILABLE = 'AVAILABLE';
    case TO_CONFIRM = 'TO_CONFIRM';
    case CONFIRMED = 'CONFIRMED';
    case CANCELLED = 'CANCELLED';
    case SPECIAL_ACTIVITY = 'SPECIAL_ACTIVITY';

    public static function getColor(self $case): string
    {
        return [
            'AVAILABLE' => 'primary',
            'TO_CONFIRM' => 'coral',
            'CONFIRMED' => 'darkcyan',
            'CANCELLED' => 'tomato',
            'SPECIAL_ACTIVITY' => 'lightgray',
        ][$case->value] ?? 'primary';
    }
}
