<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => '',
            'email' => '',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => '',
            'email' => '',
            'password' => bcrypt('password'),
            'role' => 'masyarakat'
        ]);
    }
}