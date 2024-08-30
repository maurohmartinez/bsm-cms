<?php

namespace App\Http\Controllers\Admin\Charts;

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

        $this->chart->dataset('Incomes', 'line', $this->getMonthlyTotals(Transaction::getInitialMonth()->copy(), TransactionTypeEnum::INCOME))
            ->backgroundColor('rgba(77, 189, 116, 0.4)');

        $this->chart->dataset('Expenses', 'line', $this->getMonthlyTotals(Transaction::getInitialMonth()->copy(), TransactionTypeEnum::EXPENSE))
            ->backgroundColor('rgba(255, 50, 50, 0.4)');

        $this->chart->displayAxes(true);

        $this->chart->displayLegend(true);
    }

    private function getMonthlyTotals(Carbon $yearStart, TransactionTypeEnum $type): array
    {
        $values = [];
        for ($i = 0; $i < 12; $i++) {
            $date = $yearStart->clone()->addMonths($i);
            $values [] = Cache::remember(
                'transaction_' . strtolower($type->value) . '_' . $date->month,
                config('cache.duration'),
                fn () => Transaction::query()
                        ->whereDate('when', '>=', $date)
                        ->whereDate('when', '<=', $date->endOfMonth())
                        ->whereHas('transactionCategory', fn (Builder $q) => $q->where('type', $type->value))
                        ->sum('amount') / 100,
            );
        }

        return $values;
    }
}
