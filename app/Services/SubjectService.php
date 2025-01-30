<?php

namespace App\Services;

class SubjectService
{
    const EXAMS = 50;

    const PARTICIPATION_NOTES = 20;

    const ATTENDANCE = 30;

    public static function calculateFinalGrade(int $exams, int $participation, int $attendance): int
    {
        return round((min(100, $exams) * self::EXAMS) / 100)
            + round((min(100, $participation) * self::PARTICIPATION_NOTES) / 100)
            + round((min(100, $attendance) * self::ATTENDANCE) / 100);
    }

    public static function calculateAttendanceGrade(int $totalAttendanceCount, int $subjectHoursCount): int
    {
        return min(100, round(($totalAttendanceCount * 100) / $subjectHoursCount));
    }
}
