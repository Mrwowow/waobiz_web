@inject('request', 'Illuminate\Http\Request')

@if (
    $request->segment(1) == 'pos' &&
        ($request->segment(2) == 'create' || $request->segment(3) == 'edit' || $request->segment(2) == 'payment'))
    @php
        $pos_layout = true;
    @endphp
@else
    @php
        $pos_layout = false;
    @endphp
@endif

@php
    $whitelist = ['127.0.0.1', '::1'];
@endphp

<!DOCTYPE html>
<html class="tw-scroll-smooth dark-theme" lang="{{ app()->getLocale() }}"
    dir="{{ in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? 'rtl' : 'ltr' }}">
<head>
    <!-- Tell the browser to be responsive to screen width -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ Session::get('business.name') }}</title>

    @include('layouts.partials.css')


    @include('layouts.partials.extracss')

    @yield('css')

</head>
<body
    class="tw-font-sans tw-antialiased dark-theme-body @if ($pos_layout) hold-transition lockscreen @else hold-transition skin-@if (!empty(session('business.theme_color'))){{ session('business.theme_color') }}@else{{ 'blue-light' }} @endif sidebar-mini @endif" >
    <div class="tw-flex tw-min-h-screen">
        <script type="text/javascript">
            if (localStorage.getItem("upos_sidebar_collapse") == 'true') {
                var body = document.getElementsByTagName("body")[0];
                body.className += " sidebar-collapse";
            }
        </script>
        @if (!$pos_layout)
            @include('layouts.partials.sidebar')
        @endif

        @if (in_array($_SERVER['REMOTE_ADDR'], $whitelist))
            <input type="hidden" id="__is_localhost" value="true">
        @endif

        <!-- Add currency related field-->
        <input type="hidden" id="__code" value="{{ session('currency')['code'] }}">
        <input type="hidden" id="__symbol" value="{{ session('currency')['symbol'] }}">
        <input type="hidden" id="__thousand" value="{{ session('currency')['thousand_separator'] }}">
        <input type="hidden" id="__decimal" value="{{ session('currency')['decimal_separator'] }}">
        <input type="hidden" id="__symbol_placement" value="{{ session('business.currency_symbol_placement') }}">
        <input type="hidden" id="__precision" value="{{ session('business.currency_precision', 2) }}">
        <input type="hidden" id="__quantity_precision" value="{{ session('business.quantity_precision', 2) }}">
        <!-- End of currency related field-->
        @can('view_export_buttons')
            <input type="hidden" id="view_export_buttons">
        @endcan
        @if (isMobile())
            <input type="hidden" id="__is_mobile">
        @endif
        @if (session('status'))
            <input type="hidden" id="status_span" data-status="{{ session('status.success') }}"
                data-msg="{{ session('status.msg') }}">
        @endif
        <main class="tw-flex tw-flex-col tw-flex-1 tw-h-full tw-min-w-0 main-content-area">

            @if (!$pos_layout)
                @include('layouts.partials.header')
            @else
                @include('layouts.partials.header-pos')
            @endif
            <!-- empty div for vuejs -->
            <div id="app">
                @yield('vue')
            </div>
            <div class="tw-flex-1 tw-overflow-y-auto tw-h-screen" id="scrollable-container">
                @yield('content')
                @if (!$pos_layout)

                    @include('layouts.partials.footer')
                @else
                    @include('layouts.partials.footer_pos')
                @endif
            </div>
            <div class='scrolltop no-print'>
                <div class='scroll icon'><i class="fas fa-angle-up"></i></div>
            </div>

            @if (config('constants.iraqi_selling_price_adjustment'))
                <input type="hidden" id="iraqi_selling_price_adjustment">
            @endif

            <!-- This will be printed -->
            <section class="invoice print_section" id="receipt_section">
            </section>
        </main>

        @include('home.todays_profit_modal')
        <!-- /.content-wrapper -->



        <audio id="success-audio">
            <source src="{{ asset('/audio/success.ogg?v=' . $asset_v) }}" type="audio/ogg">
            <source src="{{ asset('/audio/success.mp3?v=' . $asset_v) }}" type="audio/mpeg">
        </audio>
        <audio id="error-audio">
            <source src="{{ asset('/audio/error.ogg?v=' . $asset_v) }}" type="audio/ogg">
            <source src="{{ asset('/audio/error.mp3?v=' . $asset_v) }}" type="audio/mpeg">
        </audio>
        <audio id="warning-audio">
            <source src="{{ asset('/audio/warning.ogg?v=' . $asset_v) }}" type="audio/ogg">
            <source src="{{ asset('/audio/warning.mp3?v=' . $asset_v) }}" type="audio/mpeg">
        </audio>

        @if (!empty($__additional_html))
            {!! $__additional_html !!}
        @endif

        @include('layouts.partials.javascripts')

        <div class="modal fade view_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

        @if (!empty($__additional_views) && is_array($__additional_views))
            @foreach ($__additional_views as $additional_view)
                @includeIf($additional_view)
            @endforeach
        @endif
        <div>

            <div class="overlay tw-hidden"></div>
</body>
<style>
    /* Dark Theme Base */
    html.dark-theme {
        background: #0f0f1a;
    }

    .dark-theme-body {
        background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 100%);
        color: #e5e7eb;
    }

    .main-content-area {
        background: linear-gradient(135deg, #0f0f1a 0%, #12121f 100%);
    }

    @media print {
        #scrollable-container {
            overflow: visible !important;
            height: auto !important;
        }
    }

    .small-view-side-active {
        display: flex !important;
        z-index: 9999 !important;
        position: fixed !important;
    }

    .overlay {
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.85);
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        z-index: 9998 !important;
    }

    .tw-dw-btn.tw-dw-btn-xs.tw-dw-btn-outline {
        width: max-content;
        margin: 2px;
    }

    #scrollable-container {
        position: relative;
    }

    /* Scroll to top button */
    .scrolltop {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 999;
    }

    .scrolltop .scroll {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #FF9500 0%, #E68600 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #000;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(255, 149, 0, 0.3);
        transition: all 0.2s ease;
    }

    .scrolltop .scroll:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 149, 0, 0.4);
    }
</style>

</html>
