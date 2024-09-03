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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id');
            $table->string('name');
            $table->string('email');
            $table->json('languages');
            $table->string('country');
            $table->string('city');
            $table->date('birth');
            $table->string('personal_code');
            $table->string('passport');
            $table->json('images')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('students');
    }
};
