<?php

namespace App\Livewire;

use App\Enums\LessonStatusEnum;
use App\Enums\PeriodEnum;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Year;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;
use Livewire\Attributes\On;

class Status extends Component
{
    public int $yearId;

    public array $count;

    public function mount(?int $yearId): void
    {
        $this->yearId = $yearId;
        $this->updatedYearId();
    }

    public function updatedYearId(): void
    {
        Cookie::queue('calendar_year', $this->yearId);
        $this->count = $this->lessonsCount();
    }

    #[On('refresh-lessons-count')]
    public function refreshLessonsCount(): void
    {
        $this->count = $this->lessonsCount();
    }

    private function lessonsCount(): array
    {
        if (!$this->yearId) {
            return [];
        }

        $year = Year::query()->findOrFail($this->yearId);
        $lessons = $year->lessons()->onlyLessons()->get();

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
        $percentage = (int) (($count / ($total === 0 ? 1 : $total)) * 50);
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
