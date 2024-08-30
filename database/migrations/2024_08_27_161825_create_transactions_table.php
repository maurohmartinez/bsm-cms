<?php

use App\Enums\AccountEnum;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_category_id')->nullable();
            $table->foreignId('customer_id')->nullable()->default(null);
            $table->foreignId('vendor_id')->nullable()->default(null);
            $table->integer('amount')->unsigned();
            $table->date('when');
            $table->enum('account', AccountEnum::options());
            $table->text('description')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('transaction_category_id')
                ->references('id')
                ->on('transaction_categories')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
