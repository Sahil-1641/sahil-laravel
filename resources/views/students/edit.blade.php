@extends('layouts.app')

@section('title', 'Edit student | CampusConnect')

@section('content')
    <section class="app-page">
        <div class="container">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Student directory</p>
                    <h1 class="h2 mb-1">Edit {{ $student->name }}</h1>
                    <p class="text-secondary mb-0">Update student details.</p>
                </div>
            </div>
            @include('students._form')
        </div>
    </section>
@endsection
