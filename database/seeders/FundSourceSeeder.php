<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FundSource;
use App\Models\Facility;
use App\Models\User;

class FundSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FundSource::factory()
        ->count(30)
        ->create()
        ->each(function ($fundSource) {
            $facility = Facility::where('hospital_type', 'private')->inRandomOrder()->first();
            $user = User::inRandomOrder()->first();
            $fundSource->update([
                'facility_id' => $facility->id,
                'created_by' => $user->id
            ]);
        });
    }
}
