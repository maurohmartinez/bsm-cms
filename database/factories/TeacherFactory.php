<?php

namespace Database\Factories;

use App\Enums\LanguagesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Teacher;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'image' => $this->faker->text(),
            'country' => $this->faker->country(),
            'language' => $this->faker->randomElement(LanguagesEnum::cases()),
        ];
    }
}
