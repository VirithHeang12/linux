<?php

namespace Database\Seeders;

use App\Models\Generation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generations = Generation::all();

        $classes = [
            'SLS',
            'M1',
            'M2',
            'M3',
            'M4',
            'M5',
            'M6',
            'M7',
            'M8',
            'M9',
            'M10',
            'A1',
            'A2',
            'A3',
            'A4',
            'A5',
            'A6',
            'A7',
            'A8',
            'A9',
            'A10',
            'E1',
            'E2',
            'E3',
            'E4',
            'E5',
            'E6',
            'E7',
            'E8',
            'E9',
            'E10',
        ];

        foreach ($generations as $generation) {
            foreach ($classes as $class) {
                $generation->classes()->create([
                    'name'          => $class,
                    'generation_id' => $generation->id,
                ]);
            }
        }


    }
}
