@extends('layouts.app')

@section('title', 'Record attendance | CampusConnect')

@section('content')
    <section class="app-page">
        <div class="container">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Daily register</p>
                    <h1 class="h2 mb-1">Record attendance</h1>
                    <p class="text-secondary mb-0">A student can have one attendance record per day.</p>
                </div>
            </div>
            @include('attendances._form', ['attendance' => null])
        </div>
    </section>
@endsection
