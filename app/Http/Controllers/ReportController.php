<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use App\Enums\TransactionTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController
{
    public function showReport(Request $request)
    {
        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));

        $startOfMonth = Carbon::createFromFormat('Y-m', "$year-$month")->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', "$year-$month")->endOfMonth();

        $getTransactionsByType = function ($type) use ($startOfMonth, $endOfMonth) {
            return TransactionCategory::where('type', $type)
                ->withSum(['transactions' => function ($query) use ($startOfMonth, $endOfMonth) {
                    $query->whereBetween('when', [$startOfMonth, $endOfMonth]);
                }], 'amount')
                ->get()
                ->filter(fn($category) => $category->transactions_sum_amount > 0)
                ->mapWithKeys(fn($category) => [$category->name => (int) $category->transactions_sum_amount])
                ->toArray();
        };

        $incomes = $getTransactionsByType(TransactionTypeEnum::INCOME->value);
        $expenses = $getTransactionsByType(TransactionTypeEnum::EXPENSE->value);

        $incomeData = array_values($incomes);
        $incomeLabels = array_keys($incomes);
        $expenseData = array_values($expenses);
        $expenseLabels = array_keys($expenses);

        return view(backpack_view('widgets.reports'), [
            'incomeData' => $incomeData,
            'incomeLabels' => $incomeLabels,
            'expenseData' => $expenseData,
            'expenseLabels' => $expenseLabels,
            'selectedMonth' => $month,
            'selectedYear' => $year,
        ]);
    }
}