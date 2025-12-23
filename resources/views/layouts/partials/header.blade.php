@inject('request', 'Illuminate\Http\Request')
<!-- Modern Dark Header -->
<div class="modern-header tw-transition-all tw-duration-200 tw-border-b tw-shrink-0 no-print">
    <div class="tw-px-5 tw-py-3">
        <div class="tw-flex tw-items-center tw-justify-between tw-gap-4">
            <!-- Left Section: Menu & Search -->
            <div class="tw-flex tw-items-center tw-gap-4 tw-flex-1">
                <!-- Mobile Menu Button -->
                <button type="button"
                    class="small-view-button lg:tw-hidden tw-inline-flex tw-items-center tw-justify-center tw-text-sm tw-font-medium tw-text-gray-400 tw-transition-all tw-duration-200 header-icon-btn tw-p-2 tw-rounded-lg">
                    <span class="tw-sr-only">Sidebar Menu</span>
                    <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 6l16 0" />
                        <path d="M4 12l16 0" />
                        <path d="M4 18l16 0" />
                    </svg>
                </button>

                <!-- Sidebar Collapse Button -->
                <button type="button"
                    class="sidebar-toggle side-bar-collapse tw-hidden lg:tw-inline-flex tw-items-center tw-justify-center tw-text-sm tw-font-medium tw-text-gray-400 tw-transition-all tw-duration-200 header-icon-btn tw-p-2 tw-rounded-lg">
                    <span class="tw-sr-only">Collapse Sidebar</span>
                    <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                        <path d="M15 4v16" />
                        <path d="M10 10l-2 2l2 2" />
                    </svg>
                </button>

                <!-- Search Bar -->
                <div class="tw-hidden md:tw-flex tw-relative tw-flex-1 tw-max-w-md">
                    <div class="tw-absolute tw-inset-y-0 tw-left-0 tw-flex tw-items-center tw-pl-3 tw-pointer-events-none">
                        <svg class="tw-w-4 tw-h-4 tw-text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </div>
                    <input type="text" class="header-search tw-w-full tw-pl-10 tw-pr-4 tw-py-2 tw-text-sm tw-rounded-xl tw-outline-none" placeholder="Search...">
                </div>
            </div>

            {{-- Showing active package for SaaS Superadmin --}}
            @if(Module::has('Superadmin'))
                @includeIf('superadmin::layouts.partials.active_subscription')
            @endif

            {{-- When using superadmin, this button is used to switch users --}}
            @if(!empty(session('previous_user_id')) && !empty(session('previous_username')))
                <a href="{{route('sign-in-as-user', session('previous_user_id'))}}" class="btn btn-flat btn-danger m-8 btn-sm mt-10">
                    <i class="fas fa-undo"></i> @lang('lang_v1.back_to_username', ['username' => session('previous_username')])
                </a>
            @endif

            <!-- Right Section: Actions -->
            <div class="tw-flex tw-items-center tw-gap-2">
                @if (Module::has('Essentials'))
                    @includeIf('essentials::layouts.partials.header_part')
                @endif

                <!-- Quick Actions Dropdown -->
                <details class="tw-dw-dropdown tw-relative tw-inline-block tw-text-left">
                    <summary class="tw-inline-flex tw-transition-all header-icon-btn tw-cursor-pointer tw-duration-200 tw-p-2 tw-rounded-lg tw-items-center tw-justify-center tw-text-gray-400">
                        <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                            <path d="M9 12h6" />
                            <path d="M12 9v6" />
                        </svg>
                    </summary>
                    <ul class="tw-dw-menu tw-dw-dropdown-content tw-dw-z-[1] tw-w-48 tw-absolute tw-left-0 tw-z-10 tw-mt-2 tw-origin-top-right header-dropdown tw-rounded-xl tw-shadow-xl tw-ring-1 tw-ring-white/10 focus:tw-outline-none"
                        role="menu" tabindex="-1">
                        <div class="tw-p-2" role="none">
                            <a href="{{ route('calendar') }}"
                                class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-300 tw-transition-all tw-duration-200 tw-rounded-lg hover:tw-text-orange-500 hover:tw-bg-orange-500/10"
                                role="menuitem" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <rect x="4" y="5" width="16" height="16" rx="2" />
                                    <line x1="16" y1="3" x2="16" y2="7" />
                                    <line x1="8" y1="3" x2="8" y2="7" />
                                    <line x1="4" y1="11" x2="20" y2="11" />
                                    <line x1="11" y1="15" x2="12" y2="15" />
                                    <line x1="12" y1="15" x2="12" y2="18" />
                                </svg>
                                @lang('lang_v1.calendar')
                            </a>
                            @if (Module::has('Essentials'))
                                <a href="#"
                                    data-href="{{ action([\Modules\Essentials\Http\Controllers\ToDoController::class, 'create']) }}"
                                    data-container="#task_modal"
                                    class="btn-modal tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-300 tw-transition-all tw-duration-200 tw-rounded-lg hover:tw-text-orange-500 hover:tw-bg-orange-500/10"
                                    role="menuitem" tabindex="-1">
                                    <svg aria-hidden="true" class="tw-w-5 tw-h-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                        <path d="M9 12l2 2l4 -4" />
                                    </svg>
                                    @lang('essentials::lang.add_to_do')
                                </a>
                            @endif
                            @if (auth()->user()->hasRole('Admin#' . auth()->user()->business_id))
                                <a href="#" id="start_tour"
                                    class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-300 tw-transition-all tw-duration-200 tw-rounded-lg hover:tw-text-orange-500 hover:tw-bg-orange-500/10"
                                    role="menuitem" tabindex="-1">
                                    <svg aria-hidden="true" class="tw-w-5 tw-h-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M12 17l0 .01" />
                                        <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                                    </svg>
                                    Application Tour
                                </a>
                            @endif
                        </div>
                    </ul>
                </details>

                <!-- Calculator Button -->
                <button id="btnCalculator" title="@lang('lang_v1.calculator')" data-content='@include('layouts.partials.calculator')'
                    type="button" data-trigger="click" data-html="true" data-placement="bottom" data-toggle="popover"
                    class="tw-hidden md:tw-inline-flex tw-items-center tw-justify-center tw-text-gray-400 tw-transition-all tw-duration-200 header-icon-btn tw-p-2 tw-rounded-lg">
                    <span class="tw-sr-only" aria-hidden="true">Calculator</span>
                    <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 3m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                        <path d="M8 7m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z" />
                        <path d="M8 14l0 .01" />
                        <path d="M12 14l0 .01" />
                        <path d="M16 14l0 .01" />
                        <path d="M8 17l0 .01" />
                        <path d="M12 17l0 .01" />
                        <path d="M16 17l0 .01" />
                    </svg>
                </button>

                <!-- Today's Profit Button -->
                @can('profit_loss_report.view')
                    <button type="button" id="view_todays_profit" title="{{ __('home.todays_profit') }}"
                        data-toggle="tooltip" data-placement="bottom"
                        class="tw-hidden sm:tw-inline-flex tw-items-center tw-justify-center tw-text-gray-400 tw-transition-all tw-duration-200 header-icon-btn tw-p-2 tw-rounded-lg">
                        <span class="tw-sr-only">Today's Profit</span>
                        <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M3 6m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                            <path d="M18 12l.01 0" />
                            <path d="M6 12l.01 0" />
                        </svg>
                    </button>
                @endcan

                <!-- POS Sale Button - Primary Action -->
                @if (in_array('pos_sale', $enabled_modules))
                    @can('sell.create')
                        <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'create']) }}"
                            class="tw-hidden sm:tw-inline-flex tw-transition-all tw-duration-200 tw-gap-2 header-btn-primary tw-py-2 tw-px-4 tw-rounded-xl tw-items-center tw-justify-center tw-text-sm tw-font-semibold">
                            <svg aria-hidden="true" class="tw-size-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                <path d="M14 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                            </svg>
                            @lang('sale.pos_sale')
                        </a>
                    @endcan
                @endif

                @if (Module::has('Repair'))
                    @includeIf('repair::layouts.partials.header')
                @endif

                <!-- Notifications -->
                @include('layouts.partials.header-notifications')
            </div>
        </div>
    </div>
