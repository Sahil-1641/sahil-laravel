<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'class_name' => ['nullable', 'string', 'max:255'],
        ]);

        $students = Student::query()
            ->when($filters['search'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('student_number', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($filters['class_name'] ?? null, function (Builder $query, string $className): void {
                $query->where('class_name', $className);
            })
            ->orderBy('name')
            ->orderBy('id')
            ->paginate(12)
            ->withQueryString();

        $classes = Student::query()->distinct()->orderBy('class_name')->pluck('class_name');

        return view('students.index', compact('students', 'classes', 'filters'));
    }

    public function show(Student $student): View
    {
        $student->loadCount('attendances');

        $attendances = Attendance::query()
            ->whereBelongsTo($student)
            ->with('recordedBy')
            ->latest('date')
            ->limit(10)
            ->get();

        return view('students.show', compact('student', 'attendances'));
    }

    public function create(): View
    {
        return view('students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $student = Student::create($this->validatedStudentData($request));

        return redirect()->route('students.show', $student)
            ->with('success', 'Student added successfully.');
    }

    public function edit(Student $student): View
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $student->update($this->validatedStudentData($request, $student));

        return redirect()->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student and associated attendance records deleted.');
    }

    /**
     * @return array{
     *     student_number: string,
     *     name: string,
     *     email: string|null,
     *     phone: string|null,
     *     class_name: string,
     *     date_of_birth: string|null
     * }
     */
    private function validatedStudentData(Request $request, ?Student $student = null): array
    {
        return $request->validate([
            'student_number' => ['required', 'string', 'max:50', Rule::unique('students', 'student_number')->ignore($student)],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student)],
            'phone' => ['nullable', 'string', 'max:40'],
            'class_name' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
        ]);
    }
}
