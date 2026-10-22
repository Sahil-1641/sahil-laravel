@extends('layouts.app')

@section('title', 'Edit '.$project->name.' | CampusConnect')
@section('meta_description', 'Update project details on CampusConnect.')

@section('content')
    <section class="services-section section-pad" aria-labelledby="edit-project-title">
        <div class="container">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">CampusConnect</p>
                    <h2 id="edit-project-title">Edit project</h2>
                </div>
                <p>Update the project name, location, or description.</p>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    @include('projects._form')
                </div>
            </div>
        </div>
    </section>
@endsection