@extends('layouts.auth2')
@section('title', __('lang_v1.login'))
@inject('request', 'Illuminate\Http\Request')
@section('content')
    @php
        $username = old('username');
        $password = null;
        if (config('app.env') == 'demo') {
            $username = 'admin';
            $password = '123456';

            $demo_types = [
                'all_in_one' => 'admin',
                'super_market' => 'admin',
                'pharmacy' => 'admin-pharmacy',
                'electronics' => 'admin-electronics',
                'services' => 'admin-services',
                'restaurant' => 'admin-restaurant',
                'superadmin' => 'superadmin',
                'woocommerce' => 'woocommerce_user',
                'essentials' => 'admin-essentials',
                'manufacturing' => 'manufacturer-demo',
            ];

            if (!empty($_GET['demo_type']) && array_key_exists($_GET['demo_type'], $demo_types)) {
                $username = $demo_types[$_GET['demo_type']];
            }
        }
    @endphp

<style>
    :root {
        --primary: #FF9500;
        --primary-dark: #E68600;
        --primary-light: #FFB347;
        --black: #000000;
    }

    .login-wrapper {
        display: flex;
        gap: 3rem;
        align-items: flex-start;
        width: 100%;
        max-width: 1200px;
        justify-content: flex-end;
        padding-right: 5%;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 2.5rem;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        box-shadow: 0 8px 24px rgba(255, 149, 0, 0.3);
    }

    .login-icon svg {
        width: 32px;
        height: 32px;
        color: #fff;
    }

    .login-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    .login-subtitle {
        font-size: 0.938rem;
        color: #94a3b8;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .form-label-text {
        font-size: 0.875rem;
        font-weight: 500;
        color: #e2e8f0;
    }

    .form-label-link {
        font-size: 0.813rem;
        font-weight: 500;
        color: var(--primary);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .form-label-link:hover {
        color: var(--primary-light);
    }

    .form-input-wrapper {
        position: relative;
    }

    .form-input {
        width: 100%;
        height: 52px;
        padding: 0 1rem;
        padding-left: 3rem;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        color: #ffffff;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-input::placeholder {
        color: #a0aec0;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.15);
        color: #ffffff;
    }

    .form-input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        pointer-events: none;
    }

    .form-input-icon svg {
        width: 20px;
        height: 20px;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 0;
        transition: color 0.2s ease;
    }

    .password-toggle:hover {
        color: #94a3b8;
    }

    .password-toggle svg {
        width: 20px;
        height: 20px;
    }

    .form-checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .form-checkbox {
        width: 18px;
        height: 18px;
        border-radius: 4px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        background: transparent;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .form-checkbox-label {
        font-size: 0.875rem;
        color: #94a3b8;
        cursor: pointer;
    }

    .login-btn {
        width: 100%;
        height: 52px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        border-radius: 12px;
        color: var(--black);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(255, 149, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(255, 149, 0, 0.5);
    }

    .login-btn:active {
        transform: translateY(0);
    }

    .login-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .login-divider-line {
        flex: 1;
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
    }

    .login-divider-text {
        font-size: 0.813rem;
        color: #64748b;
    }

    .login-register {
        text-align: center;
    }

    .login-register-text {
        font-size: 0.875rem;
        color: #94a3b8;
    }

    .login-register-link {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .login-register-link:hover {
        color: var(--primary-light);
    }

    .error-message {
        color: #f87171;
        font-size: 0.813rem;
        margin-top: 0.5rem;
    }

    /* Demo section */
    .demo-section {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 2rem;
        max-width: 380px;
        width: 100%;
    }

    .demo-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .demo-subtitle {
        font-size: 0.813rem;
        color: #64748b;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .demo-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .demo-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        color: #e2e8f0;
        font-size: 0.813rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .demo-btn:hover {
        background: rgba(255, 149, 0, 0.1);
        border-color: rgba(255, 149, 0, 0.3);
        color: var(--primary);
        transform: translateY(-1px);
    }

    .demo-btn i {
        font-size: 1rem;
    }

    .demo-divider {
        border: none;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        margin: 1rem 0;
    }

    .demo-section-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }

    @media (max-width: 900px) {
        .login-wrapper {
            flex-direction: column;
            align-items: center;
        }

        .demo-section {
            max-width: 420px;
        }
    }

    @media (max-width: 480px) {
        .login-card,
        .demo-section {
            padding: 1.5rem;
        }

        .demo-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="login-wrapper">
    @if (config('app.env') == 'demo')
    <div class="demo-section">
        <h3 class="demo-title">Demo Shops</h3>
        <p class="demo-subtitle">Click any button to login with demo credentials</p>

        <div class="demo-grid">
            <a href="?demo_type=all_in_one" class="demo-btn demo-login" data-admin="{{ $demo_types['all_in_one'] }}">
                <i class="fas fa-star" style="color: #FF9500;"></i> All In One
            </a>
            <a href="?demo_type=super_market" class="demo-btn demo-login" data-admin="{{ $demo_types['super_market'] }}">
                <i class="fas fa-shopping-cart" style="color: #FF9500;"></i> Super Market
            </a>
            <a href="?demo_type=pharmacy" class="demo-btn demo-login" data-admin="{{ $demo_types['pharmacy'] }}">
                <i class="fas fa-medkit" style="color: #FF9500;"></i> Pharmacy
            </a>
            <a href="?demo_type=restaurant" class="demo-btn demo-login" data-admin="{{ $demo_types['restaurant'] }}">
                <i class="fas fa-utensils" style="color: #FF9500;"></i> Restaurant
            </a>
            <a href="?demo_type=electronics" class="demo-btn demo-login" data-admin="{{ $demo_types['electronics'] }}">
                <i class="fas fa-laptop" style="color: #FF9500;"></i> Electronics
            </a>
            <a href="?demo_type=services" class="demo-btn demo-login" data-admin="{{ $demo_types['services'] }}">
                <i class="fas fa-wrench" style="color: #FF9500;"></i> Services
            </a>
        </div>

        <hr class="demo-divider">

        <p class="demo-section-title">Premium Modules</p>
        <div class="demo-grid">
            <a href="?demo_type=superadmin" class="demo-btn demo-login" data-admin="{{ $demo_types['superadmin'] }}">
                <i class="fas fa-university" style="color: #FF9500;"></i> SaaS Admin
            </a>
            <a href="?demo_type=woocommerce" class="demo-btn demo-login" data-admin="{{ $demo_types['woocommerce'] }}">
                <i class="fab fa-wordpress" style="color: #FF9500;"></i> WooCommerce
            </a>
            <a href="?demo_type=essentials" class="demo-btn demo-login" data-admin="{{ $demo_types['essentials'] }}">
                <i class="fas fa-check-circle" style="color: #FF9500;"></i> HRM
            </a>
            <a href="?demo_type=manufacturing" class="demo-btn demo-login" data-admin="{{ $demo_types['manufacturing'] }}">
                <i class="fas fa-industry" style="color: #FF9500;"></i> Manufacturing
            </a>
        </div>
    </div>
    @endif

    <div class="login-card">
        <div class="login-header">
            <div class="login-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <h1 class="login-title">@lang('lang_v1.welcome_back')</h1>
            <p class="login-subtitle">@lang('lang_v1.login_to_your') {{ config('app.name', 'WaoBiz') }}</p>
        </div>

        <form method="POST" action="{{ route('login') }}" id="login-form">
            {{ csrf_field() }}

            <div class="form-group">
                <div class="form-label">
                    <span class="form-label-text">@lang('Username')</span>
                </div>
                <div class="form-input-wrapper">
                    <span class="form-input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </span>
                    <input type="text" name="username" id="username" class="form-input" placeholder="@lang('lang_v1.username')" value="{{ $username }}" required autofocus>
                </div>
                @if ($errors->has('username'))
                    <p class="error-message">{{ $errors->first('username') }}</p>
                @endif
            </div>

            <div class="form-group">
                <div class="form-label">
                    <span class="form-label-text">@lang('Password')</span>
                    @if (config('app.env') != 'demo')
                        <a href="{{ route('password.request') }}" class="form-label-link" tabindex="-1">@lang('lang_v1.forgot_your_password')</a>
                    @endif
                </div>
                <div class="form-input-wrapper">
                    <span class="form-input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input type="password" name="password" id="password" class="form-input" placeholder="@lang('lang_v1.password')" value="{{ $password }}" required>
                    <button type="button" id="show_hide_icon" class="password-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-open">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password'))
                    <p class="error-message">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="form-checkbox-wrapper">
                <input type="checkbox" name="remember" id="remember" class="form-checkbox" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="form-checkbox-label">@lang('lang_v1.remember_me')</label>
            </div>

            @if(config('constants.enable_recaptcha'))
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="{{ config('constants.google_recaptcha_key') }}"></div>
                @if ($errors->has('g-recaptcha-response'))
                    <p class="error-message">{{ $errors->first('g-recaptcha-response') }}</p>
                @endif
            </div>
            @endif

            <button type="submit" class="login-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                @lang('lang_v1.login')
            </button>
        </form>

        @if (!($request->segment(1) == 'business' && $request->segment(2) == 'register'))
            @if (config('constants.allow_registration'))
                <div class="login-divider">
                    <span class="login-divider-line"></span>
                    <span class="login-divider-text">or</span>
                    <span class="login-divider-line"></span>
                </div>

                <div class="login-register">
                    <p class="login-register-text">
                        {{ __('business.not_yet_registered') }}
                        <a href="{{ route('business.getRegister') }}@if (!empty(request()->lang)) {{ '?lang=' . request()->lang }} @endif" class="login-register-link">
                            {{ __('business.register_now') }}
                        </a>
                    </p>
                </div>
            @endif
        @endif
    </div>
</div>

@stop
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#show_hide_icon').off('click');

            $('.change_lang').click(function() {
                window.location = "{{ route('login') }}?lang=" + $(this).attr('value');
            });

            $('a.demo-login').click(function(e) {
                e.preventDefault();
                $('#username').val($(this).data('admin'));
                $('#password').val("{{ $password }}");
                $('form#login-form').submit();
            });

            $('#show_hide_icon').on('click', function(e) {
                e.preventDefault();
                const passwordInput = $('#password');
                const icon = $(this);

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.html('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.html('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>');
                }
            });
        });
    </script>
@endsection
