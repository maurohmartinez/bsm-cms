<?php

use App\Enums\LessonStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('day_id');
            $table->foreignId('year_id');
            $table->foreignId('teacher_id')->nullable();
            $table->foreignId('subject_id')->nullable();
            $table->foreignId('interpreter_id')->nullable();
            $table->json('extras')->nullable();
            $table->enum('status', LessonStatusEnum::optionsKeys())->default(LessonStatusEnum::AVAILABLE);
            $table->boolean('notify_teacher')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('year_id')
                ->references('id')
                ->on('years')
                ->cascadeOnDelete();
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->nullOnDelete();
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->nullOnDelete();
            $table->foreign('interpreter_id')
                ->references('id')
                ->on('interpreters')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
