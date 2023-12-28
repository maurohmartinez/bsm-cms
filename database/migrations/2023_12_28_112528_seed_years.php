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
        $firstPeriodStarts = Carbon::create(2023, 9, 25);
        $firstPeriodEnds = Carbon::create(2023, 12, 15);
        $secondPeriodStarts = Carbon::create(2024, 1, 8);
        $secondPeriodEnds = Carbon::create(2024, 6, 7);

        Year::addOne($firstPeriodStarts, $firstPeriodEnds, $secondPeriodStarts, $secondPeriodEnds);

        $firstPeriodStarts = Carbon::create(2024, 9, 30);
        $firstPeriodEnds = Carbon::create(2024, 12, 20);
        $secondPeriodStarts = Carbon::create(2025, 1, 13);
        $secondPeriodEnds = Carbon::create(2025, 5, 30);

        Year::addOne($firstPeriodStarts, $firstPeriodEnds, $secondPeriodStarts, $secondPeriodEnds);
    }
};
