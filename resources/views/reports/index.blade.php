@extends('layouts.app')

@section('title', 'Attendance report | CampusConnect')

@section('content')
    <section class="app-page">
        <div class="container">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Insights</p>
                    <h1 class="h2 mb-1">Attendance report</h1>
                    <p class="text-secondary mb-0">Review attendance totals and student-level records for a selected date range.</p>
                </div>
            </div>

            <form class="card app-card mb-4" method="GET" action="{{ route('reports.index') }}">
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="date_from">From</label>
                            <input class="form-control" id="date_from" name="date_from" type="date" value="{{ $filters['date_from'] ?? '' }}">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="date_to">To</label>
                            <input class="form-control" id="date_to" name="date_to" type="date" value="{{ $filters['date_to'] ?? '' }}">
                        </div>
                        <div class="col-12 col-md-4 d-flex gap-2">
                            <button class="btn btn-primary flex-grow-1" type="submit">Apply dates</button>
                            <a class="btn btn-outline-secondary" href="{{ route('reports.index') }}">Clear</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-4"><div class="card app-card h-100"><div class="card-body"><div class="text-secondary small">Total records</div><div class="metric-value">{{ $totalRecords }}</div></div></div></div>
                <div class="col-6 col-lg-4"><div class="card app-card h-100"><div class="card-body"><div class="text-secondary small">Present</div><div class="metric-value text-success">{{ $statusCounts['present'] ?? 0 }}</div></div></div></div>
                <div class="col-6 col-lg-4"><div class="card app-card h-100"><div class="card-body"><div class="text-secondary small">Absent</div><div class="metric-value text-danger">{{ $statusCounts['absent'] ?? 0 }}</div></div></div></div>
                <div class="col-6 col-lg-4"><div class="card app-card h-100"><div class="card-body"><div class="text-secondary small">Late</div><div class="metric-value text-warning">{{ $statusCounts['late'] ?? 0 }}</div></div></div></div>
                <div class="col-6 col-lg-4"><div class="card app-card h-100"><div class="card-body"><div class="text-secondary small">Excused</div><div class="metric-value">{{ $statusCounts['excused'] ?? 0 }}</div></div></div></div>
                <div class="col-6 col-lg-4"><div class="card app-card h-100"><div class="card-body"><div class="text-secondary small">Present rate</div><div class="metric-value">{{ number_format($attendanceRate, 1) }}%</div></div></div></div>
            </div>

            <div class="card app-card">
                <div class="card-header bg-white py-3"><h2 class="h5 mb-0">By student</h2></div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th scope="col">Student</th><th scope="col">Class</th><th scope="col">Records</th><th scope="col">Present</th><th scope="col">Absent</th><th scope="col">Late</th><th scope="col">Excused</th><th scope="col">Present rate</th></tr></thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td><a class="fw-semibold" href="{{ route('students.show', $student) }}">{{ $student->name }}</a><div class="small text-secondary">{{ $student->student_number }}</div></td>
                                    <td>{{ $student->class_name }}</td>
                                    <td>{{ $student->total_count }}</td>
                                    <td>{{ $student->present_count }}</td>
                                    <td>{{ $student->absent_count }}</td>
                                    <td>{{ $student->late_count }}</td>
                                    <td>{{ $student->excused_count }}</td>
                                    <td>{{ $student->total_count === 0 ? '—' : number_format(($student->present_count / $student->total_count) * 100, 1).'%' }}</td>
                                </tr>
                            @empty
                                <tr><td class="py-4 text-center text-secondary" colspan="8">No student records are available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">{{ $students->links() }}</div>
        </div>
    </section>
@endsection
