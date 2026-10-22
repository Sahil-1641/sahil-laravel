@extends('layouts.app')

@section('title', 'Projects | CampusConnect')
@section('meta_description', 'Browse projects and their locations on CampusConnect.')

@section('content')
    <section class="services-section section-pad" aria-labelledby="projects-title">
        <div class="container">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">CampusConnect</p>
                    <h2 id="projects-title">Projects</h2>
                </div>
                @auth
                    <a class="button button-primary" href="{{ route('projects.create') }}">Create a project <span aria-hidden="true">&rarr;</span></a>
                @endauth
            </div>

            <div class="row g-4">
                @if ($projects->isEmpty())
                    <div class="col-12">
                        <p class="mb-0">No projects are available yet.</p>
                    </div>
                @else
                    @foreach ($projects as $project)
                        <div class="col-md-6 col-lg-4">
                            <article class="service-card service-card-blue h-100">
                                <h3>{{ $project->name }}</h3>
                                <p><strong>Location:</strong> {{ $project->location }}</p>
                                <p>{{ $project->description }}</p>
                                <a href="{{ route('projects.show', $project) }}">View project <span aria-hidden="true">&rarr;</span></a>
                            </article>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection