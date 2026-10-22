@extends('layouts.app')

@section('title', 'CampusConnect | Find your place on campus')
@section('meta_description', 'Meet your campus community, discover student opportunities, and find the support that helps you thrive.')

@section('hero')
    <section class="hero" aria-labelledby="hero-title">
        <div class="container hero-grid">
            <div class="hero-copy">
                <p class="eyebrow"><span class="eyebrow-dot"></span> A better way to find your place</p>
                <h1 id="hero-title">Campus life,<br><span>closer than ever.</span></h1>
                <p class="hero-description">Meet your next study partner, discover a community that feels like yours, and make the most of every day on campus.</p>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ url('/#services') }}">Explore campus life <span aria-hidden="true">&rarr;</span></a>
                    <a class="text-link" href="{{ url('/#about') }}">How it works</a>
                </div>
                <p class="hero-note"><span class="note-mark" aria-hidden="true">+</span> Your people, places, and possibilities in one place.</p>
            </div>
            <figure class="hero-visual">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1400&q=85" alt="University students spending time together on campus" fetchpriority="high">
                <figcaption class="photo-caption"><span class="caption-mark" aria-hidden="true">CC</span><span><strong>Find your people</strong><small>Good things happen together.</small></span></figcaption>
                <span class="visual-index" aria-hidden="true">01 / 04</span>
            </figure>
        </div>
    </section>
@endsection

@section('content')
    <section class="about-section section-pad" id="about" aria-labelledby="about-title">
        <div class="container about-grid">
            <div class="section-intro">
                <p class="eyebrow">More than a directory</p>
                <h2 id="about-title">A big campus can still feel like <span>your place.</span></h2>
            </div>
            <div class="about-copy">
                <p>CampusConnect brings the people and opportunities around you into clearer view. Spend less time searching across group chats and noticeboards, and more time finding the things that make student life yours.</p>
                <a class="text-link text-link-blue" href="{{ url('/#services') }}">See what you can do <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
    </section>

    <section class="services-section section-pad" id="services" aria-labelledby="services-title">
        <div class="container">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Make more of campus</p>
                    <h2 id="services-title">Find what you came here for.</h2>
                </div>
                <p>From your first week to your final term, find the people and support that help campus feel a little more familiar.</p>
            </div>

            <div class="service-grid">
                <article class="service-card service-card-blue">
                    <span class="card-number">01</span>
                    <h3>Find your people</h3>
                    <p>Meet classmates, join student groups, and find a study circle that makes a long week feel lighter.</p>
                    <a href="{{ url('/#contact') }}" aria-label="Find out how to meet your people">Meet your community <span aria-hidden="true">&rarr;</span></a>
                </article>
                <article class="service-card service-card-green">
                    <span class="card-number">02</span>
                    <h3>Make plans that matter</h3>
                    <p>Keep up with talks, workshops, volunteering, and the small campus events you would hate to miss.</p>
                    <a href="{{ url('/#contact') }}" aria-label="Find out about campus events">Explore opportunities <span aria-hidden="true">&rarr;</span></a>
                </article>
                <article class="service-card service-card-gold">
                    <span class="card-number">03</span>
                    <h3>Get the right support</h3>
                    <p>Find a clear starting point for academic guidance, wellbeing services, and practical student help.</p>
                    <a href="{{ url('/#contact') }}" aria-label="Find the right campus support">Find campus support <span aria-hidden="true">&rarr;</span></a>
                </article>
            </div>
        </div>
    </section>

    <section class="contact-section" id="contact" aria-labelledby="contact-title">
        <div class="container contact-inner">
            <div>
                <p class="eyebrow eyebrow-light">Start somewhere</p>
                <h2 id="contact-title">Your next campus connection could start today.</h2>
                <p>Tell us what you are looking for. We will help you find a good place to begin.</p>
            </div>
            <a class="button button-light" href="mailto:hello@campusconnect.edu">Talk with our team <span aria-hidden="true">&rarr;</span></a>
        </div>
    </section>
@endsection