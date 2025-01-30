<?php

namespace App\Services;

class SubjectService
{
    const EXAMS = 50;

    const PARTICIPATION_NOTES = 20;

    const ATTENDANCE = 30;

    public static function calculateFinalGrade(int $exams, int $participation, int $attendance): int
    {
        return round(($exams * self::EXAMS) / 100)
            + round(($participation * self::PARTICIPATION_NOTES) / 100)
            + round(($attendance * self::ATTENDANCE) / 100);
    }

    public static function calculateAttendanceGrade(int $totalAttendanceCount, int $subjectHoursCount): int
    {
        return round(($totalAttendanceCount * 100) / $subjectHoursCount);
    }
}
