<?php

namespace Database\Seeders;

use App\Models\SubjectCategory;
use Illuminate\Database\Seeder;

class SubjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubjectCategory::factory()->count(5)->create();
    }
}
