<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 *
 * @property-read CrudPanel $crud
 */
class AdminCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \App\Http\Controllers\Operations\PasswordOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/admin');
        CRUD::setEntityNameStrings('admin', 'admins');

        if (!UserService::hasAccessTo('admins')) {
            $this->crud->denyAllAccess();
        }
    }

    protected function setupListOperation(): void
    {
        CRUD::column('name');
        CRUD::column('email');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\UserRequest::class);

        CRUD::field('name');
        CRUD::field('email');
        CRUD::field('password');
    }

    protected function setupUpdateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\UserRequest::class);

        CRUD::field('name');
        CRUD::field('email');
    }

    protected function setupPasswordOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\PasswordRequest::class);
        CRUD::field('password');
    }
}
