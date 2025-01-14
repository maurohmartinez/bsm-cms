<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Observers\SubjectObserver;
use App\Services\UserService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubjectCrudController
 *
 * @property-read CrudPanel $crud
 */
class SubjectCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \App\Http\Controllers\Operations\StudentGrades;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Subject::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/subject');
        CRUD::setEntityNameStrings('subject', 'subjects');

        if (!UserService::hasAccessTo('subjects')) {
            $this->crud->denyAllAccess();
        }
    }

    protected function setupListOperation(): void
    {
        CRUD::column('name');
        CRUD::column('year');
        CRUD::column('teacher');
        CRUD::column('hours');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\SubjectRequest::class);

        CRUD::field('name')->tab('General')->size(6);
        CRUD::field('year_id')->tab('General')->size(6)->type('relationship');
        CRUD::field('hours')->tab('General')->size(6)->type('number');
        CRUD::field('teacher_id')->tab('General')->size(6)->type('relationship');
        CRUD::field('category_id')->tab('General')->size(6)->type('relationship')->attribute('full_name');
        CRUD::field('notes')->tab('General')->type('textarea');
        CRUD::field('color')->tab('General')->type('color')->size(6);
        CRUD::field('files')->tab('General')->type('upload_multiple')->withFiles(true)->size(6);
        CRUD::field('is_official')->tab('General')->type('switch');
    }

    protected function setupStudentsGradesOperation(): void
    {
        if(!UserService::hasAccessTo('subjects')) {
            CRUD::denyAccess('studentsGrades');
        }

        CRUD::setValidation(\App\Http\Requests\SubjectGradesRequest::class);

        /** @var Subject $entry */
        $entry = CRUD::getCurrentEntry();
        $students = $entry->students()->get();

        SubjectObserver::createStudentsGrades($entry);

        CRUD::field('studentGrades')
            ->tab('Grades')
            ->type('relationship')
            ->label('Grades')
            ->allows_null(false)
            ->min_rows($students->count())
            ->max_rows($students->count())
            ->subfields([
                ['name' => 'student.name', 'wrapper' => ['class' => 'col-md-6'], 'allows_null' => false, 'type' => 'text', 'attributes' => ['readonly' => 'readonly']],
                ['name' => 'participation', 'type' => 'number', 'wrapper' => ['class' => 'col-md-3'], 'suffix' => '/100%'],
                ['name' => 'exam', 'type' => 'number', 'wrapper' => ['class' => 'col-md-3'], 'suffix' => '/100%'],
            ]);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
