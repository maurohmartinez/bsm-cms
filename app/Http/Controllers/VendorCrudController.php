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
class VendorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\Pro\Http\Controllers\Operations\InlineCreateOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Vendor::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/vendor');
        CRUD::setEntityNameStrings('vendor', 'vendors');

        if (!UserService::hasAccessTo('bookkeeping')) {
            $this->crud->denyAllAccess();
        }
    }

    protected function setupListOperation(): void
    {
        CRUD::column('name');
        CRUD::column('description');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\VendorRequest::class);

        CRUD::field('name');
        CRUD::field('description');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
