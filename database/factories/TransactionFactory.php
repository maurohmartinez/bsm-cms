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
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'transaction_category_id' => TransactionCategory::all()->random(),
            'customer_id' => Customer::all()->random(),
            'vendor_id' => Vendor::all()->random(),
            'amount' => rand(1, 1000),
            'account' => $this->faker->randomElement([AccountEnum::CASH, AccountEnum::BANK]),
            'when' => $this->faker->dateTime(),
            'description' => $this->faker->text(),
            'images' => [],
        ];
    }
}
