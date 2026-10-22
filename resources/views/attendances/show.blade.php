@extends('layouts.app')

@section('title', 'Attendance record | CampusConnect')

@section('content')
    <section class="app-page">
        <div class="container">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Attendance record</p>
                    <h1 class="h2 mb-1">{{ $attendance->student->name }}</h1>
                    <p class="text-secondary mb-0">{{ $attendance->student->student_number }} · {{ $attendance->date->format('M j, Y') }}</p>
                </div>
                @auth
                    <div class="d-flex gap-2">
                        <a class="btn btn-primary" href="{{ route('attendances.edit', $attendance) }}">Edit record</a>
                        <form method="POST" action="{{ route('attendances.destroy', $attendance) }}" onsubmit="return confirm('Delete this attendance record?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </div>
                @endauth
            </div>

            <div class="card app-card">
                <div class="card-body p-4">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Student</dt>
                        <dd class="col-sm-9"><a href="{{ route('students.show', $attendance->student) }}">{{ $attendance->student->name }} ({{ $attendance->student->student_number }})</a></dd>
                        <dt class="col-sm-3">Class / grade</dt>
                        <dd class="col-sm-9">{{ $attendance->student->class_name }}</dd>
                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9"><span class="status-badge status-{{ $attendance->status }}">{{ ucfirst($attendance->status) }}</span></dd>
                        <dt class="col-sm-3">Recorded by</dt>
                        <dd class="col-sm-9">{{ $attendance->recordedBy?->name ?? '—' }}</dd>
                        <dt class="col-sm-3">Notes</dt>
                        <dd class="col-sm-9">{{ $attendance->notes ?? 'No notes' }}</dd>
                    </dl>
                </div>
                <div class="card-footer bg-white"><a href="{{ route('attendances.index') }}">Back to attendance</a></div>
            </div>
        </div>
    </section>
@endsection
