<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       User::create([
           'name'=> 'Samer Ayash',
           'email'=> 'sam@gmail.com',
           'user_type'=> 'administrator',
           'email_verified_at'=> now(),
           'password'=> Hash::make('12345678'),
           'remember_token'=> Str::random(10),
       ]);
    }
}
