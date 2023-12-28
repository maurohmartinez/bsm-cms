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
        \App\Models\User::query()->insert([
            'name' => 'Mauro Martinez',
            'email' => 'maurohmartinez@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\User::query()->insert([
            'name' => 'Jūlija Martinesa',
            'email' => 'julija.martinesa@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\User::query()->insert([
            'name' => 'Matias Pecile',
            'email' => 'matiasneuquino@yahoo.com.ar',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\User::query()->insert([
            'name' => 'Santa Pecile',
            'email' => 'santa.pecile@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
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
