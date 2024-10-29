<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use App\Enums\TransactionTypeEnum;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showReport(Request $request): View
    {
        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));

        $startOfMonth = Carbon::createFromFormat('Y-m', "$year-$month")->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', "$year-$month")->endOfMonth();

        $getTransactionsByType = function ($type) use ($startOfMonth, $endOfMonth) {
            return TransactionCategory::query()
                ->where('type', $type)
                ->withSum(['transactions' => function ($query) use ($startOfMonth, $endOfMonth) {
                    $query->whereBetween('when', [$startOfMonth, $endOfMonth]);
                }], 'amount')
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
