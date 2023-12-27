<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
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

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup(): void
    {
        CRUD::setModel(\App\Models\Subject::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/subject');
        CRUD::setEntityNameStrings('subject', 'subjects');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation(): void
    {
        CRUD::column('name');
        CRUD::column('year')->type('enum');
        CRUD::column('teacher');
        CRUD::column('hours');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(SubjectRequest::class);

        CRUD::field('name')->size(6);
        CRUD::field('year')->size(6)->type('enum');
        CRUD::field('hours')->size(6)->type('number');
        CRUD::field('teacher_id')->size(6)->type('relationship');
        CRUD::field('category_id')->size(6)->type('relationship')->attribute('full_name');
        CRUD::field('notes')->type('textarea');
        CRUD::field('files')->type('upload_multiple')->withFiles(true)->size(6);
        CRUD::field('is_official')->type('switch');
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     *
     * @return void
     */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
