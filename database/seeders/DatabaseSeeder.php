<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' =>'Leonel',
            'email' => 'leonellopez647@gmail.com',
            'password' => Hash::make('Leonel23'),
        ]);
    }
}
