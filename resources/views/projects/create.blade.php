@extends('layouts.app')

@section('title', 'Create Project | CampusConnect')
@section('meta_description', 'Add a project to CampusConnect.')

@section('content')
    <section class="services-section section-pad" aria-labelledby="create-project-title">
        <div class="container">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">CampusConnect</p>
                    <h2 id="create-project-title">Create a project</h2>
                </div>
                <p>Add a project and its location to the directory.</p>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    @include('projects._form')
                </div>
            </div>
        </div>
    </section>
@endsection