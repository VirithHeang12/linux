<?php

namespace Database\Factories;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id'        => $this->faker->unique()->randomNumber(8),
            'first_name'        => $this->faker->firstName,
            'last_name'         => $this->faker->lastName,
            'email'             => $this->faker->unique()->safeEmail,
            'phone'             => $this->faker->phoneNumber,
            'address'           => $this->faker->address,
            'date_of_birth'     => $this->faker->date(),
            'gender'            => $this->faker->randomElement(array_column(Gender::cases(), 'value')),
        ];
    }
}
