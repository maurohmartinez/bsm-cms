<?php

namespace Database\Seeders;

use App\Enums\BookkeepingTypeEnum;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\BookkeepingCategory::factory()->create([
            'name' => 'Transfer between accounts',
            'type' => BookkeepingTypeEnum::INCOME,
        ]);

        \App\Models\BookkeepingCategory::factory()->create([
            'name' => 'Transfer between accounts',
            'type' => BookkeepingTypeEnum::EXPENSE,
        ]);

        \App\Models\BookkeepingCategory::factory()->create([
            'name' => 'Offerings',
            'type' => BookkeepingTypeEnum::INCOME,
        ]);

         \App\Models\BookkeepingCategory::factory()->create([
            'name' => 'Tuition',
            'type' => BookkeepingTypeEnum::INCOME,
        ]);

        \App\Models\BookkeepingCategory::factory()->create([
            'name' => 'Garbage',
            'type' => BookkeepingTypeEnum::EXPENSE,
        ]);

        \App\Models\BookkeepingCategory::factory()->create([
            'name' => 'Salaries',
            'type' => BookkeepingTypeEnum::EXPENSE,
        ]);

        \App\Models\BookkeepingCategory::factory()->create([
            'name' => 'Electricity',
            'type' => BookkeepingTypeEnum::EXPENSE,
        ]);

        \App\Models\BookkeepingCategory::factory()->create([
            'name' => 'Gas',
            'type' => BookkeepingTypeEnum::EXPENSE,
        ]);

        \App\Models\Customer::factory()->create(['name' => 'Bank']);
        \App\Models\Customer::factory()->create(['name' => 'Cash']);
         \App\Models\Customer::factory(5)->create();

        \App\Models\Vendor::factory()->create(['name' => 'Bank']);
        \App\Models\Vendor::factory()->create(['name' => 'Cash']);
         \App\Models\Vendor::factory(5)->create();
    }
}
