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
            'Generation 10',
            'Generation 11',
            'Generation 12',
            'Generation 13',
            'Generation 14',
            'Generation 15',
            'Generation 16',
            'Generation 17',
            'Generation 18',
            'Generation 19',
            'Generation 20',
            'Generation 21',
            'Generation 22',
            'Generation 23',
            'Generation 24',
            'Generation 25',
            'Generation 26',
            'Generation 27',
            'Generation 28',
            'Generation 29',
            'Generation 30',
        ];

        foreach ($generations as $generation) {
            Generation::create([
                'name' => $generation,
            ]);
        }
    }
}
