<?php

namespace App\Observers;

use App\Enums\LessonStatusEnum;
use App\Enums\PeriodEnum;
use App\Models\Lesson;
use App\Models\Year;
use Carbon\Carbon;

class YearObserver
{
    public function created(Year $year): void
    {
        $this->buildSemesters($year);
    }

    private function buildSemesters(Year $year): void
    {
        $periodStarts = $year->first_period_starts_at;
        $periodEnds = $year->first_period_ends_at;
        $this->buildSemester($periodStarts, $periodEnds, PeriodEnum::FIRST);

        $periodStarts = $year->second_period_starts_at;
        $periodEnds = $year->second_period_ends_at;
        $this->buildSemester($periodStarts, $periodEnds, PeriodEnum::SECOND);
    }

    private function buildSemester(Carbon $periodStarts, Carbon $periodEnds, PeriodEnum $period): void
    {
        while (!$periodStarts->isAfter($periodEnds)) {
            if (!$periodStarts->isWeekend()) {
                // Add lessons to class day
                $scheduleLessons = Lesson::SCHEDULE[$periodStarts->dayOfWeek];
                foreach ($scheduleLessons as $lessons) {
                    Lesson::query()
                        ->create([
                            'starts_at' => $periodStarts->format('Y-m-d') . ' ' . $lessons[0],
                            'ends_at' => $periodStarts->format('Y-m-d') . ' ' . $lessons[1],
                            'year_id' => 1,
                            'period' => $period,
                            'status' => $lessons === ['19:00', '21:00']
                                ? LessonStatusEnum::AVAILABLE
                                : LessonStatusEnum::SPECIAL_ACTIVITY,
                        ]);
                }
            }
            $periodStarts->addDay();
        }
    }
}
