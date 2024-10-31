<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use App\Enums\TransactionTypeEnum;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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

        return view(backpack_view('widgets.reports'), [
            'income' => $income,
            'expenses' => $expenses,
            'selectedMonth' => $month,
            'selectedYear' => $year,
        ]);
    }
}
