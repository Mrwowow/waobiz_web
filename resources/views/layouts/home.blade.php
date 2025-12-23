<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/svg+xml" sizes="any" href="{{asset('img/favicon.svg')}}" />
    <link rel="icon" type="image/png" sizes="any" href="{{asset('img/favicon.png')}}" />
    <link rel="icon" type="image/x-icon" sizes="any" href="{{asset('img/favicon.ico')}}" />

    <title>@yield('title') - {{ config('app.name', 'WaoBiz') }}</title>

    @include('layouts.partials.css')

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #FF9500;
            --primary-dark: #E68600;
            --primary-light: #FFB347;
            --black: #000000;
            --dark: #0a0a0a;
            --dark-secondary: #141414;
            --dark-tertiary: #1f1f1f;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: url("{{asset('img/waocard-mpt-1.jpg')}}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.6) 50%, rgba(0, 0, 0, 0.8) 100%);
            pointer-events: none;
            z-index: 0;
        }

        .home-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        .home-header {
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .home-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .home-logo img {
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        .home-logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Navigation */
        .home-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .home-nav-link {
            color: #e2e8f0;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            padding: 0.625rem 1rem;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .home-nav-link:hover {
            color: var(--primary);
            background: rgba(255, 149, 0, 0.1);
        }

        .home-nav-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--black);
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
            margin-left: 0.5rem;
        }

        .home-nav-btn:hover {
            color: var(--black);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(255, 149, 0, 0.4);
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .mobile-menu-btn:hover {
            background: rgba(255, 149, 0, 0.2);
            border-color: var(--primary);
        }

        .mobile-menu-btn svg {
            width: 24px;
            height: 24px;
        }

        /* Main Content */
        .home-main {
            flex: 1;
            padding: 2rem;
        }

        .home-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Footer */
        .home-footer {
            padding: 1.5rem 2rem;
            text-align: center;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .home-footer-text {
            color: #64748b;
            font-size: 0.813rem;
            margin: 0;
        }

        /* Floating shapes */
        .floating-shape {
            position: fixed;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 149, 0, 0.15) 0%, rgba(255, 179, 71, 0.08) 100%);
            animation: float 20s ease-in-out infinite;
            filter: blur(40px);
            pointer-events: none;
            z-index: 0;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: 10%;
            left: -5%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: 20%;
            right: -3%;
            animation-delay: -5s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            top: 60%;
            left: 10%;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Mobile Navigation */
        .mobile-nav {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            z-index: 200;
            flex-direction: column;
            padding: 2rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-nav.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .mobile-nav-close {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
        }

        .mobile-nav-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-nav-link {
            color: #e2e8f0;
            font-size: 1.125rem;
            font-weight: 500;
            text-decoration: none;
            padding: 1rem;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .mobile-nav-link:hover {
            color: var(--primary);
            background: rgba(255, 149, 0, 0.1);
        }

        .mobile-nav-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--black);
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            margin-top: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .home-header {
                padding: 1rem;
            }

            .home-nav {
                display: none;
            }

            .mobile-menu-btn {
                display: flex;
            }

            .mobile-nav {
                display: flex;
            }

            .home-main {
                padding: 1rem;
            }

            .home-logo img {
                height: 32px;
            }

            .home-logo-text {
                font-size: 1.25rem;
            }
        }

        /* Card Styles for Content */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 149, 0, 0.2);
            transform: translateY(-4px);
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--black);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 149, 0, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            color: var(--primary);
            background: rgba(255, 149, 0, 0.1);
            border-color: rgba(255, 149, 0, 0.3);
        }

        /* Text Colors */
        .text-primary {
            color: var(--primary) !important;
        }

        .text-white {
            color: #ffffff !important;
        }

        .text-gray {
            color: #94a3b8 !important;
        }
    </style>

    <link href="{{ asset('css/tailwind/app.css') }}" rel="stylesheet">
</head>

