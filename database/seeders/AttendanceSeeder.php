<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recorder = User::query()->where('email', 'test@example.com')->first();

        foreach (Student::query()->get() as $student) {
            foreach (range(0, 4) as $daysAgo) {
                $date = now()->subDays($daysAgo)->toDateString();
                $attendanceExists = Attendance::query()
                    ->whereBelongsTo($student)
                    ->whereDate('date', $date)
                    ->exists();

                if (! $attendanceExists) {
                    Attendance::create([
                        'student_id' => $student->id,
                        'date' => $date,
                        'user_id' => $recorder?->id,
                        'status' => $daysAgo === 1 ? 'late' : 'present',
                    ]);
                }
            }
        }
    }
}
