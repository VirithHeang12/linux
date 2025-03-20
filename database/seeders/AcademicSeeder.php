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
        $academics  = [
            [
                'year'          => 1,
                'start_date'    => '2021-09-01',
                'end_date'      => '2022-06-30',
            ],
            [
                'year'          => 2,
                'start_date'    => '2022-09-01',
                'end_date'      => '2023-06-30',
            ],
            [
                'year'          => 3,
                'start_date'    => '2023-09-01',
                'end_date'      => '2024-06-30',
            ],
            [
                'year'          => 4,
                'start_date'    => '2024-09-01',
                'end_date'      => '2025-06-30',
            ],
        ];


        foreach ($academics as $academic) {
            Academic::create([
                'year'          => $academic['year'],
                'start_date'    => $academic['start_date'],
                'end_date'      => $academic['end_date'],
            ]);
        }

    }
}
