<?php

use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $firstPeriodStarts = Carbon::create(2024, 9, 30);
        $firstPeriodEnds = Carbon::create(2024, 12, 20);
        $secondPeriodStarts = Carbon::create(2025, 1, 13);
        $secondPeriodEnds = Carbon::create(2025, 5, 30);

        /** @var Year $year */
        Year::query()
            ->create([
                'name' => '2024/2025',
                'first_period_starts' => $firstPeriodStarts,
                'first_period_ends' => $firstPeriodEnds,
                'second_period_starts' => $secondPeriodStarts,
                'second_period_ends' => $secondPeriodEnds,
            ]);
    }
};
