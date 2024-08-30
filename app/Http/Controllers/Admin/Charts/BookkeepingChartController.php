<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Enums\AccountEnum;
use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use Carbon\Carbon;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class BookkeepingChartController extends ChartController
{
    public function setup(): void
    {
        $this->chart = new Chart();
        $this->chart->labels(['Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug']);

        $yearStart = Carbon::create('first day of september');
        if ($yearStart->isFuture()) {
            $yearStart->subYear();
        }

        $this->chart->dataset('Incomes', 'line', $this->getMonthlyTotals($yearStart->copy(), TransactionTypeEnum::INCOME))
            ->backgroundColor('rgba(77, 189, 116, 0.4)');

        $this->chart->dataset('Expenses', 'line', $this->getMonthlyTotals($yearStart->copy(), TransactionTypeEnum::EXPENSE))
            ->backgroundColor('rgba(255, 50, 50, 0.4)');

        $this->chart->displayAxes(true);

        $this->chart->displayLegend(true);

        $this->chart->options['statement'] = [
            'cash' => $this->getStatement($yearStart, AccountEnum::CASH),
            'bank' => $this->getStatement($yearStart, AccountEnum::BANK),
        ];
    }

    private function getStatement(Carbon $yearStart, AccountEnum $account): string
    {
        $statement = Cache::remember(
            'transaction_' . strtolower($account->value) . '_' . $yearStart->year,
            config('cache.duration'),
            fn () => [
                TransactionTypeEnum::INCOME->value => Transaction::query()
                    ->with(['transactionCategory'])
                    ->where('account', $account->value)
                    ->whereDate('when', '>', $yearStart)
                    ->income()
                    ->sum('amount'),
                TransactionTypeEnum::EXPENSE->value => Transaction::query()
                    ->with(['transactionCategory'])
                    ->where('account', $account->value)
                    ->whereDate('when', '>', $yearStart)
                    ->expense()
                    ->sum('amount'),
            ]
        );

        return Transaction::toCurrency($statement[TransactionTypeEnum::INCOME->value] - $statement[TransactionTypeEnum::EXPENSE->value]);
    }

    private function getMonthlyTotals(Carbon $yearStart, TransactionTypeEnum $type): array
    {
        $values = [];
        for ($i = 0; $i < 12; $i++) {
            $date = $yearStart->addMonth();
            $values [] = Cache::remember(
                'transaction_' . strtolower($type->value) . '_' . $date->month,
                config('cache.duration'),
                fn () => Transaction::query()
                        ->whereDate('when', '>', $date)
                        ->whereHas('transactionCategory', fn (Builder $q) => $q->where('type', $type->value))
                        ->sum('amount') / 100,
            );
        }

        return $values;
    }
}
