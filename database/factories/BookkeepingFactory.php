<?php

namespace Database\Factories;

use App\Models\Bookkeeping;
use App\Models\BookkeepingCategory;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookkeepingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookkeeping::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'year_id' => Year::query()->latest()->first(),
            'bookkeeping_category_id' => BookkeepingCategory::all()->random(),
            'customer_id' => Customer::all()->random(),
            'vendor_id' => Vendor::all()->random(),
            'value' => $this->faker->randomNumber(),
            'date' => $this->faker->dateTime(),
            'description' => $this->faker->text(),
            'images' => [],
        ];
    }
}
