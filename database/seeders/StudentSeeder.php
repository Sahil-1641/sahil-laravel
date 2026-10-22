<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            ['STU-1001', 'Ava Patel', 'Grade 9-A'],
            ['STU-1002', 'Noah Kim', 'Grade 9-A'],
            ['STU-1003', 'Mia Garcia', 'Grade 10-B'],
            ['STU-1004', 'Ethan Brown', 'Grade 10-B'],
            ['STU-1005', 'Zara Ahmed', 'Grade 11-A'],
        ] as [$studentNumber, $name, $className]) {
            Student::firstOrCreate(
                ['student_number' => $studentNumber],
                [
                    'name' => $name,
                    'email' => strtolower(str_replace(' ', '.', $name)).'@example.edu',
                    'class_name' => $className,
                ],
            );
        }
    }
}
