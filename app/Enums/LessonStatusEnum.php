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
    case HOLIDAY = 'HOLIDAY';
    case SPRING_BREAK = 'SPRING_BREAK';
    case CROSS_CULTURAL_EXPERIENCE = 'CROSS_CULTURAL_EXPERIENCE';
    case CHECKPOINT = 'CHECKPOINT';
    case EVENING_AVAILABLE = 'EVENING_AVAILABLE';
    case CHAPEL = 'CHAPEL_CONFIRMED';
    case PRAYER = 'PRAYER';
    case WORSHIP_NIGHT = 'WORSHIP_NIGHT';

    public static function getColor(self $case): string
    {
        return [
            self::AVAILABLE->value => 'lightgray',
            self::TO_CONFIRM->value => 'red',
            self::CONFIRMED->value => 'darkcyan',
            self::CHAPEL->value => 'darkcyan',
            self::PRAYER->value,
            self::WORSHIP_NIGHT->value => 'orange',
            self::EVENING_AVAILABLE->value => 'lightgray',
            self::SPECIAL_ACTIVITY->value => 'gray',
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
            self::HOLIDAY->value => 'Holiday',
            self::SPRING_BREAK->value => 'Spring Break',
            self::CROSS_CULTURAL_EXPERIENCE->value => 'Cross-cultural Experience',
            self::CHECKPOINT->value => 'Checkpoint',
        ];
    }

    public static function translatedOption(self $option): string
    {
        return match($option) {
            self::AVAILABLE => 'Available',
            self::TO_CONFIRM => 'Lesson to confirm',
            self::CONFIRMED => 'Lesson confirmed',
            self::SPECIAL_ACTIVITY => 'Special activity',
            self::EVENING_AVAILABLE => 'Evening available',
            self::CHAPEL => 'Chapel',
            self::PRAYER => 'Evening Prayer',
            self::WORSHIP_NIGHT => 'Worship evening',
            self::HOLIDAY => 'Holiday',
            self::SPRING_BREAK => 'Spring Break',
            self::CROSS_CULTURAL_EXPERIENCE => 'Cross-cultural Experience',
            self::CHECKPOINT => 'Checkpoint',
        };
    }

    public static function chapelsStatuses(): array
    {
        return [
            self::EVENING_AVAILABLE->value => 'Evening available',
            self::CHAPEL->value => 'Chapel',
            self::PRAYER->value => 'Evening Prayer',
            self::WORSHIP_NIGHT->value => 'Worship evening',
        ];
    }
}
