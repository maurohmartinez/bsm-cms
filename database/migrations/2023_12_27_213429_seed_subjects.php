<?php

use App\Enums\SubjectYearEnum;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \App\Models\SubjectCategory::query()
            ->insert([
                [
                    'name' => 'Theology',
                    'code' => 'THE',
                ], [
                    'name' => 'Bible',
                    'code' => 'BIB',
                ], [
                    'name' => 'History',
                    'code' => 'HIS',
                ],
            ]);

        \App\Models\Subject::query()
            ->insert([
                [
                    'name' => 'God',
                    'year' => SubjectYearEnum::_2023_2024,
                    'hours' => 16,
                    'is_official' => true,
                    'teacher_id' => 1,
                    'category_id' => 2,
                ], [
                    'name' => 'Introduction to the Bible',
                    'year' => SubjectYearEnum::_2023_2024,
                    'hours' => 16,
                    'is_official' => true,
                    'teacher_id' => 2,
                    'category_id' => 1,
                ], [
                    'name' => 'Geography',
                    'year' => SubjectYearEnum::_2023_2024,
                    'hours' => 16,
                    'is_official' => true,
                    'teacher_id' => 3,
                    'category_id' => 3,
                ],
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
