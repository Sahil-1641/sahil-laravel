<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'student_id' => ['nullable', 'integer', 'exists:students,id'],
            'status' => ['nullable', Rule::in(['present', 'absent', 'late', 'excused'])],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $attendances = Attendance::query()
            ->with(['student', 'recordedBy'])
            ->when($filters['search'] ?? null, function (Builder $query, string $search): void {
                $query->whereHas('student', function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('student_number', 'like', "%{$search}%");
                });
            })
            ->when($filters['student_id'] ?? null, function (Builder $query, int $studentId): void {
                $query->where('student_id', $studentId);
            })
            ->when($filters['status'] ?? null, function (Builder $query, string $status): void {
                $query->where('status', $status);
            })
            ->when($filters['date_from'] ?? null, function (Builder $query, string $date): void {
                $query->whereDate('date', '>=', $date);
            })
            ->when($filters['date_to'] ?? null, function (Builder $query, string $date): void {
                $query->whereDate('date', '<=', $date);
            })
            ->latest('date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $students = Student::query()->orderBy('name')->get(['id', 'name', 'student_number']);

        return view('attendances.index', compact('attendances', 'students', 'filters'));
    }

    public function create(): View
    {
        $students = Student::query()->orderBy('name')->get(['id', 'name', 'student_number']);

        return view('attendances.create', compact('students'));
    }

    public function store(Request $request): RedirectResponse
    {
        $attendance = Attendance::create([
            ...$this->validatedAttendanceData($request),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('attendances.show', $attendance)
            ->with('success', 'Attendance recorded successfully.');
    }

    public function show(Attendance $attendance): View
    {
        $attendance->load(['student', 'recordedBy']);

        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance): View
    {
        $students = Student::query()->orderBy('name')->get(['id', 'name', 'student_number']);

        return view('attendances.edit', compact('attendance', 'students'));
    }

    public function update(Request $request, Attendance $attendance): RedirectResponse
    {
        $attendance->update($this->validatedAttendanceData($request, $attendance));

        return redirect()->route('attendances.show', $attendance)
            ->with('success', 'Attendance record updated successfully.');
    }

    public function destroy(Attendance $attendance): RedirectResponse
    {
        $attendance->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Attendance record deleted successfully.');
    }

    /**
     * @return array{student_id: int|string, date: string, status: string, notes: string|null}
     */
    private function validatedAttendanceData(Request $request, ?Attendance $attendance = null): array
    {
        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'date' => ['required', 'date'],
            'status' => ['required', Rule::in(['present', 'absent', 'late', 'excused'])],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $duplicateExists = Attendance::query()
            ->where('student_id', $validated['student_id'])
            ->whereDate('date', $validated['date'])
            ->when($attendance !== null, function (Builder $query) use ($attendance): void {
                $query->where('id', '<>', $attendance->getKey());
            })
            ->exists();

        if ($duplicateExists) {
            throw ValidationException::withMessages([
                'date' => 'This student already has an attendance record for the selected date.',
            ]);
        }

        return $validated;
    }
}
