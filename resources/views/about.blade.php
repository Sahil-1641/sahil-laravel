@extends('layouts.app')

@section('title', 'About | CampusConnect')
@section('meta_description', 'Learn how CampusConnect helps students find their people, opportunities, and support on campus.')

@section('hero')
    <section class="hero" aria-labelledby="about-title">
        <div class="container py-5">
            <div class="row align-items-center py-4">
                <div class="col-lg-8">
                    <p class="eyebrow">More than a directory</p>
                    <h1 id="about-title">A big campus can still feel like <span>your place.</span></h1>
                    <p class="hero-description">CampusConnect makes it easier to find the people, places, and possibilities that turn a campus into a community.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="section-pad" aria-labelledby="about-community-title">
        <div class="container">
            <div class="row align-items-end g-4">
                <div class="col-lg-6">
                    <p class="eyebrow">Our purpose</p>
                    <h2 id="about-community-title">Make connection part of campus life.</h2>
                </div>
                <div class="col-lg-6 about-copy">
                    <p>Starting somewhere new can feel like a lot. We bring student groups, campus events, and practical support into clearer view, so you can spend less time searching and more time taking part.</p>
                    <a class="text-link text-link-blue" href="{{ route('services') }}">Explore campus services <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
        </div>
    </section>
@endsection