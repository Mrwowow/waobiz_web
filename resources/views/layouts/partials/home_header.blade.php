<!-- Modern Sticky Header -->
<nav class="home-navbar">
    <div class="home-navbar-container">
        <a href="/" class="home-navbar-logo">
            <img src="{{ asset('img/WaoBiz-Logo.svg') }}" alt="{{ config('app.name', 'WaoBiz') }}" />
        </a>

        <div class="home-navbar-menu" id="navbarMenu">
            <ul class="home-navbar-links">
                @if(Auth::check())
                    <li>
                        <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}">
                            @lang('home.home')
                        </a>
                    </li>
                @endif

                @if(Route::has('frontend-pages') && config('app.env') != 'demo' && !empty($frontend_pages))
                    @foreach($frontend_pages as $page)
                        <li>
                            <a href="{{ action([\Modules\Superadmin\Http\Controllers\PageController::class, 'showPage'], $page->slug) }}">
                                {{ $page->title }}
                            </a>
                        </li>
                    @endforeach
                @endif

                @if(Route::has('pricing') && config('app.env') != 'demo')
                    <li>
                        <a href="{{ action([\Modules\Superadmin\Http\Controllers\PricingController::class, 'index']) }}">
                            @lang('superadmin::lang.pricing')
                        </a>
                    </li>
                @endif

                @if(Route::has('repair-status'))
                    <li>
                        <a href="{{ action([\Modules\Repair\Http\Controllers\CustomerRepairStatusController::class, 'index']) }}">
                            @lang('repair::lang.repair_status')
                        </a>
                    </li>
                @endif
            </ul>

            <div class="home-navbar-actions">
                @if (Route::has('login'))
                    @if(!Auth::check())
                        <a href="{{ route('login') }}" class="home-navbar-link">
                            @lang('lang_v1.login')
                        </a>
                        @if(config('constants.allow_registration'))
                            <a href="{{ route('business.getRegister') }}" class="home-navbar-btn">
                                @lang('lang_v1.register')
                            </a>
                        @endif
                    @endif
                @endif
            </div>
        </div>

        <button class="home-navbar-toggle" onclick="toggleNavbarMenu()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</nav>

<style>
    .home-navbar {
        position: sticky;
        top: 0;
        z-index: 100;
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1rem 2rem;
    }

    .home-navbar-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .home-navbar-logo {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .home-navbar-logo img {
        height: 40px;
        width: auto;
        object-fit: contain;
    }

    .home-navbar-menu {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .home-navbar-links {
        display: flex;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 0.25rem;
    }

    .home-navbar-links li a {
        color: #e2e8f0;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        padding: 0.625rem 1rem;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .home-navbar-links li a:hover {
        color: #FF9500;
        background: rgba(255, 149, 0, 0.1);
    }

    .home-navbar-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .home-navbar-link {
        color: #e2e8f0;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        padding: 0.625rem 1rem;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .home-navbar-link:hover {
        color: #FF9500;
        background: rgba(255, 149, 0, 0.1);
    }

    .home-navbar-btn {
        background: linear-gradient(135deg, #FF9500 0%, #E68600 100%);
        color: #000000;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
    }

    .home-navbar-btn:hover {
        color: #000000;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 149, 0, 0.4);
    }

    .home-navbar-toggle {
        display: none;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        padding: 0.5rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .home-navbar-toggle:hover {
        background: rgba(255, 149, 0, 0.2);
        border-color: #FF9500;
    }

    @media (max-width: 768px) {
        .home-navbar {
            padding: 1rem;
        }

        .home-navbar-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
            z-index: 200;
        }

        .home-navbar-menu.active {
            display: flex;
        }

        .home-navbar-links {
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
        }

        .home-navbar-links li {
            width: 100%;
        }

        .home-navbar-links li a {
            display: block;
            text-align: center;
            padding: 1rem;
            font-size: 1.125rem;
        }

        .home-navbar-actions {
            flex-direction: column;
            width: 100%;
            margin-top: 1rem;
        }

        .home-navbar-link,
        .home-navbar-btn {
            display: block;
            text-align: center;
            width: 100%;
            padding: 1rem;
        }

        .home-navbar-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .home-navbar-logo img {
            height: 32px;
        }
    }
</style>

<script>
    function toggleNavbarMenu() {
        const menu = document.getElementById('navbarMenu');
        menu.classList.toggle('active');
        document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
    }
</script>
