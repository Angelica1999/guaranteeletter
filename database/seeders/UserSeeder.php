<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
         ->count(1)
         ->state([
            'roles' => 'maif',
            'email' => 'maif@gmail.com',
        ])
        ->create();

        User::factory()
         ->count(1)
         ->state([
            'roles' => 'budget',
            'email' => 'budget@gmail.com',
        ])
        ->create();
    }
}
