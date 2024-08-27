<?php

namespace App\Http\Controllers;

use App\Services\CountriesService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TeacherCrudController
 *
 * @property-read CrudPanel $crud
 */
class TeacherCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Teacher::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/teacher');
        CRUD::setEntityNameStrings('teacher', 'teachers');
    }

    protected function setupListOperation(): void
    {
        CRUD::column('name');
        CRUD::column('email');
        CRUD::column('language')->type('enum');

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\TeacherRequest::class);

        CRUD::field('name')->size(6);
        CRUD::field('email')->size(6);
        CRUD::field('country')->size(6)
            ->type('select2_from_array')
            ->options(array_map(function (array $value) {
                return $value['name'];
            }, CountriesService::getCountries()));
        CRUD::field('phone')->type('phone')->size(6);
        CRUD::field('language')->type('enum')->size(6);
        CRUD::field('is_local')->type('switch')->wrapper(['class' => 'mt-2']);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
