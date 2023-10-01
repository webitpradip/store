<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create a default user
        \App\Models\User::create([
            'name' => 'Default User',
            'email' => 'personal3980@gmail.com',
            'password' => \Hash::make('password123'),
        ]);
    }
}
