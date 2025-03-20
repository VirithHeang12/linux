<?php

namespace Database\Seeders;

use App\Models\Academic;
use App\Models\ItClassGeneration;
use App\Models\ItClassGenerationAcademic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItClassGenerationAcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academics = Academic::all();
        $itClassGenerations = ItClassGeneration::all();
        $rooms = collect(config('rooms'))->map(function ($room) {
            return $room['building'] . $room['room_no'];
        })->toArray();

        foreach ($itClassGenerations as $itClassGeneration) {
            foreach ($academics as $academic) {
                ItClassGenerationAcademic::create([
                    'it_class_generation_id'    => $itClassGeneration->id,
                    'academic_id'               => $academic->id,
                    'room_no'                   => fake()->randomElement($rooms),
                ]);
            }
        }
    }
}
