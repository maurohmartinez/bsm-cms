<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \App\Models\Year::query()
            ->insert([
                [
                    'name' => '2024/2025',
                    'first_period_starts' => Carbon::create(2024, 9, 30),
                    'first_period_ends' => Carbon::create(2024, 12, 20),
                    'second_period_starts' => Carbon::create(2025, 1, 13),
                    'second_period_ends' => Carbon::create(2025, 5, 30),
                ],
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
