<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Year;
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

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup(): void
    {
        CRUD::setModel(\App\Models\Lesson::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/lesson');
        CRUD::setEntityNameStrings('lesson', 'lesson');
        CRUD::addBaseClause('onlyLessons');
        CRUD::addBaseClause('with', ['teacher', 'year', 'subject']);
    }

    protected function setupListOperation(): void
    {
        CRUD::enableExportButtons();

        CRUD::filter('by_year')
            ->type('dropdown')
            ->values(Year::all()->pluck('name', 'id')->toArray())
            ->whenActive(fn (int $value) => CRUD::addBaseClause('where', 'year_id', $value));

        CRUD::filter('by_subject')
            ->type('select2')
            ->values(Subject::with('year')->get()->pluck('full_name', 'id')->toArray())
            ->whenActive(fn (int $value) => CRUD::addBaseClause('where', 'subject_id', $value));

        CRUD::filter('by_teacher')
            ->type('select2')
            ->values(Teacher::all()->pluck('name', 'id')->toArray())
            ->whenActive(fn (int $value) => CRUD::addBaseClause('where', 'teacher_id', $value));

        CRUD::column('id');
        CRUD::column('starts_at');
        CRUD::column('subject_id');
        CRUD::column('teacher.name')->label('Teacher');
        CRUD::column('status')->type('enum');
    }
}
