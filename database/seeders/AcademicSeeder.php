<?php

namespace Database\Seeders;

use App\Models\Academic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years      = config('academic_year');

        $academics  = [
            [
                'start_date'    => '2021-09-01',
                'end_date'      => '2022-06-30',
            ],
            [
                'start_date'    => '2022-09-01',
                'end_date'      => '2023-06-30',
            ],
            [
                'start_date'    => '2023-09-01',
                'end_date'      => '2024-06-30',
            ],
            [
                'start_date'    => '2024-09-01',
                'end_date'      => '2025-06-30',
            ],
            [
                'start_date'    => '2025-09-01',
                'end_date'      => '2026-06-30',
            ]
        ];

        foreach ($years as $year) {
            foreach ($academics as $academic) {
                Academic::create([
                    'year'          => $year['year'],
                    'start_date'    => $academic['start_date'],
                    'end_date'      => $academic['end_date'],
                ]);
            }
        }
    }
}