</div>

<style>
    /* Modern Dark Header Styles - CRM Style */
    .modern-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16162a 100%);
        border-color: rgba(255, 255, 255, 0.06) !important;
    }

    .modern-header .header-search {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #fff;
        transition: all 0.2s ease;
    }

    .modern-header .header-search::placeholder {
        color: #6b7280;
    }

    .modern-header .header-search:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 149, 0, 0.3);
        box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.1);
    }

    .modern-header .header-icon-btn {
        background: transparent;
        border: none;
        color: #9ca3af;
        transition: all 0.2s ease;
    }

    .modern-header .header-icon-btn:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #FF9500;
    }

    .modern-header .header-btn-primary {
        background: linear-gradient(135deg, #FF9500 0%, #E68600 100%);
        color: #000;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(255, 149, 0, 0.3);
        transition: all 0.2s ease;
    }

    .modern-header .header-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 149, 0, 0.4);
        color: #000;
    }

    .modern-header .header-dropdown {
        background: linear-gradient(135deg, #1e1e36 0%, #1a1a2e 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Notification bell styling */
    .modern-header .notification-bell {
        position: relative;
    }

    .modern-header .notification-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        min-width: 16px;
        height: 16px;
        padding: 0 4px;
        font-size: 10px;
        font-weight: 600;
        line-height: 16px;
        text-align: center;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
        border-radius: 999px;
    }
</style>
