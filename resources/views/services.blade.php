@extends('layouts.app')
@section('title', 'Services | CampusConnect')
@section('meta_description', 'Discover the campus communities, events, and student support available through CampusConnect.')

@section('hero')
    <section class="hero" aria-labelledby="services-title">
        <div class="container py-5">
            <div class="row align-items-center py-4">
                <div class="col-lg-8">
                    <p class="eyebrow">Make more of campus</p>
                    <h1 id="services-title">Find what you came here for.</h1>
                    <p class="hero-description">Find a community, make plans, and get connected with support, all in one place.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="services-section section-pad" aria-label="CampusConnect services">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <article class="service-card service-card-blue h-100">
                        <span class="card-number">01</span>
                        <h2>Find your people</h2>
                        <p>Meet classmates, join student groups, and find a study circle that makes a long week feel lighter.</p>
                        <a href="{{ route('contact') }}">Meet your community <span aria-hidden="true">&rarr;</span></a>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="service-card service-card-green h-100">
                        <span class="card-number">02</span>
                        <h2>Make plans that matter</h2>
                        <p>Keep up with talks, workshops, volunteering, and campus events you would hate to miss.</p>
                        <a href="{{ route('contact') }}">Explore opportunities <span aria-hidden="true">&rarr;</span></a>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="service-card service-card-gold h-100">
                        <span class="card-number">03</span>
                        <h2>Get the right support</h2>
                        <p>Find a clear starting point for academic guidance, wellbeing services, and practical student help.</p>
                        <a href="{{ route('contact') }}">Find campus support <span aria-hidden="true">&rarr;</span></a>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection