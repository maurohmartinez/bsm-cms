<?php

namespace App\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubjectCrudController
 *
 * @property-read CrudPanel $crud
 */
class YearCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup(): void
    {
        CRUD::setModel(\App\Models\Year::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/year');
        CRUD::setEntityNameStrings('year', 'years');
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
        CRUD::column('first_period_starts_at');
        CRUD::column('first_period_ends_at');
        CRUD::column('second_period_starts_at');
        CRUD::column('second_period_ends_at');
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
        CRUD::setValidation(\App\Http\Requests\YearRequest::class);

        CRUD::field('name');
        CRUD::field('first_period_starts_at')->size(6)->type('date');
        CRUD::field('first_period_ends_at')->size(6)->type('date');
        CRUD::field('second_period_starts_at')->size(6)->type('date');
        CRUD::field('second_period_ends_at')->size(6)->type('date');
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
