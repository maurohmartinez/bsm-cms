<?php

namespace App\Http\Controllers;

use App\Enums\AccountEnum;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Enums\TransactionTypeEnum;
use App\Models\Year;
use App\Services\UserService;
use Backpack\CRUD\app\Library\Widget;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
    public function showReport(Request $request): View
    {
        if (!UserService::hasAccessTo('bookkeeping')) {
            abort(401);
        }

        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));

        $getTransactionsByType = function ($type) use ($month, $year) {
            return TransactionCategory::query()
                ->where('type', $type)
                ->withSum(['transactions' => function ($query) use ($month, $year) {
                    $query->whereBetween('when', [
                        Carbon::createFromDate($year, $month, 1)->startOfMonth()->startOfDay(),
                        Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay(),
                    ]);
                }], 'amount')
                ->whereNot('name', 'Transfer between accounts')
                ->get()
                ->filter(fn ($category) => $category->transactions_sum_amount > 0)
                ->mapWithKeys(fn ($category) => [$category->name => (int) $category->transactions_sum_amount])
                ->toArray();
        };

        $income = $getTransactionsByType(TransactionTypeEnum::INCOME->value);
        arsort($income);

        $expenses = $getTransactionsByType(TransactionTypeEnum::EXPENSE->value);
        arsort($expenses);

        Widget::add()
            ->type('bookkeeping')
            ->wrapper(['class' => 'col-12 mt-4'])
            ->to('before_content')
            ->content([
                'cash' => $this->getStatement(Transaction::getInitialMonth(), AccountEnum::CASH),
                'bank' => $this->getStatement(Transaction::getInitialMonth(), AccountEnum::BANK),
                'tuition_to_pay' => Year::getCurrent()->tuitionLeft,
            ]);

        Widget::add()
            ->type('chart')
            ->controller(Charts\BookkeepingChartController::class)
            ->wrapper(['class' => 'col-12 mt-4'])
            ->to('after_content');

        return view('crud::reports', [
            'income' => $income,
            'expenses' => $expenses,
            'selectedMonth' => $month,
            'selectedYear' => $year,
        ]);
    }

    private function getStatement(Carbon $yearStart, AccountEnum $account): string
    {
        $statement = Cache::remember(
            'statements_total_' . $account->value,
            config('cache.duration'),
            fn () => [
                TransactionTypeEnum::INCOME->value => Transaction::query()
                    ->withoutTrashed()
                    ->with(['transactionCategory'])
                    ->where('account', $account->value)
                    ->whereDate('when', '>=', $yearStart)
                    ->income()
                    ->sum('amount'),
                TransactionTypeEnum::EXPENSE->value => Transaction::query()
                    ->withoutTrashed()
                    ->with(['transactionCategory'])
                    ->where('account', $account->value)
                    ->whereDate('when', '>=', $yearStart)
                    ->expense()
                    ->sum('amount'),
            ]
        );

        return Transaction::toCurrency($statement[TransactionTypeEnum::INCOME->value] - $statement[TransactionTypeEnum::EXPENSE->value]);
    }
}
