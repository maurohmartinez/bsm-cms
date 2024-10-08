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
        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10)->unique();
            $table->date('first_period_starts_at');
            $table->date('first_period_ends_at');
            $table->date('second_period_starts_at');
            $table->date('second_period_ends_at');
            $table->integer('cost');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('years');
    }
};
