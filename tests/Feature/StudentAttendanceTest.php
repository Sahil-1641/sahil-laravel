<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentAttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_records_can_be_searched_and_filtered(): void
    {
        Student::factory()->create([
            'name' => 'Avery Johnson',
            'student_number' => 'STU-501',
            'class_name' => 'Grade 10-A',
        ]);
        Student::factory()->create([
            'name' => 'Jordan Lee',
            'student_number' => 'STU-502',
            'class_name' => 'Grade 11-B',
        ]);

        $this->get(route('students.index', ['search' => 'Avery', 'class_name' => 'Grade 10-A']))
            ->assertOk()
            ->assertSee('Avery Johnson')
            ->assertDontSee('Jordan Lee');
    }

    public function test_authenticated_user_can_create_update_and_delete_a_student(): void
    {
        $user = User::factory()->create();
        $studentData = [
            'student_number' => 'STU-601',
            'name' => 'Morgan Rivera',
            'email' => 'morgan@example.edu',
            'phone' => '555-0102',
            'class_name' => 'Grade 9-A',
            'date_of_birth' => '2011-04-12',
        ];

        $this->actingAs($user)
            ->post(route('students.store'), $studentData)
            ->assertRedirect(route('students.show', 1))
            ->assertSessionHas('success', 'Student added successfully.');

        $student = Student::query()->firstOrFail();
        $attendance = Attendance::factory()->for($student)->create();

        $this->put(route('students.update', $student), [
            ...$studentData,
            'name' => 'Morgan Rivera-Smith',
            'date_of_birth' => '',
        ])
            ->assertRedirect(route('students.show', $student))
            ->assertSessionHas('success', 'Student updated successfully.');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Morgan Rivera-Smith',
            'date_of_birth' => null,
        ]);

        $this->delete(route('students.destroy', $student))
            ->assertRedirect(route('students.index'))
            ->assertSessionHas('success', 'Student and associated attendance records deleted.');

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
        $this->assertDatabaseMissing('attendances', ['id' => $attendance->id]);
    }

    public function test_student_numbers_and_emails_must_be_unique(): void
    {
        $user = User::factory()->create();
        Student::factory()->create([
            'student_number' => 'STU-701',
            'email' => 'existing@example.edu',
        ]);

        $this->actingAs($user)
            ->from(route('students.create'))
            ->post(route('students.store'), [
                'student_number' => 'STU-701',
                'name' => 'Another Student',
                'email' => 'existing@example.edu',
                'class_name' => 'Grade 10-A',
            ])
            ->assertRedirect(route('students.create'))
            ->assertSessionHasErrors(['student_number', 'email']);
    }

    public function test_student_and_attendance_fields_are_validated(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();

        $this->actingAs($user)
            ->from(route('students.create'))
            ->post(route('students.store'), [])
            ->assertRedirect(route('students.create'))
            ->assertSessionHasErrors(['student_number', 'name', 'class_name']);

        $this->from(route('attendances.create'))
            ->post(route('attendances.store'), [
                'student_id' => $student->id,
                'date' => '2026-05-04',
                'status' => 'unknown',
            ])
            ->assertRedirect(route('attendances.create'))
            ->assertSessionHasErrors('status');

        $this->assertDatabaseCount('attendances', 0);
    }

    public function test_student_names_and_attendance_notes_are_escaped_in_html(): void
    {
        $studentName = '<script>alert("student")</script>';
        $attendanceNotes = '<img src=x onerror=alert(1)>';
        $student = Student::factory()->create(['name' => $studentName]);
        $attendance = Attendance::factory()->for($student)->create(['notes' => $attendanceNotes]);

        $this->get(route('attendances.show', $attendance))
            ->assertOk()
            ->assertSee($studentName)
            ->assertSee($attendanceNotes)
            ->assertDontSee($studentName, false)
            ->assertDontSee($attendanceNotes, false);
    }

    public function test_attendance_records_can_be_filtered_by_student_status_and_date(): void
    {
        $student = Student::factory()->create([
            'name' => 'Taylor Chen',
            'student_number' => 'STU-801',
        ]);
        $matchingAttendance = Attendance::factory()->for($student)->create([
            'date' => '2026-04-20',
            'status' => 'absent',
        ]);
        $otherAttendance = Attendance::factory()->for($student)->create([
            'date' => '2026-04-21',
            'status' => 'present',
        ]);

        $this->get(route('attendances.index', [
            'search' => 'Taylor',
            'status' => 'absent',
            'date_from' => '2026-04-20',
            'date_to' => '2026-04-20',
        ]))
            ->assertOk()
            ->assertSee(route('attendances.show', $matchingAttendance))
            ->assertDontSee(route('attendances.show', $otherAttendance));
    }

    public function test_authenticated_user_can_create_update_and_delete_attendance(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        $attendanceData = [
            'student_id' => $student->id,
            'date' => '2026-05-01',
            'status' => 'present',
            'notes' => 'On time.',
        ];

        $this->actingAs($user)
            ->post(route('attendances.store'), $attendanceData)
            ->assertRedirect(route('attendances.show', 1))
            ->assertSessionHas('success', 'Attendance recorded successfully.');

        $attendance = Attendance::query()->firstOrFail();
        $this->assertDatabaseHas('attendances', [
            'id' => $attendance->id,
            'user_id' => $user->id,
        ]);

        $this->put(route('attendances.update', $attendance), [
            ...$attendanceData,
            'date' => '2026-05-02',
            'status' => 'late',
            'notes' => 'Arrived after the bell.',
        ])
            ->assertRedirect(route('attendances.show', $attendance))
            ->assertSessionHas('success', 'Attendance record updated successfully.');

        $this->assertDatabaseHas('attendances', [
            'id' => $attendance->id,
            'status' => 'late',
            'notes' => 'Arrived after the bell.',
        ]);
        $this->assertSame('2026-05-02', $attendance->fresh()->date->toDateString());

        $this->delete(route('attendances.destroy', $attendance))
            ->assertRedirect(route('attendances.index'))
            ->assertSessionHas('success', 'Attendance record deleted successfully.');

        $this->assertDatabaseMissing('attendances', ['id' => $attendance->id]);
    }

    public function test_a_student_cannot_have_two_attendance_records_on_the_same_date(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        Attendance::factory()->for($student)->create(['date' => '2026-05-03']);

        $this->actingAs($user)
            ->from(route('attendances.create'))
            ->post(route('attendances.store'), [
                'student_id' => $student->id,
                'date' => '2026-05-03',
                'status' => 'absent',
            ])
            ->assertRedirect(route('attendances.create'))
            ->assertSessionHasErrors('date');

        $this->assertDatabaseCount('attendances', 1);
    }

    public function test_attendance_report_summarizes_records_for_a_date_range(): void
    {
        $firstStudent = Student::factory()->create([
            'name' => 'Riley Park',
            'student_number' => 'STU-901',
        ]);
        $secondStudent = Student::factory()->create([
            'name' => 'Casey Morgan',
            'student_number' => 'STU-902',
        ]);

        Attendance::factory()->for($firstStudent)->create(['date' => '2026-06-10', 'status' => 'present']);
        Attendance::factory()->for($firstStudent)->create(['date' => '2026-06-11', 'status' => 'absent']);
        Attendance::factory()->for($secondStudent)->create(['date' => '2026-06-12', 'status' => 'late']);

        $this->get(route('reports.index', [
            'date_from' => '2026-06-10',
            'date_to' => '2026-06-11',
        ]))
            ->assertOk()
            ->assertSee('Riley Park')
            ->assertSee('Casey Morgan')
            ->assertSee('50.0%')
            ->assertSee('2');
    }

    public function test_write_actions_require_authentication_while_read_pages_remain_public(): void
    {
        $student = Student::factory()->create();
        $attendance = Attendance::factory()->for($student)->create();

        $this->get(route('students.index'))->assertOk();
        $this->get(route('students.show', $student))->assertOk();
        $this->get(route('attendances.index'))->assertOk();
        $this->get(route('attendances.show', $attendance))->assertOk();
        $this->get(route('reports.index'))->assertOk();

        $this->get(route('students.create'))->assertRedirect(route('login'));
        $this->get(route('students.edit', $student))->assertRedirect(route('login'));
        $this->post(route('students.store'), [])->assertRedirect(route('login'));
        $this->put(route('students.update', $student), [])->assertRedirect(route('login'));
        $this->delete(route('students.destroy', $student))->assertRedirect(route('login'));

        $this->get(route('attendances.create'))->assertRedirect(route('login'));
        $this->get(route('attendances.edit', $attendance))->assertRedirect(route('login'));
        $this->post(route('attendances.store'), [])->assertRedirect(route('login'));
        $this->put(route('attendances.update', $attendance), [])->assertRedirect(route('login'));
        $this->delete(route('attendances.destroy', $attendance))->assertRedirect(route('login'));
    }

    public function test_database_seeders_can_be_run_more_than_once(): void
    {
        $this->seed();
        $this->seed();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('students', 5);
        $this->assertDatabaseCount('attendances', 25);
    }
}
