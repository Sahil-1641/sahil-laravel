@extends('layouts.app')

@section('title', 'Add student | CampusConnect')

@section('content')
    <section class="app-page">
        <div class="container">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Student directory</p>
                    <h1 class="h2 mb-1">Add a student</h1>
                    <p class="text-secondary mb-0">Enter the student's details below.</p>
                </div>
            </div>
            @include('students._form', ['student' => null])
        </div>
    </section>
@endsection
