@extends('layouts.app')

@section('title', 'Edit attendance | CampusConnect')

@section('content')
    <section class="app-page">
        <div class="container">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Daily register</p>
                    <h1 class="h2 mb-1">Edit attendance record</h1>
                    <p class="text-secondary mb-0">{{ $attendance->student->name }} · {{ $attendance->date->format('M j, Y') }}</p>
                </div>
            </div>
            @include('attendances._form')
        </div>
    </section>
@endsection
