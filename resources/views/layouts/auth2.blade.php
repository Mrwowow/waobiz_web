<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/svg+xml" sizes="any" href="{{asset('img/favicon.svg')}}" />
    <link rel="icon" type="image/png" sizes="any" href="{{asset('img/favicon.png')}}" />
    <link rel="icon" type="image/x-icon" sizes="any" href="{{asset('img/favicon.ico')}}" />

    <title>@yield('title') - {{ config('app.name', 'POS') }}</title>

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
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.5) 50%, rgba(0, 0, 0, 0.7) 100%);
            pointer-events: none;
        }

        .auth-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .auth-header {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .auth-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .auth-logo img {
            height: 44px;
            width: auto;
            object-fit: contain;
        }

        .auth-logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .auth-nav-link {
            color: #94a3b8;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .auth-nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }

        .auth-nav-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--black);
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
        }

        .auth-nav-btn:hover {
            color: var(--black);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(255, 149, 0, 0.4);
        }

        .auth-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 2rem;
        }

        .auth-footer {
            padding: 1.5rem 2rem;
            text-align: center;
        }

        .auth-footer-text {
            color: #64748b;
            font-size: 0.813rem;
        }

        /* Floating shapes animation */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 149, 0, 0.15) 0%, rgba(255, 179, 71, 0.08) 100%);
            animation: float 20s ease-in-out infinite;
            filter: blur(40px);
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

        /* Language dropdown styling */
        .lang-dropdown .dropdown-toggle {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
        }

        .lang-dropdown .dropdown-toggle:hover {
            background: rgba(255, 149, 0, 0.15);
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .auth-header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .auth-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .auth-logo-text {
                font-size: 1.25rem;
            }

            .auth-content {
                padding: 1rem;
            }
        }
    </style>

    <link href="{{ asset('css/tailwind/app.css') }}" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    @inject('request', 'Illuminate\Http\Request')

    @if (session('status') && session('status.success'))
        <input type="hidden" id="status_span" data-status="{{ session('status.success') }}" data-msg="{{ session('status.msg') }}">
    @endif

    <!-- Floating Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <div class="auth-container">
        <!-- Header -->
        <header class="auth-header">
            <div class="auth-logo">
                <img src="{{ asset('img/WaoBiz-Logo.svg') }}" alt="{{ config('app.name') }}" />
            </div>

            <nav class="auth-nav">
                <div class="lang-dropdown">
                    @include('layouts.partials.language_btn')
                </div>

                @if(Route::has('repair-status'))
                    <a class="auth-nav-link" href="{{ action([\Modules\Repair\Http\Controllers\CustomerRepairStatusController::class, 'index']) }}">
                        @lang('repair::lang.repair_status')
                    </a>
                @endif

                @if (!($request->segment(1) == 'business' && $request->segment(2) == 'register'))
                    @if (config('constants.allow_registration'))
                        @if (Route::has('pricing') && config('app.env') != 'demo' && $request->segment(1) != 'pricing')
                            <a class="auth-nav-link" href="{{ action([\Modules\Superadmin\Http\Controllers\PricingController::class, 'index']) }}">
                                @lang('superadmin::lang.pricing')
                            </a>
                        @endif
                        <a class="auth-nav-btn" href="{{ route('business.getRegister')}}@if(!empty(request()->lang)){{'?lang='.request()->lang}}@endif">
                            {{ __('business.register') }}
                        </a>
                    @endif
                @endif

                @if ($request->segment(1) != 'login')
                    <a class="auth-nav-link" href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'login'])}}@if(!empty(request()->lang)){{'?lang='.request()->lang}}@endif">
                        {{ __('business.sign_in') }}
                    </a>
                @endif
            </nav>
        </header>

        <!-- Main Content -->
        <main class="auth-content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="auth-footer">
            <p class="auth-footer-text">
                &copy; {{ date('Y') }} {{ config('app.name', 'WaoBiz') }}. All rights reserved.
            </p>
        </footer>
    </div>

    @include('layouts.partials.javascripts')
    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>
    @yield('javascript')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2_register').select2();
        });
    </script>
</body>

</html>
