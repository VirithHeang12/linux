<?php

namespace Database\Seeders;

use App\Models\Academic;
use App\Models\Specialty;
use App\Models\StudentClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = Specialty::all();
        $academics = Academic::all();

        foreach ($specialties as $specialty) {
            foreach ($academics as $academic) {
                StudentClass::create(
                    [
                        'academic_id' => $academic->id,
                        'specialty_id' => $specialty->id,
                    ],
                );
            }
        };

    }
}
