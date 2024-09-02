<?php

namespace Database\Factories;

use App\Enums\LanguageLevelsEnum;
use App\Enums\LanguagesEnum;
use App\Models\Student;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'year_id' => Year::all()->random(),
            'email' => $this->faker->safeEmail(),
            'languages' => [
                LanguagesEnum::LATVIAN->value => $this->faker->randomElement(LanguageLevelsEnum::cases()),
                LanguagesEnum::ENGLISH->value => $this->faker->randomElement(LanguageLevelsEnum::cases()),
                LanguagesEnum::RUSSIAN->value => $this->faker->randomElement(LanguageLevelsEnum::cases()),
            ],
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'birth' => Carbon::now()->subYears(rand(20, 30)),
            'personal_code' => Str::random(8),
            'passport' => Str::random(10),
        ];
    }
}
