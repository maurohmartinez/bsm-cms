<?php

namespace App\Http\Controllers;

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

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Subject::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/subject');
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

        CRUD::field('name')->size(6);
        CRUD::field('year_id')->size(6)->type('relationship');
        CRUD::field('hours')->size(6)->type('number');
        CRUD::field('teacher_id')->size(6)->type('relationship');
        CRUD::field('category_id')->size(6)->type('relationship')->attribute('full_name');
        CRUD::field('notes')->type('textarea');
        CRUD::field('color')->type('color')->size(6);
        CRUD::field('files')->type('upload_multiple')->withFiles(true)->size(6);
        CRUD::field('is_official')->type('switch');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
