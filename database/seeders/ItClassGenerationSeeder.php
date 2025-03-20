<?php

namespace Database\Seeders;

use App\Models\Generation;
use App\Models\ItClass;
use App\Models\ItClassGeneration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItClassGenerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generations = Generation::all();
        $classes = ItClass::all();

        foreach ($classes as $class) {
            foreach ($generations as $generation) {
                ItClassGeneration::create([
                    'it_class_id'           => $class->id,
                    'generation_id'         => $generation->id,
                ]);
            }
        }
    }
}
