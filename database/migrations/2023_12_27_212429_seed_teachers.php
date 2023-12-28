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
                    'is_local' => true,
                    'language' => LanguagesEnum::ENGLISH->value,
                ], [
                    'name' => 'Jūlija Martinesa',
                    'email' => 'julija.martinesa@gmail.com',
                    'phone' => '+37129752899',
                    'country' => 'LV',
                    'is_local' => true,
                    'language' => LanguagesEnum::LATVIAN->value,
                ], [
                    'name' => 'Matias Pecile',
                    'email' => 'maurohmartinez@gmail.com',
                    'phone' => '+37123209525',
                    'country' => 'AR',
                    'is_local' => true,
                    'language' => LanguagesEnum::ENGLISH->value,
                ], [
                    'name' => 'Doug Linser',
                    'email' => 'sdougl1@hotmail.com',
                    'phone' => '+18564051687',
                    'country' => 'US',
                    'is_local' => false,
                    'language' => LanguagesEnum::ENGLISH->value,
                ], [
                    'name' => 'Mārcis Zīverts',
                    'email' => 'marcis.ziverts@gmail.com',
                    'phone' => '+37126445107',
                    'country' => 'LV',
                    'is_local' => true,
                    'language' => LanguagesEnum::LATVIAN->value,
                ], [
                    'name' => 'Viktor Volchenko',
                    'email' => 'vitjku@gmail.com',
                    'phone' => '+37128630935',
                    'country' => 'LV',
                    'is_local' => true,
                    'language' => LanguagesEnum::RUSSIAN->value,
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
