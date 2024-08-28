<?php

use App\Enums\BookkeepingAccountEnum;
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
            $table->foreignId('bookkeeping_category_id')->nullable();
            $table->foreignId('customer_id')->nullable()->default(null);
            $table->foreignId('vendor_id')->nullable()->default(null);
            $table->integer('amount')->unsigned();
            $table->date('when');
            $table->enum('account', BookkeepingAccountEnum::options());
            $table->text('description')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bookkeeping_category_id')
                ->references('id')
                ->on('bookkeeping_categories')
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