<body>
    @inject('request', 'Illuminate\Http\Request')

    <!-- Floating Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <div class="home-container">
        <!-- Header -->
        <header class="home-header">
            <a href="/" class="home-logo">
                <img src="{{ asset('img/WaoBiz-Logo.svg') }}" alt="{{ config('app.name') }}" />
            </a>

            <nav class="home-nav">
                @if(Auth::check())
                    <a class="home-nav-link" href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}">
                        @lang('home.home')
                    </a>
                @endif

                @if(Route::has('frontend-pages') && config('app.env') != 'demo' && !empty($frontend_pages))
                    @foreach($frontend_pages as $page)
                        <a class="home-nav-link" href="{{ action([\Modules\Superadmin\Http\Controllers\PageController::class, 'showPage'], $page->slug) }}">
                            {{ $page->title }}
                        </a>
                    @endforeach
                @endif

                @if(Route::has('pricing') && config('app.env') != 'demo')
                    <a class="home-nav-link" href="{{ action([\Modules\Superadmin\Http\Controllers\PricingController::class, 'index']) }}">
                        @lang('superadmin::lang.pricing')
                    </a>
                @endif

                @if(Route::has('repair-status'))
                    <a class="home-nav-link" href="{{ action([\Modules\Repair\Http\Controllers\CustomerRepairStatusController::class, 'index']) }}">
                        @lang('repair::lang.repair_status')
                    </a>
                @endif

                @if (Route::has('login'))
                    @if(!Auth::check())
                        <a class="home-nav-link" href="{{ route('login') }}">@lang('lang_v1.login')</a>
                        @if(config('constants.allow_registration'))
                            <a class="home-nav-btn" href="{{ route('business.getRegister') }}">@lang('lang_v1.register')</a>
                        @endif
                    @endif
                @endif
            </nav>

            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </header>

        <!-- Mobile Navigation -->
        <div class="mobile-nav" id="mobileNav">
            <div class="mobile-nav-header">
                <a href="/" class="home-logo">
                    <img src="{{ asset('img/WaoBiz-Logo.svg') }}" alt="{{ config('app.name') }}" />
                </a>
                <button class="mobile-nav-close" onclick="toggleMobileMenu()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mobile-nav-links">
                @if(Auth::check())
                    <a class="mobile-nav-link" href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}">
                        @lang('home.home')
                    </a>
                @endif

                @if(Route::has('frontend-pages') && config('app.env') != 'demo' && !empty($frontend_pages))
                    @foreach($frontend_pages as $page)
                        <a class="mobile-nav-link" href="{{ action([\Modules\Superadmin\Http\Controllers\PageController::class, 'showPage'], $page->slug) }}">
                            {{ $page->title }}
                        </a>
                    @endforeach
                @endif

                @if(Route::has('pricing') && config('app.env') != 'demo')
                    <a class="mobile-nav-link" href="{{ action([\Modules\Superadmin\Http\Controllers\PricingController::class, 'index']) }}">
                        @lang('superadmin::lang.pricing')
                    </a>
                @endif

                @if(Route::has('repair-status'))
                    <a class="mobile-nav-link" href="{{ action([\Modules\Repair\Http\Controllers\CustomerRepairStatusController::class, 'index']) }}">
                        @lang('repair::lang.repair_status')
                    </a>
                @endif

                @if (Route::has('login'))
                    @if(!Auth::check())
                        <a class="mobile-nav-link" href="{{ route('login') }}">@lang('lang_v1.login')</a>
                        @if(config('constants.allow_registration'))
                            <a class="mobile-nav-btn" href="{{ route('business.getRegister') }}">@lang('lang_v1.register')</a>
                        @endif
                    @endif
                @endif
            </div>
        </div>

        <!-- Main Content -->
        <main class="home-main">
            <div class="home-content">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="home-footer">
            <p class="home-footer-text">
                &copy; {{ date('Y') }} {{ config('app.name', 'WaoBiz') }}. All rights reserved.
            </p>
        </footer>
    </div>

    @include('layouts.partials.javascripts')
    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>

    <script>
        function toggleMobileMenu() {
            const mobileNav = document.getElementById('mobileNav');
            mobileNav.classList.toggle('active');
            document.body.style.overflow = mobileNav.classList.contains('active') ? 'hidden' : '';
        }
    </script>

    @yield('javascript')
</body>

</html>
