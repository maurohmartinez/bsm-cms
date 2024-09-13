<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubjectCategoryCrudController
 *
 * @property-read CrudPanel $crud
 */
class SubjectCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\SubjectCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/subject-category');
        CRUD::setEntityNameStrings('subject category', 'subject categories');

        if (!UserService::hasAccessTo('subjects')) {
            $this->crud->denyAllAccess();
        }
    }

    protected function setupListOperation(): void
    {
        CRUD::column('code');
        CRUD::column('name');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\SubjectCategoryRequest::class);

        CRUD::field('name');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
