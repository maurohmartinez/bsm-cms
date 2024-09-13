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
class YearCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Year::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/year');
        CRUD::setEntityNameStrings('year', 'years');

        if (!UserService::hasAccessTo('years')) {
            $this->crud->denyAllAccess();
        }
    }

    protected function setupListOperation(): void
    {
        CRUD::column('name');
        CRUD::column('cost')->prefix('€');
        CRUD::column('first_period_starts_at');
        CRUD::column('first_period_ends_at');
        CRUD::column('second_period_starts_at');
        CRUD::column('second_period_ends_at');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\YearRequest::class);

        CRUD::field('name');
        CRUD::field('cost')->prefix('€');
        CRUD::field('first_period_starts_at')->size(6)->type('date');
        CRUD::field('first_period_ends_at')->size(6)->type('date');
        CRUD::field('second_period_starts_at')->size(6)->type('date');
        CRUD::field('second_period_ends_at')->size(6)->type('date');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
