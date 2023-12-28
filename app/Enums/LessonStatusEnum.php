<?php

namespace App\Enums;

enum LessonStatusEnum: string
{
    use EnumTrait;

    case AVAILABLE = 'AVAILABLE';
    case TO_CONFIRM = 'TO_CONFIRM';
    case CONFIRMED = 'CONFIRMED';
    case CANCELLED = 'CANCELLED';
}
