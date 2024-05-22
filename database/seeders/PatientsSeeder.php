<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patients;
use App\Models\User;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patients::factory()
         ->count(20)
        ->create()
        ->each(function ($patients) {
            $user = User::inRandomOrder()->first();
            $patients->update([
                'created_by' => $user->id
            ]);
        });;
    }
}
