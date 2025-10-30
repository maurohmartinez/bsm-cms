<?php

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
                    'name' => 'Practical',
                    'code' => 'PRA',
                ], [
                    'name' => 'History',
                    'code' => 'HIS',
                ],
            ]);

        \App\Models\Subject::query()
            ->insert([
                [
                    'name' => 'God',
                    'hours' => 16,
                    'teacher_id' => 6,
                    'category_id' => 1,
                    'year_id' => 1,
                    'color' => '#20B2AA',
                ], [
                    'name' => 'Introduction to the Bible',
                    'hours' => 16,
                    'teacher_id' => 1,
                    'category_id' => 1,
                    'year_id' => 1,
                    'color' => '#FFA07A',
                ], [
                    'name' => 'Discipleship',
                    'hours' => 16,
                    'teacher_id' => 5,
                    'category_id' => 3,
                    'year_id' => 1,
                    'color' => '#9370DB',
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
