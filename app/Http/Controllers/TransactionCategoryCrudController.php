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
class TransactionCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\Pro\Http\Controllers\Operations\InlineCreateOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\TransactionCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/transaction-category');
        CRUD::setEntityNameStrings('transaction category', 'transaction categories');

        if (!UserService::hasAccessTo('bookkeeping')) {
            $this->crud->denyAllAccess();
        }
    }

    protected function setupListOperation(): void
    {
        CRUD::column('name');
        CRUD::column('type')->type('enum');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\TransactionCategoryRequest::class);

        CRUD::field('name');

        $forceType = collect(CRUD::getRequest()->get('main_form_fields'))->firstWhere('name', 'type')['value'] ?? null;

        $forceType
            ? CRUD::field('type')->type('enum')->value($forceType)->attributes(['disabled' => 'disabled'])
            : CRUD::field('type')->type('enum');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
