<?php

namespace Database\Seeders;

use App\Models\Academic;
use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = Specialty::all();

        // Loop through each specialty and create academic records

        foreach ($specialties as $specialty) {
            Academic::create(
                [
                    'specialty_id' => $specialty->id,
                    'start_date' => '2023-01-01',
                    'end_date' => '2023-12-31',
                ],
            );
        }
    }
}
