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
                    'is_official' => true,
                    'teacher_id' => 6,
                    'category_id' => 1,
                    'year_id' => 1,
                ], [
                    'name' => 'Introduction to the Bible',
                    'hours' => 16,
                    'is_official' => true,
                    'teacher_id' => 1,
                    'category_id' => 1,
                    'year_id' => 1,
                ], [
                    'name' => 'Discipleship',
                    'hours' => 16,
                    'is_official' => true,
                    'teacher_id' => 5,
                    'category_id' => 3,
                    'year_id' => 1,
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
