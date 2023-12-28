<?php

namespace App\Enums;

use App\Interfaces\EnumWithTranslationInterface;

enum LessonStatusEnum: string implements EnumWithTranslationInterface
{
    use EnumTrait;

    case AVAILABLE = 'AVAILABLE';
    case TO_CONFIRM = 'TO_CONFIRM';
    case CONFIRMED = 'CONFIRMED';
    case SPECIAL_ACTIVITY = 'SPECIAL_ACTIVITY';
    case EVENING_AVAILABLE = 'EVENING_AVAILABLE';
    case CHAPEL = 'CHAPEL_CONFIRMED';
    case PRAYER = 'PRAYER';
    case WORSHIP_NIGHT = 'WORSHIP_NIGHT';

    public static function getColor(self $case): string
    {
        return [
            self::AVAILABLE->value => 'primary',
            self::TO_CONFIRM->value => 'coral',
            self::CONFIRMED->value => 'darkcyan',
            self::CHAPEL->value => 'darkcyan',
            self::PRAYER->value,
            self::WORSHIP_NIGHT->value => 'primary',
            self::EVENING_AVAILABLE->value => 'tomato',
            self::SPECIAL_ACTIVITY->value => 'lightgray',
        ][$case->value] ?? 'primary';
    }

    public static function translatedOptions(): array
    {
        return [
            self::AVAILABLE->value => 'Available',
            self::TO_CONFIRM->value => 'Lesson to confirm',
            self::CONFIRMED->value => 'Lesson confirmed',
            self::CHAPEL->value => 'Chapel',
            self::PRAYER->value => 'Evening Prayer',
            self::WORSHIP_NIGHT->value => 'Worship evening',
            self::EVENING_AVAILABLE->value => 'Evening available',
            self::SPECIAL_ACTIVITY->value => 'Special activity',
        ];
    }

    public static function translatedOption(self $option): string
    {
        return match($option) {
            self::AVAILABLE => 'Available',
            self::TO_CONFIRM => 'Lesson to confirm',
            self::CONFIRMED => 'Lesson confirmed',
            self::CHAPEL => 'Chapel',
            self::PRAYER => 'Evening Prayer',
            self::WORSHIP_NIGHT => 'Worship evening',
            self::EVENING_AVAILABLE => 'Evening available',
            self::SPECIAL_ACTIVITY => 'Special activity',
        };
    }
}
