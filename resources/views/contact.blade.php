@extends('layouts.app')

@section('title', 'Contact | CampusConnect')
@section('meta_description', 'Get in touch with CampusConnect for help finding your way into campus life.')

@section('hero')
    <section class="hero" aria-labelledby="contact-title">
        <div class="container py-5">
            <div class="row align-items-center py-4">
                <div class="col-lg-8">
                    <p class="eyebrow">Start somewhere</p>
                    <h1 id="contact-title">We can help you find a good place to begin.</h1>
                    <p class="hero-description">Have a question about campus life or finding the right support? Our team is happy to point you in the right direction.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="contact-section" aria-labelledby="contact-team-title">
        <div class="container contact-inner">
            <div>
                <p class="eyebrow eyebrow-light">Say hello</p>
                <h2 id="contact-team-title">Talk with the CampusConnect team.</h2>
                <p>Send us a note and tell us what you are looking for.</p>
            </div>
            <a class="button button-light" href="mailto:hello@campusconnect.edu">hello@campusconnect.edu <span aria-hidden="true">&rarr;</span></a>
        </div>
    </section>
@endsection