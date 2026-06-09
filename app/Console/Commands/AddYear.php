<?php

namespace App\Console\Commands;

use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddYear extends Command
{
    protected $signature = 'year:add
                            {name : The year name, e.g. 2025/2026}
                            {cost : Tuition cost in whole currency units}
                            {first-period-starts : First period start date (YYYY-MM-DD)}
                            {first-period-ends : First period end date (YYYY-MM-DD)}
                            {second-period-starts : Second period start date (YYYY-MM-DD)}
                            {second-period-ends : Second period end date (YYYY-MM-DD)}';

    protected $description = 'Add a new school year';

    public function handle(): int
    {
        $name = $this->argument('name');
        $cost = (int) $this->argument('cost');
        $firstPeriodStarts  = Carbon::parse($this->argument('first-period-starts'));
        $firstPeriodEnds    = Carbon::parse($this->argument('first-period-ends'));
        $secondPeriodStarts = Carbon::parse($this->argument('second-period-starts'));
        $secondPeriodEnds   = Carbon::parse($this->argument('second-period-ends'));

        try {
            DB::beginTransaction();
            Year::addOne($name, $cost, $firstPeriodStarts, $firstPeriodEnds, $secondPeriodStarts, $secondPeriodEnds);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Failed to create year: {$e->getMessage()}");
            return self::FAILURE;
        }

        $this->info("Year \"{$name}\" created successfully.");

        return self::SUCCESS;
    }
}
