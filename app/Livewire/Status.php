<?php

namespace App\Livewire;

use App\Enums\LessonStatusEnum;
use App\Enums\PeriodEnum;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Year;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\On;

class Status extends Component
{
    public ?int $yearId = null;

    public array $count;

    #[On('update-calendar-year')]
    public function updateCalendarYear(int $yearId): void
    {
        $this->yearId = $yearId;
        $this->count = $this->lessonsCount();
    }

    #[On('refresh-lessons-count')]
    public function refreshLessonsCount(): void
    {
        $this->count = $this->lessonsCount();
    }

    private function lessonsCount(): array
    {
        $year = Year::query()->findOrFail($this->yearId);
        $lessons = Lesson::query()
            ->where('year_id', $this->yearId)
            ->onlyLessons()
            ->get();

        $lessonsFirstSemester = $this->getSemesterCount($lessons->where('period', '===', PeriodEnum::FIRST));
        $lessonsSecondSemester = $this->getSemesterCount($lessons->where('period', '===', PeriodEnum::SECOND));

        $lessonsAvailable = $lessonsFirstSemester['available'] + $lessonsSecondSemester['available'];
        $lessonsAssigned = $lessonsFirstSemester['assigned'] + $lessonsSecondSemester['assigned'];

        $lessonsAvailablePercentageFirstSemester = $this->getPercentage($lessonsFirstSemester['assigned'], array_sum($lessonsFirstSemester));
        $lessonsAvailablePercentageSecondSemester = $this->getPercentage($lessonsSecondSemester['assigned'], array_sum($lessonsSecondSemester));

        $totalFromSubjects = Subject::query()
            ->where('year_id', $this->yearId)
            ->sum('hours');

        return [
            'year_name' => $year->name,
            'first_semester_total' => $lessonsFirstSemester,
            'first_semester_percentage_available' => $lessonsAvailablePercentageFirstSemester,
            'second_semester_total' => $lessonsSecondSemester,
            'second_semester_percentage_available' => $lessonsAvailablePercentageSecondSemester,
            'total_assigned' => $lessonsAssigned,
            'total_available' => $lessonsAvailable,
            'total_from_subjects' => $totalFromSubjects,
            'total' => $lessons->count(),
        ];
    }

    private function getPercentage(int $count, int $total): int
    {
        $percentage = (int) (($count / $total) * 50);
        if ($percentage === 0 && $count > 0) {
            $percentage = 1;
        }

        return $percentage;
    }

    private function getSemesterCount(Collection $lessonsSemester): array
    {
        return [
            'available' => $lessonsSemester
                ->where('status', '===', LessonStatusEnum::AVAILABLE)
                ->count(),
            'assigned' => $lessonsSemester
                ->where('status', '!==', LessonStatusEnum::AVAILABLE)
                ->count(),
        ];
    }
}
