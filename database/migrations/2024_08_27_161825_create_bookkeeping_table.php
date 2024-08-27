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
        Schema::create('bookkeeping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id');
            $table->foreignId('bookkeeping_category_id')->nullable();
            $table->foreignId('customer_id')->nullable()->default(null);
            $table->foreignId('vendor_id')->nullable()->default(null);
            $table->integer('value')->unsigned();
            $table->date('date');
            $table->text('description');
            $table->json('images');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('year_id')
                ->references('id')
                ->on('years')
                ->cascadeOnDelete();

            $table->foreign('bookkeeping_category_id')
                ->references('id')
                ->on('years')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookkeeping');
    }
};
