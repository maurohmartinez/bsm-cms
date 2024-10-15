<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Services\UserService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubjectCategoryCrudController
 *
 * @property-read CrudPanel $crud
 */
class ReportController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\Pro\Http\Controllers\Operations\InlineCreateOperation;
    
    public function setup(): void
    {
        CRUD::setModel(\App\Models\Transaction::class); // Transaction
        CRUD::setRoute(config('backpack.base.route_prefix').'/report');
        CRUD::setEntityNameStrings('transaction', 'transactions');

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
        CRUD::setValidation(\App\Http\Requests\ReportRequest::class);

        CRUD::field('name');
        CRUD::field('description');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
    
    public function showReport()
{
    $incomeCategories = TransactionCategory::where('type', 'INCOME')->pluck('id')->toArray();
    $expenseCategories = TransactionCategory::where('type', 'EXPENSE')->pluck('id')->toArray();

    $incomes = Transaction::whereIn('transaction_category_id', $incomeCategories)
        ->groupBy('transaction_category_id')
        ->selectRaw('transaction_category_id, SUM(amount) as total')
        ->pluck('total', 'transaction_category_id')
        ->map(fn($value) => (int) $value)
        ->toArray();

    $expenses = Transaction::whereIn('transaction_category_id', $expenseCategories)
        ->groupBy('transaction_category_id')
        ->selectRaw('transaction_category_id, SUM(amount) as total')
        ->pluck('total', 'transaction_category_id')
        ->map(fn($value) => (int) $value)
        ->toArray();

    $incomeLabels = TransactionCategory::whereIn('id', $incomeCategories)->pluck('name')->toArray();
    $expenseLabels = TransactionCategory::whereIn('id', $expenseCategories)->pluck('name')->toArray();

    return view(backpack_view('widgets.reports'), [
        'incomeData' => array_values($incomes),
        'incomeLabels' => $incomeLabels,
        'expenseData' => array_values($expenses),
        'expenseLabels' => $expenseLabels,
    ]);
}

    

}