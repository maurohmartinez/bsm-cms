<?php

namespace App\Http\Controllers\Operations;

use App\Enums\LessonStatusEnum;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Year;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait CalendarOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
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

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
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

    /**
     * Method to handle the GET request and display the View with a Backpack form
     *
     * @return View
     */
    public function calendar(): View
    {
        $this->crud->hasAccessOrFail('calendar');
        $this->crud->setSubheading('All events in selected date range.');

        $this->data['crud'] = $this->crud;
        $this->data['currentYearId'] = Year::query()
            ->whereDate('first_period_starts_at', '<', now())
            ->whereDate('second_period_ends_at', '>', now())
            ->first()?->id;

        $this->data['currentYearId'] ??= Year::query()
            ->whereDate('first_period_starts_at', '>', now())
            ->first()?->id;

        $this->data['currentYearId'] ??= Year::query()
            ->whereDate('first_period_starts_at', '<', now())
            ->first()?->id;

        return view("crud::operations.lessons", $this->data);
    }

    /**
     * Method to handle the POST request and perform the operation
     *
     * @return array
     */
    public function getCalendarEvents(): array
    {
        $returns = [];
        $this->crud->hasAccessOrFail('calendar');

        $start = request()->input('start');
        $end = request()->input('end');

        /** @var \Illuminate\Support\Collection<Lesson> $lessons */
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
                $title = $subject
                    ? '[' . $lesson->number . '] ' . Str::words($subject->name, 2) . '/' . ($teacher?->name ?? '-')
                    : LessonStatusEnum::translatedOption($lesson->status);
                $title .= ($lesson->extras['notes'] ?? null) ? ' - ' . $lesson->extras['notes'] : '';

                $returns [] = [
                    'id' => $lesson->id,
                    'title' => $title,
                    'start' => $lesson->starts_at->format('Y-m-d H:i:s'),
                    'end' => $lesson->ends_at->format('Y-m-d H:i:s'),
                    'allDay' => false,
                    'color' => $lesson->is_chapel || $lesson->status === LessonStatusEnum::SPECIAL_ACTIVITY
                        ? LessonStatusEnum::getColor($lesson->status)
                        : ($subject?->color ?? 'lightgray'),
                ];
            }
        }

        return $returns;
    }
}
