<?php

namespace App\Http\Controllers;

use App\Enums\BookkeepingTypeEnum;
use App\Models\BookkeepingCategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;

/**
 * Class SubjectCategoryCrudController
 *
 * @property-read CrudPanel $crud
 */
class BookkeepingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\Pro\Http\Controllers\Operations\FetchOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Bookkeeping::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/bookkeeping');
        CRUD::setEntityNameStrings('movement', 'movements');
    }

    protected function setupListOperation(): void
    {
        CRUD::column('year_id');
        CRUD::column('value');
        CRUD::column('bookkeepingCategory')->type('enum');
        CRUD::column('date');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\BookkeepingRequest::class);

        Widget::add()->type('script')->content('js/bookkeeping-crud.js');

        CRUD::field('year')->size(4)->default(env('CURRENT_YEAR_ID', 3));
        CRUD::field('date')->type('date_picker')->size(4)->default(Carbon::now()->format('Y-m-d'));

        CRUD::field('type')->fake(true)->type('select_from_array')->size(4)->options([
            BookkeepingTypeEnum::INCOME->value => 'Income',
            BookkeepingTypeEnum::EXPENSE->value => 'Expense',
        ]);

        CRUD::field('bookkeepingCategory')
            ->label('Category')
            ->size(6)
            ->type('select2_from_ajax')
            ->data_source(backpack_url('bookkeeping/fetch/bookkeeping-category'))
            ->method('POST')
            ->minimum_input_length(0);
        CRUD::field('value')->prefix('€')->size(6);
        CRUD::field('customer');
        CRUD::field('vendor');
        CRUD::field('description');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    public function fetchBookkeepingCategory(): Paginator|JsonResponse
    {
        return $this->fetch(BookkeepingCategory::class);
    }
}
