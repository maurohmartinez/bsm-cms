<?php

namespace Database\Seeders;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\TransactionCategory::factory()->create([
            'name' => 'Transfer between accounts',
            'type' => TransactionTypeEnum::INCOME,
        ]);

        \App\Models\TransactionCategory::factory()->create([
            'name' => 'Transfer between accounts',
            'type' => TransactionTypeEnum::EXPENSE,
        ]);

        \App\Models\TransactionCategory::factory()->create([
            'name' => 'Offerings',
            'type' => TransactionTypeEnum::INCOME,
        ]);

        \App\Models\TransactionCategory::factory()->create([
            'name' => 'Tuition',
            'type' => TransactionTypeEnum::INCOME,
        ]);

        \App\Models\TransactionCategory::factory()->create([
            'name' => 'Garbage',
            'type' => TransactionTypeEnum::EXPENSE,
        ]);

        \App\Models\TransactionCategory::factory()->create([
            'name' => 'Salaries',
            'type' => TransactionTypeEnum::EXPENSE,
        ]);

        \App\Models\TransactionCategory::factory()->create([
            'name' => 'Electricity',
            'type' => TransactionTypeEnum::EXPENSE,
        ]);

        \App\Models\TransactionCategory::factory()->create([
            'name' => 'Gas',
            'type' => TransactionTypeEnum::EXPENSE,
        ]);

        \App\Models\Customer::factory()->create(['name' => 'Bank']);
        \App\Models\Customer::factory()->create(['name' => 'Cash']);
        \App\Models\Customer::factory(5)->create();

        \App\Models\Vendor::factory()->create(['name' => 'Bank']);
        \App\Models\Vendor::factory()->create(['name' => 'Cash']);
        \App\Models\Vendor::factory(5)->create();

        \App\Models\Transaction::factory(1000)->create();
    }
}
