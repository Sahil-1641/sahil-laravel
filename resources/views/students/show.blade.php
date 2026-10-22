@extends('layouts.app')

@section('title', $student->name.' | CampusConnect')

@section('content')
    <section class="app-page">
        <div class="container">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Student profile</p>
                    <h1 class="h2 mb-1">{{ $student->name }}</h1>
                    <p class="text-secondary mb-0">{{ $student->student_number }} · {{ $student->class_name }}</p>
                </div>
                @auth
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-primary" href="{{ route('students.edit', $student) }}">Edit student</a>
                        <a class="btn btn-outline-primary" href="{{ route('attendances.create', ['student_id' => $student->id]) }}">Record attendance</a>
                        <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete this student and all their attendance records?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </div>
                @endauth
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card app-card h-100"><div class="card-body"><div class="text-secondary small">Email</div><div class="fw-semibold">{{ $student->email ?? 'Not provided' }}</div></div></div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card app-card h-100"><div class="card-body"><div class="text-secondary small">Phone</div><div class="fw-semibold">{{ $student->phone ?? 'Not provided' }}</div></div></div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card app-card h-100"><div class="card-body"><div class="text-secondary small">Date of birth</div><div class="fw-semibold">{{ $student->date_of_birth?->format('M j, Y') ?? 'Not provided' }}</div></div></div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card app-card h-100"><div class="card-body"><div class="text-secondary small">Attendance records</div><div class="fw-semibold">{{ $student->attendances_count }}</div></div></div>
                </div>
            </div>

            <div class="card app-card">
                <div class="card-header bg-white py-3"><h2 class="h5 mb-0">Recent attendance</h2></div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th scope="col">Date</th><th scope="col">Status</th><th scope="col">Notes</th><th scope="col"><span class="visually-hidden">Actions</span></th></tr></thead>
                        <tbody>
                            @forelse ($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->date->format('M j, Y') }}</td>
                                    <td><span class="status-badge status-{{ $attendance->status }}">{{ ucfirst($attendance->status) }}</span></td>
                                    <td>{{ $attendance->notes ?? '—' }}</td>
                                    <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('attendances.show', $attendance) }}">View</a></td>
                                </tr>
                            @empty
                                <tr><td class="py-4 text-center text-secondary" colspan="4">No attendance records yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white"><a href="{{ route('attendances.index', ['student_id' => $student->id]) }}">View all attendance records</a></div>
            </div>
        </div>
    </section>
@endsection
