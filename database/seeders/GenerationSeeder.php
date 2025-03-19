<?php

namespace Database\Seeders;

use App\Models\Generation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generations = [
            'Generation 1',
            'Generation 2',
            'Generation 3',
            'Generation 4',
            'Generation 5',
            'Generation 6',
            'Generation 7',
            'Generation 8',
            'Generation 9',
        ];

        foreach ($generations as $generation) {
            Generation::create([
                'name' => $generation,
            ]);
        }
    }
}
