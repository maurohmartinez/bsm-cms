<?php

namespace App\Http\Controllers;

use App\Enums\AccountEnum;
use App\Enums\TransactionTypeEnum;
use App\Models\Customer;
use App\Models\Student;
use App\Models\TransactionCategory;
use App\Models\Vendor;
use App\Services\UserService;
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
class TransactionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\Pro\Http\Controllers\Operations\FetchOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Transaction::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/transaction');
        CRUD::setEntityNameStrings('transaction', 'transactions');

        if (!UserService::hasAccessTo('bookkeeping')) {
            $this->crud->denyAllAccess();
        }
    }

    protected function setupListOperation(): void
    {
        CRUD::addBaseClause('orderByDesc', 'when');

        CRUD::filter('account')
            ->type('dropdown')
            ->values([AccountEnum::BANK->value => AccountEnum::BANK->value, AccountEnum::CASH->value => AccountEnum::CASH->value])
            ->label('By Account')
            ->whenActive(fn (string $value) => CRUD::addBaseClause('where', 'account', $value));

        CRUD::filter('by_type')
            ->type('dropdown')
            ->values([TransactionTypeEnum::INCOME->value => TransactionTypeEnum::INCOME->value, TransactionTypeEnum::EXPENSE->value => TransactionTypeEnum::EXPENSE->value])
            ->label('By Type')
            ->whenActive(fn (string $value) => CRUD::addBaseClause('whereHas', 'transactionCategory', fn (Builder $query) => $query->where('type', $value)));

        CRUD::filter('by_student')
            ->type('select2_ajax')
            ->values(backpack_url('transaction/fetch/by-student'))
            ->method('POST')
            ->placeholder('Find a student')
            ->minimum_input_length(0)
            ->whenActive(fn (int $studentId) => CRUD::addBaseClause('where', 'student_id', $studentId));

        CRUD::column('amount')->prefix('€ ');
        CRUD::column('transactionCategory.type')->label('Type')->type('enum')->wrapper([
            'class' => fn ($crud, $column, $entry) => $entry->transactionCategory->type === TransactionTypeEnum::INCOME ? 'badge bg-success' : 'badge bg-danger',
        ]);
        CRUD::column('account')->type('enum');
        CRUD::column('transactionCategory')->label('Category');
        CRUD::column('when');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\TransactionRequest::class);

        Widget::add()->type('script')->content('js/transaction-crud.js');
        CRUD::field('type')->fake(true)->type('select_from_array')->size(4)->options([
            TransactionTypeEnum::INCOME->value => 'Income',
            TransactionTypeEnum::EXPENSE->value => 'Expense',
        ])
            ->value(CRUD::getOperation() === 'update'
                ? CRUD::getCurrentEntry()->transactionCategory->type->value
                : null);
        CRUD::field('when')->type('date_picker')->size(4)->default(Carbon::now()->format('Y-m-d'));
        CRUD::field('account')->type('enum')->size(4)->default(AccountEnum::CASH->value);

        CRUD::field('transactionCategory')
            ->label('Category')
            ->size(6)
            ->type('relationship')
            ->ajax(true)
            ->include_all_form_fields(true)
            ->dependencies(['type'])
            ->minimum_input_length(0)
            ->inline_create([
                'include_main_form_fields' => true,
                'add_button_label' => 'Add category',
            ]);
        CRUD::field('amount')->size(6)->type('currency');
        CRUD::field('customer')
            ->type('relationship')
            ->ajax(true)
            ->include_all_form_fields(true)
            ->dependencies(['transactionCategory', 'account'])
            ->minimum_input_length(0)
            ->inline_create([
                'add_button_label' => 'Add customer',
            ]);
        CRUD::field('vendor')
            ->type('relationship')
            ->ajax(true)
            ->include_all_form_fields(true)
            ->dependencies(['transactionCategory', 'account'])
            ->minimum_input_length(0)
            ->inline_create([
                'add_button_label' => 'Add vendor',
            ]);
        CRUD::field('student')
            ->type('relationship')
            ->ajax(true)
            ->include_all_form_fields(true)
            ->dependencies(['transactionCategory'])
            ->minimum_input_length(0);
        CRUD::field('images')->type('upload_multiple')->withFiles(true);
        CRUD::field('description');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    public function fetchTransactionCategory(): Paginator|JsonResponse
    {
        $params = collect(CRUD::getRequest()->get('form'));
        $type = $params->firstWhere('name', 'type')['value'] ?? null;
        $account = $params->firstWhere('name', 'account')['value'] ?? null;

        if (!$type || !$account) {
            return new JsonResponse();
        }

        return $this->fetch([
            'model' => TransactionCategory::class,
            'query' => fn (TransactionCategory|Builder $model) => $model->where('type', $type),
        ]);
    }

    public function fetchCustomer(): Paginator|JsonResponse
    {
        $params = collect(CRUD::getRequest()->get('form'));
        $transactionCategory = $params->firstWhere('name', 'transactionCategory')['value'] ?? null;
        $account = $params->firstWhere('name', 'account')['value'] ?? null;

        if (!$transactionCategory || !$account) {
            return new JsonResponse();
        }

        return $this->fetch([
            'model' => Customer::class,
            'query' => fn (Customer|Builder $model) => $model->when(
                (int)$transactionCategory === 1 || (int)$transactionCategory === 2,
                fn (Builder $q) => $q->where('name', ($account === AccountEnum::BANK->value
                    ? AccountEnum::CASH->value
                    : AccountEnum::BANK->value
                ))),
        ]);
    }

    public function fetchVendor(): Paginator|JsonResponse
    {
        $params = collect(CRUD::getRequest()->get('form'));
        $transactionCategory = $params->firstWhere('name', 'transactionCategory')['value'] ?? null;
        $account = $params->firstWhere('name', 'account')['value'] ?? null;

        if (!$transactionCategory || !$account) {
            return new JsonResponse();
        }

        return $this->fetch([
            'model' => Vendor::class,
            'query' => fn (Vendor|Builder $model) => $model->when(
                (int)$transactionCategory === 1 || (int)$transactionCategory === 2,
                fn (Builder $q) => $q->where('name', ($account === AccountEnum::BANK->value
                    ? AccountEnum::CASH->value
                    : AccountEnum::BANK->value
                ))),
        ]);
    }

    public function fetchByStudent(): Paginator|JsonResponse
    {
        return $this->fetch(Student::class);
    }

    public function fetchStudent(): Paginator|JsonResponse
    {
        $params = collect(CRUD::getRequest()->get('form'));
        $transactionCategory = $params->firstWhere('name', 'transactionCategory')['value'] ?? null;

        if ((int)$transactionCategory !== 3) {
            return new JsonResponse();
        }

        return $this->fetch(Student::class);
    }
}
