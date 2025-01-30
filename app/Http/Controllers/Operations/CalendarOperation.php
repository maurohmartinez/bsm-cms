<?php

namespace App\Http\Controllers\Operations;

use App\Enums\LessonStatusEnum;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Year;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait CalendarOperation
{
    protected function setupCalendarRoutes(string $segment, string $routeName, string $controller): void
    {
        Route::get($segment . '/calendar', [
            'as' => $routeName . '.calendar',
            'uses' => $controller . '@calendar',
            'operation' => 'calendar',
        ]);
        Route::post($segment . '/calendar', [
            'as' => $routeName . '.getCalendarEvents',
            'uses' => $controller . '@getCalendarEvents',
            'operation' => 'calendar',
        ]);
    }

    protected function setupCalendarDefaults(): void
    {
        // Access
        $this->crud->allowAccess('calendar');

        // Config
        $this->crud->operation('calendar', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
            $this->crud->setupDefaultSaveActions();
        });
    }

    public function calendar(): View
    {
        $this->crud->hasAccessOrFail('calendar');
        $this->crud->setSubheading('All events in selected date range.');

        $this->data['crud'] = $this->crud;
        $this->data['currentYearId'] = Year::getCurrent()->id;

        return view("crud::operations.lessons", $this->data);
    }

    public function getCalendarEvents(): array
    {
        $returns = [];
        $this->crud->hasAccessOrFail('calendar');

        $start = request()->input('start');
        $end = request()->input('end');

        /** @var Collection<Lesson> $lessons */
        $lessons = Lesson::query()
            ->whereDate('starts_at', '>', $start)
            ->with(['subject', 'teacher', 'interpreter'])
            ->whereDate('ends_at', '<', $end)
            ->get();

        foreach ($lessons->groupBy('subject_id') as $lessons) {
            foreach ($lessons as $lesson) {
                /** @var Subject $subject */
                $subject = $lesson->subject()->with('teacher')->first();
                $teacher = $lesson->subject?->teacher;

                $title = match (true) {
                    !UserService::hasAccessTo('lessons') => (empty($lesson->extras['notes']) ? '-' : $lesson->extras['notes']),
                    default => $subject
                        ? '[' . $lesson->totalOf . '] ' . Str::words($subject->name, 2)
                        : LessonStatusEnum::translatedOption($lesson->status),
                };

                $returns [] = [
                    'id' => $lesson->id,
                    'title' => $title,
                    'teacherName' => UserService::hasAccessTo('lessons')
                        ? $teacher?->name
                        : Str::words($subject?->name, 2),
                    'translation' => UserService::hasAccessTo('lessons')
                        ? ($lesson->extras['notes'] ?? null)
                        : null,
                    'start' => $lesson->starts_at->format('Y-m-d H:i:s'),
                    'end' => $lesson->ends_at->format('Y-m-d H:i:s'),
                    'allDay' => false,
                    'color' => match (true) {
                        $lesson->is_chapel,
                        in_array($lesson->status, [LessonStatusEnum::WORSHIP_NIGHT, LessonStatusEnum::SPECIAL_ACTIVITY, LessonStatusEnum::TO_CONFIRM]) => LessonStatusEnum::getColor($lesson->status),
                        default => $subject?->color ?? 'lightgray',
                    },
                ];
            }
        }

        return $returns;
    }
}
