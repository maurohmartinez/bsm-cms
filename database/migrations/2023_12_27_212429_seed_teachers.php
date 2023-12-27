<?php

use App\Enums\LanguagesEnum;
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
        \App\Models\Teacher::query()
            ->insert([
                [
                    'name' => 'Mauro Martinez',
                    'email' => 'maurohmartinez@gmail.com',
                    'phone' => '+37127710615',
                    'country' => 'AR',
                    'language' => LanguagesEnum::ENGLISH->value,
                ], [
                    'name' => 'Mihail Dmitruk',
                    'email' => 'mihail@gmail.com',
                    'phone' => '+37127710615',
                    'country' => 'LV',
                    'language' => LanguagesEnum::RUSSIAN->value,
                ], [
                    'name' => 'Mārcis Zīverts',
                    'email' => 'marcis@gmail.com',
                    'phone' => '+37127710615',
                    'country' => 'LV',
                    'language' => LanguagesEnum::LATVIAN->value,
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
