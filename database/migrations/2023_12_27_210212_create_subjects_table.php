<?php

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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('hours')->unsigned();
            $table->boolean('is_official');
            $table->text('notes')->nullable();
            $table->json('files')->nullable();
            $table->string('color');
            $table->foreignId('teacher_id');
            $table->foreignId('category_id');
            $table->foreignId('year_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->cascadeOnDelete();
            $table->foreign('category_id')
                ->references('id')
                ->on('subject_categories')
                ->cascadeOnDelete();
            $table->foreign('year_id')
                ->references('id')
                ->on('years')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
