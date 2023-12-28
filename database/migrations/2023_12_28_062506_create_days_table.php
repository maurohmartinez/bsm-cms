<?php

use App\Enums\PeriodEnum;
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
        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->date('day');
            $table->integer('week_number');
            $table->enum('period', PeriodEnum::optionsKeys());
            $table->json('extras')->nullable();
            $table->foreignId('year_id');
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('days');
    }
};
