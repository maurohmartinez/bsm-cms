<?php

namespace App\Http\Controllers;

use App\Enums\LessonStatusEnum;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Year;
use App\Services\UserService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubjectCategoryCrudController
 *
 * @property-read CrudPanel $crud
 */
class LessonCrudController extends CrudController
{
    use \App\Http\Controllers\Operations\CalendarOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Lesson::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/lesson');
        CRUD::setEntityNameStrings('lesson', 'lesson');

        if (!UserService::hasAccessTo('lessons')) {
            $this->crud->denyAccess(['list']);
        }

        CRUD::addBaseClause('onlyLessons');
        CRUD::addBaseClause('with', ['teacher', 'year', 'subject']);
    }

    protected function setupListOperation(): void
    {
        CRUD::enableExportButtons();
        CRUD::addBaseClause('orderBy', 'starts_at');

        CRUD::filter('year')
            ->type('dropdown')
            ->values(Year::all()->pluck('name', 'id')->toArray())
            ->whenActive(fn (int $value) => CRUD::addBaseClause('where', 'year_id', $value));

        CRUD::filter('subject')
            ->type('select2')
            ->values(Subject::with('year')->get()->pluck('full_name', 'id')->toArray())
            ->whenActive(fn (int $value) => CRUD::addBaseClause('where', 'subject_id', $value));

        CRUD::filter('teacher')
            ->type('select2')
            ->values(Teacher::all()->pluck('name', 'id')->toArray())
            ->whenActive(fn (int $value) => CRUD::addBaseClause('where', 'teacher_id', $value));

        CRUD::filter('status')
            ->type('dropdown')
            ->options([
                LessonStatusEnum::AVAILABLE->value => LessonStatusEnum::translatedOption(LessonStatusEnum::AVAILABLE),
                LessonStatusEnum::TO_CONFIRM->value => LessonStatusEnum::translatedOption(LessonStatusEnum::TO_CONFIRM),
                LessonStatusEnum::CONFIRMED->value => LessonStatusEnum::translatedOption(LessonStatusEnum::CONFIRMED),
            ])
            ->whenActive(fn (string $value) => CRUD::addBaseClause('where', 'status', $value));

        CRUD::column('number');
        CRUD::column('starts_at');
        CRUD::column('subject_id');
        CRUD::column('teacher.name')->label('Teacher');
        CRUD::column('status')->type('enum');
    }
}
