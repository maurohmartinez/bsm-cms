<?php

namespace App\Http\Controllers;

use App\Enums\BookkeepingAccountEnum;
use App\Enums\BookkeepingTypeEnum;
use App\Models\BookkeepingCategory;
use App\Models\Customer;
use App\Models\Vendor;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
        CRUD::setRoute(config('backpack.base.route_prefix') . '/bookkeeping');
        CRUD::setEntityNameStrings('transaction', 'transactions');
    }

    protected function setupListOperation(): void
    {
        CRUD::column('amount')->prefix('€');
        CRUD::column('bookkeepingCategory')->label('Category');
        CRUD::column('when');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\BookkeepingRequest::class);

        Widget::add()->type('script')->content('js/bookkeeping-crud.js');

        CRUD::field('type')->fake(true)->type('select_from_array')->size(4)->options([
            BookkeepingTypeEnum::INCOME->value => 'Income',
            BookkeepingTypeEnum::EXPENSE->value => 'Outcome',
        ]);
        CRUD::field('when')->type('date_picker')->size(4)->default(Carbon::now()->format('Y-m-d'));
        CRUD::field('account')->type('select_from_array')->size(4)->options([
            BookkeepingAccountEnum::CASH->value => 'Cash',
            BookkeepingAccountEnum::BANK->value => 'Bank',
        ]);

        CRUD::field('bookkeepingCategory')
            ->label('Category')
            ->size(6)
            ->type('relationship')
            ->ajax(true)
            ->include_all_form_fields(true)
            ->dependencies(['type'])
            ->minimum_input_length(0);
        CRUD::field('amount')->prefix('€')->size(6);
        CRUD::field('customer')
            ->type('relationship')
            ->ajax(true)
            ->include_all_form_fields(true)
            ->dependencies(['bookkeepingCategory', 'account'])
            ->minimum_input_length(0);
        CRUD::field('vendor')
            ->type('relationship')
            ->ajax(true)
            ->include_all_form_fields(true)
            ->dependencies(['bookkeepingCategory', 'account'])
            ->minimum_input_length(0);;
        CRUD::field('images')->type('upload_multiple')->withFiles(true);
        CRUD::field('description');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    public function fetchBookkeepingCategory(): Paginator|JsonResponse
    {
        $params = collect(CRUD::getRequest()->get('form'));
        $type = $params->firstWhere('name', 'type')['value'] ?? null;
        $account = $params->firstWhere('name', 'account')['value'] ?? null;

        if (!$type || !$account) {
            return new JsonResponse();
        }

        return $this->fetch([
            'model' => BookkeepingCategory::class,
            'query' => fn (BookkeepingCategory|Builder $model) => $model->where('type', $type),
        ]);
    }

    public function fetchCustomer(): Paginator|JsonResponse
    {
        $params = collect(CRUD::getRequest()->get('form'));
        $bookkeepingCategory = $params->firstWhere('name', 'bookkeepingCategory')['value'] ?? null;
        $account = $params->firstWhere('name', 'account')['value'] ?? null;

        if (!$bookkeepingCategory || !$account) {
            return new JsonResponse();
        }

        return $this->fetch([
            'model' => Customer::class,
            'query' => fn (Customer|Builder $model) => $model->when(
                (int)$bookkeepingCategory === 1 || (int)$bookkeepingCategory === 2,
                fn (Builder $q) => $q->where('name', ($account === BookkeepingAccountEnum::BANK->value
                    ? BookkeepingAccountEnum::CASH->value
                    : BookkeepingAccountEnum::BANK->value
                ))),
        ]);
    }

    public function fetchVendor(): Paginator|JsonResponse
    {
        $params = collect(CRUD::getRequest()->get('form'));
        $bookkeepingCategory = $params->firstWhere('name', 'bookkeepingCategory')['value'] ?? null;
        $account = $params->firstWhere('name', 'account')['value'] ?? null;

        if (!$bookkeepingCategory || !$account) {
            return new JsonResponse();
        }

        return $this->fetch([
            'model' => Vendor::class,
            'query' => fn (Vendor|Builder $model) => $model->when(
                (int)$bookkeepingCategory === 1 || (int)$bookkeepingCategory === 2,
                fn (Builder $q) => $q->where('name', ($account === BookkeepingAccountEnum::BANK->value
                    ? BookkeepingAccountEnum::CASH->value
                    : BookkeepingAccountEnum::BANK->value
                ))),
        ]);
    }
}
