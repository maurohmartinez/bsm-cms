<?php

namespace App\Enums;

enum LessonStatusEnum: string
{
    use EnumTrait;

    case AVAILABLE = 'AVAILABLE';
    case TO_CONFIRM = 'TO_CONFIRM';
    case CONFIRMED = 'CONFIRMED';
    case SPECIAL_ACTIVITY = 'SPECIAL_ACTIVITY';
    case CHAPEL = 'CHAPEL';

    public static function getColor(self $case): string
    {
        return [
            self::AVAILABLE->value => 'primary',
            self::TO_CONFIRM->value => 'coral',
            self::CONFIRMED->value => 'darkcyan',
            self::CHAPEL->value => 'tomato',
            self::SPECIAL_ACTIVITY->value => 'lightgray',
        ][$case->value] ?? 'primary';
    }
}
