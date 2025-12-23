@extends('layouts.auth2')
@section('title', config('app.name', 'ultimatePOS'))
@inject('request', 'Illuminate\Http\Request')
@section('content')

<style>
    :root {
        --primary: #FF9500;
        --primary-dark: #E68600;
        --primary-light: #FFB347;
        --black: #000000;
    }

    .welcome-container {
        text-align: center;
        max-width: 800px;
        padding: 2rem;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 149, 0, 0.15);
        border: 1px solid rgba(255, 149, 0, 0.3);
        color: var(--primary);
        font-size: 0.813rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 100px;
        margin-bottom: 1.5rem;
    }

    .welcome-badge svg {
        width: 16px;
        height: 16px;
    }

    .welcome-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #fff 0%, #e2e8f0 50%, #94a3b8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .welcome-title .highlight {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .welcome-subtitle {
        font-size: 1.25rem;
        color: #94a3b8;
        font-weight: 400;
        line-height: 1.6;
        margin-bottom: 2.5rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .welcome-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 3rem;
    }

    .welcome-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--black);
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(255, 149, 0, 0.4);
    }

    .welcome-btn-primary:hover {
        color: var(--black);
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(255, 149, 0, 0.5);
    }

    .welcome-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .welcome-btn-secondary:hover {
        color: var(--primary);
        background: rgba(255, 149, 0, 0.1);
        border-color: rgba(255, 149, 0, 0.3);
    }

    .welcome-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .feature-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        background: rgba(255, 149, 0, 0.05);
        border-color: rgba(255, 149, 0, 0.15);
        transform: translateY(-4px);
    }

    .feature-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        background: linear-gradient(135deg, rgba(255, 149, 0, 0.2) 0%, rgba(255, 149, 0, 0.1) 100%);
        color: var(--primary);
    }

    .feature-title {
        font-size: 0.938rem;
        font-weight: 600;
        color: #e2e8f0;
        margin-bottom: 0.5rem;
    }

    .feature-desc {
        font-size: 0.813rem;
        color: #64748b;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .welcome-title {
            font-size: 2.25rem;
        }

        .welcome-subtitle {
            font-size: 1rem;
        }

        .welcome-buttons {
            flex-direction: column;
            align-items: center;
        }

        .welcome-btn-primary,
        .welcome-btn-secondary {
            width: 100%;
            max-width: 280px;
            justify-content: center;
        }
    }
</style>

<div class="welcome-container">
    <div class="welcome-badge">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813A3.75 3.75 0 007.466 7.89l.813-2.846A.75.75 0 019 4.5z" clip-rule="evenodd" />
        </svg>
        {{ env('APP_TITLE', 'Smart Business Manager') }}
    </div>

    <h1 class="welcome-title">
        Manage Your Business <br><span class="highlight">Smarter & Faster</span>
    </h1>

    <p class="welcome-subtitle">
        The complete point of sale and business management solution.
        Streamline operations, track inventory, and grow your business with powerful insights.
    </p>

    <div class="welcome-buttons">
        <a href="{{ route('login') }}" class="welcome-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                <polyline points="10 17 15 12 10 7"/>
                <line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            Sign In
        </a>
        @if (config('constants.allow_registration'))
        <a href="{{ route('business.getRegister')}}@if(!empty(request()->lang)){{'?lang='.request()->lang}}@endif" class="welcome-btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="8.5" cy="7" r="4"/>
                <line x1="20" y1="8" x2="20" y2="14"/>
                <line x1="23" y1="11" x2="17" y2="11"/>
            </svg>
            Create Account
        </a>
        @endif
    </div>

    <div class="welcome-features">
        <div class="feature-card">
            <div class="feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                    <line x1="8" y1="21" x2="16" y2="21"/>
                    <line x1="12" y1="17" x2="12" y2="21"/>
                </svg>
            </div>
            <h3 class="feature-title">Point of Sale</h3>
            <p class="feature-desc">Fast, intuitive POS for seamless transactions</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                    <line x1="12" y1="22.08" x2="12" y2="12"/>
                </svg>
            </div>
            <h3 class="feature-title">Inventory</h3>
            <p class="feature-desc">Real-time stock tracking and alerts</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="20" x2="12" y2="10"/>
                    <line x1="18" y1="20" x2="18" y2="4"/>
                    <line x1="6" y1="20" x2="6" y2="16"/>
                </svg>
            </div>
            <h3 class="feature-title">Analytics</h3>
            <p class="feature-desc">Powerful insights and reports</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <h3 class="feature-title">Team Management</h3>
            <p class="feature-desc">Multi-user roles and permissions</p>
        </div>
    </div>
</div>

@endsection
