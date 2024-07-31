<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    DB::table('users')->insert([
        [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('2222'), // You can replace 'aaaa' with the desired password
            'role' => 2, // Set role to 2 for admin
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Kumari',
            'email' => 'simonsec@simonas.net',
            'password' => Hash::make('1111'), // You can replace 'aaaa' with the desired password
            'role' => 1, // Set role to 1 for regular user
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Dilrukshi',
            'email' => 'dilrukshi@simonas.net',
            'password' => Hash::make('3333'), // You can replace 'aaaa' with the desired password
            'role' => 3, // Set role to 3 for another type of user
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);
}

}
