@extends('layouts.app')

@section('title', 'Students | CampusConnect')

@section('content')
    <section class="app-page">
        <div class="container">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Student directory</p>
                    <h1 class="h2 mb-1">Students</h1>
                    <p class="text-secondary mb-0">Search and manage your student records.</p>
                </div>
                @auth
                    <a class="btn btn-primary" href="{{ route('students.create') }}">Add student</a>
                @endauth
            </div>

            <form class="card app-card mb-4" method="GET" action="{{ route('students.index') }}">
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="search">Search</label>
                            <input class="form-control" id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Name, student number, or email">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="class_name">Class / grade</label>
                            <select class="form-select" id="class_name" name="class_name">
                                <option value="">All classes</option>
                                @foreach ($classes as $className)
                                    <option value="{{ $className }}" @selected(($filters['class_name'] ?? '') === $className)>{{ $className }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-2 d-flex gap-2">
                            <button class="btn btn-primary flex-grow-1" type="submit">Filter</button>
                            <a class="btn btn-outline-secondary" href="{{ route('students.index') }}">Clear</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card app-card">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Student</th>
                                <th scope="col">Student number</th>
                                <th scope="col">Class / grade</th>
                                <th scope="col">Email</th>
                                <th scope="col"><span class="visually-hidden">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td><a class="fw-semibold" href="{{ route('students.show', $student) }}">{{ $student->name }}</a></td>
                                    <td>{{ $student->student_number }}</td>
                                    <td>{{ $student->class_name }}</td>
                                    <td>{{ $student->email ?? '—' }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('students.show', $student) }}">View</a>
                                        @auth
                                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('students.edit', $student) }}">Edit</a>
                                        @endauth
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-5 text-center text-secondary" colspan="5">No students match your search.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">{{ $students->links() }}</div>
        </div>
    </section>
@endsection
