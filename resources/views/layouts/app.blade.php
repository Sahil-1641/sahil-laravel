<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Meet your campus community, discover new opportunities, and find the support that helps you thrive.')">
    <title>@yield('title', 'CampusConnect | Your campus, connected')</title>
    @fonts
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to content</a>

    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="{{ route('home') }}" aria-label="CampusConnect home">
                <span class="brand-mark" aria-hidden="true"><span></span><span></span><span></span><span></span></span>
                <span>Campus<span class="brand-accent">Connect</span></span>
            </a>

            <nav class="site-nav" aria-label="Main navigation">
                <details class="nav-menu" data-mobile-menu open>
                    <summary class="nav-toggle" aria-label="Toggle navigation">
                        <span class="menu-icon" aria-hidden="true"><span></span><span></span><span></span></span>
                    </summary>
                    <div class="nav-panel">
                        <div class="nav-links">
                            <a href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Home</a>
                            <a href="{{ route('students.index') }}" @if (request()->routeIs('students.*')) aria-current="page" @endif>Students</a>
                            <a href="{{ route('attendances.index') }}" @if (request()->routeIs('attendances.*')) aria-current="page" @endif>Attendance</a>
                            <a href="{{ route('reports.index') }}" @if (request()->routeIs('reports.*')) aria-current="page" @endif>Reports</a>
                            <a href="{{ route('projects.index') }}" @if (request()->routeIs('projects.*')) aria-current="page" @endif>Projects</a>
                            @guest
                                <a class="nav-cta" href="{{ route('login') }}">Sign in <span aria-hidden="true">&rarr;</span></a>
                            @else
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="nav-cta nav-submit-button" type="submit">Sign out</button>
                                </form>
                            @endguest
                        </div>
                    </div>
                </details>
            </nav>
        </div>
    </header>

    <main id="main-content">
        @if (session('success'))
            <div class="container pt-3">
                <div class="alert alert-success" role="status">{{ session('success') }}</div>
            </div>
        @endif
        @if ($errors->any())
            <div class="container pt-3">
                <div class="alert alert-danger" role="alert">
                    <p class="mb-1">Please correct the following errors:</p>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @yield('hero')
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-main">
            <div class="footer-brand-block">
                <a class="brand brand-footer" href="{{ url('/') }}">
                    <span class="brand-mark" aria-hidden="true"><span></span><span></span><span></span><span></span></span>
                    <span>Campus<span class="brand-accent">Connect</span></span>
                </a>
                <p>Making campus feel more connected, one conversation at a time.</p>
            </div>
            <div class="footer-links-block">
                <span class="footer-label">Explore</span>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('services') }}">Services</a>
                <a href="{{ route('projects.index') }}">Projects</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
            <div class="footer-links-block">
                <span class="footer-label">Say hello</span>
                <a href="mailto:hello@campusconnect.edu">hello@campusconnect.edu</a>
                <p>Here for the questions, big or small.</p>
            </div>
        </div>
        <div class="container footer-bottom">
            <span>&copy; {{ now()->year }} CampusConnect</span>
            <span>Made for campus life.</span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>