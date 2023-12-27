<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subject;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'hours' => $this->faker->word(),
            'is_official' => $this->faker->boolean(),
            'teacher_id' => \App\Models\Teacher::factory(),
            'category_id' => \App\Models\SubjectCategory::factory(),
            'notes' => $this->faker->paragraph(),
            'files' => null,
        ];
    }
}
