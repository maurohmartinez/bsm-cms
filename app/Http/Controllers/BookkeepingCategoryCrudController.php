<?php

namespace App\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubjectCategoryCrudController
 *
 * @property-read CrudPanel $crud
 */
class BookkeepingCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\BookkeepingCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/bookkeeping-category');
        CRUD::setEntityNameStrings('category', 'categories');
    }

    protected function setupListOperation(): void
    {
        CRUD::column('name');
        CRUD::column('type')->type('enum');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\BookkeepingCategoryRequest::class);

        CRUD::field('name');
        CRUD::field('type')->type('enum');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
