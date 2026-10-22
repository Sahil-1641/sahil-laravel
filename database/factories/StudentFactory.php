<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
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
            'student_number' => fake()->unique()->numerify('STU-#####'),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'class_name' => fake()->randomElement(['Grade 9-A', 'Grade 10-B', 'Grade 11-A']),
            'date_of_birth' => fake()->dateTimeBetween('-20 years', '-10 years')->format('Y-m-d'),
        ];
    }
}
