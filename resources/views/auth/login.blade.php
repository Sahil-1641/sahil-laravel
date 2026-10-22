@extends('layouts.app')

@section('title', 'Sign in | CampusConnect')

@section('content')
    <section class="app-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="card app-card">
                        <div class="card-body p-4 p-md-5">
                            <p class="eyebrow">CampusConnect account</p>
                            <h1 class="h2 mb-2">Welcome back</h1>
                            <p class="text-secondary mb-4">Sign in to manage students and attendance records.</p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email address</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" autocomplete="current-password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1" @checked(old('remember'))>
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <button class="btn btn-primary w-100" type="submit">Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
