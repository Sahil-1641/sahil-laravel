@extends('layouts.app')

@section('title', 'Attendance | CampusConnect')

@section('content')
    <section class="app-page">
        <div class="container">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Daily register</p>
                    <h1 class="h2 mb-1">Attendance</h1>
                    <p class="text-secondary mb-0">Review attendance records and filter by student, status, or date.</p>
                </div>
                @auth
                    <a class="btn btn-primary" href="{{ route('attendances.create') }}">Record attendance</a>
                @endauth
            </div>

            <form class="card app-card mb-4" method="GET" action="{{ route('attendances.index') }}">
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="search">Student search</label>
                            <input class="form-control" id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Name or student number">
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="student_id">Student</label>
                            <select class="form-select" id="student_id" name="student_id">
                                <option value="">All students</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}" @selected((string) ($filters['student_id'] ?? '') === (string) $student->id)>{{ $student->name }} ({{ $student->student_number }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All statuses</option>
                                @foreach (['present', 'absent', 'late', 'excused'] as $status)
                                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label" for="date_from">From</label>
                            <input class="form-control" id="date_from" name="date_from" type="date" value="{{ $filters['date_from'] ?? '' }}">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label" for="date_to">To</label>
                            <input class="form-control" id="date_to" name="date_to" type="date" value="{{ $filters['date_to'] ?? '' }}">
                        </div>
                        <div class="col-12 col-md-3 d-flex gap-2">
                            <button class="btn btn-primary flex-grow-1" type="submit">Filter</button>
                            <a class="btn btn-outline-secondary" href="{{ route('attendances.index') }}">Clear</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card app-card">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th scope="col">Date</th><th scope="col">Student</th><th scope="col">Class</th><th scope="col">Status</th><th scope="col">Recorded by</th><th scope="col"><span class="visually-hidden">Actions</span></th></tr></thead>
                        <tbody>
                            @forelse ($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->date->format('M j, Y') }}</td>
                                    <td><a class="fw-semibold" href="{{ route('students.show', $attendance->student) }}">{{ $attendance->student->name }}</a><div class="small text-secondary">{{ $attendance->student->student_number }}</div></td>
                                    <td>{{ $attendance->student->class_name }}</td>
                                    <td><span class="status-badge status-{{ $attendance->status }}">{{ ucfirst($attendance->status) }}</span></td>
                                    <td>{{ $attendance->recordedBy?->name ?? '—' }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('attendances.show', $attendance) }}">View</a>
                                        @auth
                                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('attendances.edit', $attendance) }}">Edit</a>
                                        @endauth
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="py-5 text-center text-secondary" colspan="6">No attendance records match your filters.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">{{ $attendances->links() }}</div>
        </div>
    </section>
@endsection
