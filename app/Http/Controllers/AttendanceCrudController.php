<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class SubjectCategoryCrudController
 *
 * @property-read CrudPanel $crud
 */
class AttendanceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\StudentAttendance::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/attendance');
        CRUD::setEntityNameStrings('attendance', 'attendance');
    }

    protected function setupListOperation(): void
    {
        CRUD::filter('subject')
            ->type('select2')
            ->values(Subject::with('year')->get()->pluck('full_name', 'id')->toArray())
            ->whenActive(function (int $value) {
                CRUD::addBaseClause('whereHas', 'lesson', function (Builder $query) use ($value) {
                    $query->where('lessons.subject_id', $value);
                });
            });

        CRUD::filter('student')
            ->type('select2')
            ->values(Student::all()->pluck('name', 'id')->toArray())
            ->whenActive(fn (int $value) => CRUD::addBaseClause('where', 'student_id', $value));

        CRUD::filter('teacher')
            ->type('select2')
            ->values(Teacher::all()->pluck('name', 'id')->toArray())
            ->whenActive(function (int $value) {
                CRUD::addBaseClause('whereHas', 'lesson', function (Builder $query) use ($value) {
                    $query->whereHas('subject', function (Builder $q) use ($value) {
                        $q->where('subjects.teacher_id', $value);
                    });
                });
            });

        CRUD::column('student.name')->label('Student');
        CRUD::column('lesson.subject.name')->label('Subject');
        CRUD::column('lesson.teacher.name')->label('Teacher');
    }
}
