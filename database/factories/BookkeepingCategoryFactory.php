<?php

namespace Database\Factories;

use App\Enums\BookkeepingTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BookkeepingCategory;

class BookkeepingCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookkeepingCategory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type' => $this->faker->randomElement(BookkeepingTypeEnum::options()),
        ];
    }
}
