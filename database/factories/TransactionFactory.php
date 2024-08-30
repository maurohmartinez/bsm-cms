<?php

namespace Database\Factories;

use App\Enums\AccountEnum;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Models\Customer;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'transaction_category_id' => TransactionCategory::all()->random(),
            'customer_id' => Customer::all()->random(),
            'vendor_id' => Vendor::all()->random(),
            'amount' => rand(1, 1000),
            'account' => $this->faker->randomElement([AccountEnum::CASH, AccountEnum::BANK]),
            'when' => Transaction::getInitialMonth()->addMonths(rand(0, 11)),
            'description' => $this->faker->text(),
            'images' => [],
        ];
    }
}
