@extends('layouts.app')

@section('title', $project->name.' | CampusConnect Projects')
@section('meta_description', 'Project details for '.$project->name.' on CampusConnect.')

@section('content')
    <section class="services-section section-pad" aria-labelledby="project-title">
        <div class="container">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">CampusConnect / Projects</p>
                    <h2 id="project-title">{{ $project->name }}</h2>
                </div>
                <p><strong>Location:</strong> {{ $project->location }}</p>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <article class="service-card h-100">
                        <h3>About this project</h3>
                        <p>{{ $project->description }}</p>
                        <div class="d-flex flex-wrap align-items-center gap-3 mt-auto">
                            @auth
                                <a class="button button-primary" href="{{ route('projects.edit', $project) }}">Edit project</a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger" type="submit">Delete project</button>
                                </form>
                            @endauth
                            <a class="text-link" href="{{ route('projects.index') }}">Back to projects</a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection