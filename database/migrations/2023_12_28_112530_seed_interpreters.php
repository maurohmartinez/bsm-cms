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
        \App\Models\Interpreter::query()
            ->insert([
                [
                    'name' => 'Jūlija Martinesa',
                    'year_id' => 1,
                ], [
                    'name' => 'Santa Pecile',
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
