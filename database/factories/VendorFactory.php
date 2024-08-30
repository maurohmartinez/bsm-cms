<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Vendor;

class VendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vendor::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Maxima ' . rand(1, 10),
                'Rimi ' . rand(1, 10),
                'Lidl ' . rand(1, 10),
                'Top ' . rand(1, 10),
                'Elvi ' . rand(1, 10),
                'Elektrum ' . rand(1, 10),
            ]),
            'description' => $this->faker->text(),
        ];
    }
}
