<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            'Computer Science',
            'Information Technology',
            'Software Engineering',
            'Data Science',
            'Cyber Security',
            'Network Engineering',
            'Web Development',
            'Mobile App Development',
            'Cloud Computing',
            'Artificial Intelligence',
        ];

        foreach ($specialties as $specialty) {
            Specialty::create(['name' => $specialty]);
        }
    }
}
