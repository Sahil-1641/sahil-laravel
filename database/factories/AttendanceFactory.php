<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'user_id' => User::factory(),
            'date' => now()->toDateString(),
            'status' => fake()->randomElement(['present', 'absent', 'late', 'excused']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
