<!-- Modern Dark Sidebar - CRM Style -->
<aside class="modern-sidebar side-bar tw-relative tw-hidden tw-h-full tw-w-64 xl:tw-w-64 lg:tw-flex lg:tw-flex-col tw-shrink-0">

    <!-- Logo Section -->
    <div class="sidebar-logo tw-p-6 tw-shrink-0">
        <div class="tw-flex tw-items-center tw-justify-between">
            <a href="{{route('home')}}" class="tw-flex tw-items-center tw-justify-center tw-flex-1">
                <img src="{{ asset('img/WaoBiz-Logo.svg') }}" alt="{{ config('app.name') }}" class="tw-h-14 tw-w-auto" />
            </a>
            <!-- Mobile Close Button -->
            <button type="button" class="mobile-close-btn lg:tw-hidden tw-p-2 tw-rounded-lg tw-text-gray-400 hover:tw-text-orange-500 hover:tw-bg-white/5 tw-transition-all" onclick="closeMobileSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6L6 18"></path>
                    <path d="M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- User Profile Card with Floating Dropdown -->
    <div class="sidebar-user-card tw-mx-4 tw-mb-4 tw-mt-2 tw-relative">
        <div class="user-profile-trigger tw-flex tw-items-center tw-gap-3 tw-p-3 tw-cursor-pointer" onclick="toggleUserDropdown(event)">
            <div class="tw-relative tw-shrink-0">
                @if(auth()->check() && auth()->user()->media && auth()->user()->media->display_url)
                    <img src="{{ auth()->user()->media->display_url }}" alt="Profile" class="user-avatar-img" />
                @else
                    <div class="user-avatar tw-w-11 tw-h-11 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-text-white tw-font-bold tw-text-base">
                        {{ strtoupper(substr(Session::get('user.first_name', 'U'), 0, 1)) }}{{ strtoupper(substr(Session::get('user.last_name', ''), 0, 1)) }}
                    </div>
                @endif
                <span class="online-indicator" id="online_indicator"></span>
            </div>
            <div class="tw-flex-1 tw-min-w-0">
                <p class="tw-text-sm tw-font-semibold tw-text-white tw-truncate">
                    {{ Session::get('user.first_name') }} {{ Session::get('user.last_name') }}
                </p>
                <p class="tw-text-xs tw-text-gray-400 tw-truncate">
                    {{ Session::get('business.name', 'Administrator') }}
                </p>
            </div>
            <div class="dropdown-chevron">
                <svg xmlns="http://www.w3.org/2000/svg" class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </div>
        </div>
        <!-- Floating Profile Dropdown Menu -->
        <div class="user-dropdown-popup" id="userDropdownPopup">
            <div class="dropdown-arrow"></div>
            <a href="{{ action([\App\Http\Controllers\UserController::class, 'getProfile']) }}" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>@lang('lang_v1.profile')</span>
            </a>
            <a href="{{ action([\App\Http\Controllers\BusinessController::class, 'getBusinessSettings']) }}" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
                <span>@lang('business.business_settings')</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'logout']) }}" class="dropdown-item dropdown-item-logout">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>@lang('lang_v1.sign_out')</span>
            </a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-menu-wrapper tw-flex-1 tw-overflow-y-auto tw-overflow-x-hidden tw-px-3">
        <div class="sidebar-section-header tw-px-3 tw-py-2">
            <span class="tw-text-[11px] tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider">Main Menu</span>
        </div>
        {!! Menu::render('admin-sidebar-menu', 'adminltecustom') !!}
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer tw-p-4 tw-border-t tw-border-white/5">
        <a href="{{ action([\App\Http\Controllers\UserController::class, 'getProfile']) }}"
           class="tw-flex tw-items-center tw-gap-2 tw-text-xs tw-text-gray-500 hover:tw-text-orange-500 tw-transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
            <span>Settings</span>
        </a>
    </div>
</aside>

<style>
    /* Modern Dark Sidebar Styles - CRM Style */
    .modern-sidebar {
        background: linear-gradient(180deg, #1a1a2e 0%, #16162a 100%);
        border-right: 1px solid rgba(255, 255, 255, 0.06);
        overflow: visible;
    }

    .modern-sidebar .sidebar-logo {
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    /* User Avatar with distinct gradient */
    .modern-sidebar .user-avatar {
        background: linear-gradient(135deg, #FF9500 0%, #E68600 100%);
        box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
        border-radius: 50% !important;
    }

    /* User Avatar Image - Perfect Circle */
    .modern-sidebar .user-avatar-img {
        width: 44px !important;
        height: 44px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        border: 2px solid rgba(255, 149, 0, 0.4) !important;
        box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3) !important;
        transition: all 0.2s ease !important;
    }

    .modern-sidebar .user-profile-trigger:hover .user-avatar-img {
        border-color: #FF9500 !important;
        box-shadow: 0 6px 16px rgba(255, 149, 0, 0.4) !important;
    }

    /* Online Indicator - Positioned on top of border */
    .modern-sidebar .online-indicator {
        position: absolute !important;
        bottom: 2px !important;
        right: 2px !important;
        width: 12px !important;
        height: 12px !important;
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
        border-radius: 50% !important;
        border: 2px solid #1a1a2e !important;
        z-index: 10 !important;
        animation: pulse-green 2s infinite !important;
    }

    /* User Profile Card */
    .modern-sidebar .sidebar-user-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 12px;
        overflow: visible;
        position: relative;
    }

    /* User Profile Trigger */
    .modern-sidebar .user-profile-trigger:hover {
        background: rgba(255, 255, 255, 0.03);
    }

    .modern-sidebar .user-profile-trigger:hover .dropdown-chevron {
        background: rgba(255, 149, 0, 0.15);
        color: #FF9500;
    }

    .modern-sidebar .user-profile-trigger.active {
        background: rgba(255, 255, 255, 0.03);
    }

    .modern-sidebar .user-profile-trigger.active .dropdown-chevron .chevron-icon {
        transform: rotate(180deg) !important;
    }

    .modern-sidebar .user-profile-trigger:hover .dropdown-chevron .chevron-icon {
        color: #FF9500 !important;
    }

    .modern-sidebar .dropdown-chevron {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 24px !important;
        height: 24px !important;
        border-radius: 6px !important;
        background: rgba(255, 255, 255, 0.06) !important;
        transition: all 0.2s ease !important;
        flex-shrink: 0 !important;
    }

    .modern-sidebar .dropdown-chevron .chevron-icon {
        width: 14px !important;
        height: 14px !important;
        color: #9ca3af !important;
        stroke: currentColor !important;
        transition: transform 0.2s ease !important;
    }

    /* Floating Dropdown Popup - White/Light Style */
    .modern-sidebar .user-dropdown-popup {
        position: absolute;
        top: 100%;
        left: 0.5rem;
        right: 0.5rem;
        margin-top: 8px;
        background: #ffffff;
        border-radius: 12px;
        padding: 0.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3), 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: all 0.2s ease;
    }

    .modern-sidebar .user-dropdown-popup.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Dropdown Arrow */
    .modern-sidebar .user-dropdown-popup .dropdown-arrow {
        position: absolute;
        top: -6px;
        left: 24px;
        width: 12px;
        height: 12px;
        background: #ffffff;
        transform: rotate(45deg);
        border-radius: 2px;
    }

    .modern-sidebar .user-dropdown-popup .dropdown-item {
        display: flex !important;
        align-items: center !important;
        gap: 0.75rem !important;
        padding: 0.625rem 0.875rem !important;
        font-size: 0.8125rem !important;
        font-weight: 500 !important;
        color: #374151 !important;
        text-decoration: none !important;
        border-radius: 8px !important;
        transition: all 0.15s ease !important;
        position: relative !important;
        background: transparent !important;
    }

    .modern-sidebar .user-dropdown-popup .dropdown-item:hover {
        background: #f3f4f6 !important;
        color: #111827 !important;
    }

    .modern-sidebar .user-dropdown-popup .dropdown-item svg {
        width: 18px !important;
        height: 18px !important;
        min-width: 18px !important;
        min-height: 18px !important;
        max-width: 18px !important;
        max-height: 18px !important;
        color: #6b7280 !important;
        flex-shrink: 0 !important;
    }

    .modern-sidebar .user-dropdown-popup .dropdown-item:hover svg {
        color: #374151 !important;
    }

    .modern-sidebar .user-dropdown-popup .dropdown-item span {
        color: inherit !important;
        font-size: 0.8125rem !important;
        font-weight: 500 !important;
    }

    .modern-sidebar .user-dropdown-popup .dropdown-item-logout {
        color: #dc2626 !important;
    }

    .modern-sidebar .user-dropdown-popup .dropdown-item-logout:hover {
        background: #fef2f2 !important;
        color: #b91c1c !important;
    }

    .modern-sidebar .user-dropdown-popup .dropdown-item-logout svg {
        color: #dc2626 !important;
    }

    .modern-sidebar .user-dropdown-popup .dropdown-item-logout:hover svg {
        color: #b91c1c !important;
    }

    .modern-sidebar .user-dropdown-popup .dropdown-divider {
        height: 1px !important;
        background: #e5e7eb !important;
        margin: 0.375rem 0 !important;
    }

    /* Scrollbar */
    .modern-sidebar .sidebar-menu-wrapper {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 149, 0, 0.2) transparent;
    }

    .modern-sidebar .sidebar-menu-wrapper::-webkit-scrollbar {
        width: 4px;
    }

    .modern-sidebar .sidebar-menu-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    .modern-sidebar .sidebar-menu-wrapper::-webkit-scrollbar-thumb {
        background: rgba(255, 149, 0, 0.2);
        border-radius: 4px;
    }

    .modern-sidebar .sidebar-menu-wrapper::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 149, 0, 0.4);
    }

    .modern-sidebar .sidebar-footer {
        background: rgba(0, 0, 0, 0.2);
    }

    .modern-sidebar .sidebar-footer a {
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
    }

    .modern-sidebar .sidebar-footer svg {
        width: 16px !important;
        height: 16px !important;
        min-width: 16px !important;
        max-width: 16px !important;
        min-height: 16px !important;
        max-height: 16px !important;
        flex-shrink: 0 !important;
    }

    /* Constrain all sidebar SVG icons */
    .modern-sidebar svg:not(.chevron-icon) {
        max-width: 24px !important;
        max-height: 24px !important;
    }

    /* Hide any decorative/background icons */
    .modern-sidebar > svg,
    .modern-sidebar .sidebar-menu-wrapper > svg {
        display: none !important;
    }

    /* ========================================
       Custom Menu Presenter Styles (Tailwind-based)
       ======================================== */

    /* Side bar container override */
    .modern-sidebar #side-bar {
        border-right: none !important;
        background: transparent !important;
        padding: 0.5rem !important;
    }

    /* All menu items - base styles for dark theme */
    .modern-sidebar #side-bar a {
        color: #9ca3af !important;
        background: transparent !important;
        border-radius: 8px !important;
        transition: all 0.2s ease !important;
    }

    /* Menu items hover - Orange background */
    .modern-sidebar #side-bar a:hover {
        background: #FF9500 !important;
        color: #000000 !important;
    }

    .modern-sidebar #side-bar a:hover i,
    .modern-sidebar #side-bar a:hover span,
    .modern-sidebar #side-bar a:hover svg {
        color: #000000 !important;
    }

    /* Dropdown parent with active child - Orange background */
    .modern-sidebar #side-bar .tw-bg-gray-200,
    .modern-sidebar #side-bar .tw-pb-1.tw-rounded-md.tw-bg-gray-200,
    .modern-sidebar #side-bar div[class*="tw-bg-gray-200"],
    .modern-sidebar #side-bar a.tw-bg-gray-200,
    .modern-sidebar #side-bar a.drop_down.tw-bg-gray-200,
    .modern-sidebar #side-bar > div.tw-bg-gray-200,
    .modern-sidebar #side-bar > div.tw-pb-1 {
        background: transparent !important;
    }

    /* Dropdown toggle when has active child - Orange background */
    .modern-sidebar #side-bar a.drop_down.tw-pb-1,
    .modern-sidebar #side-bar a.drop_down.tw-bg-gray-200,
    .modern-sidebar #side-bar a.drop_down.tw-rounded-md,
    .modern-sidebar #side-bar div.tw-pb-1 > a.drop_down,
    .modern-sidebar #side-bar div.tw-bg-gray-200 > a.drop_down,
    .modern-sidebar #side-bar div.tw-rounded-md > a.drop_down {
        background: #FF9500 !important;
        color: #000000 !important;
    }

    .modern-sidebar #side-bar a.drop_down.tw-pb-1 i,
    .modern-sidebar #side-bar a.drop_down.tw-pb-1 span,
    .modern-sidebar #side-bar a.drop_down.tw-pb-1 svg,
    .modern-sidebar #side-bar a.drop_down.tw-bg-gray-200 i,
    .modern-sidebar #side-bar a.drop_down.tw-bg-gray-200 span,
    .modern-sidebar #side-bar a.drop_down.tw-bg-gray-200 svg,
    .modern-sidebar #side-bar div.tw-pb-1 > a.drop_down i,
    .modern-sidebar #side-bar div.tw-pb-1 > a.drop_down span,
    .modern-sidebar #side-bar div.tw-pb-1 > a.drop_down svg {
        color: #000000 !important;
    }

    /* Child menu container - dark background */
    .modern-sidebar #side-bar .chiled,
    .modern-sidebar #side-bar div.tw-pl-11 {
        background: rgba(0, 0, 0, 0.2) !important;
        border-radius: 0 0 8px 8px !important;
        margin-top: 0 !important;
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }

    /* Vertical line in child menu - Orange */
    .modern-sidebar #side-bar .chiled .tw-bg-gray-200,
    .modern-sidebar #side-bar .chiled > div.tw-bg-gray-200 {
        background: rgba(255, 149, 0, 0.3) !important;
    }

    /* Child menu items */
    .modern-sidebar #side-bar .chiled a {
        color: #9ca3af !important;
        padding: 0.4rem 0.5rem !important;
        border-radius: 6px !important;
    }

    .modern-sidebar #side-bar .chiled a:hover {
        background: #FF9500 !important;
        color: #000000 !important;
    }

    /* Active child item - Orange text */
    .modern-sidebar #side-bar .chiled a.tw-text-primary-700,
    .modern-sidebar #side-bar .chiled a[class*="tw-text-primary"] {
        color: #FF9500 !important;
        font-weight: 600 !important;
    }

    .modern-sidebar #side-bar .chiled a.tw-text-primary-700:hover,
    .modern-sidebar #side-bar .chiled a[class*="tw-text-primary"]:hover {
        background: #FF9500 !important;
        color: #000000 !important;
    }

    /* Active single menu item */
    .modern-sidebar #side-bar > a.tw-bg-gray-200,
    .modern-sidebar #side-bar > a.tw-text-primary-700,
    .modern-sidebar #side-bar > a[class*="tw-bg-gray-200"] {
        background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
        color: #000000 !important;
    }

    .modern-sidebar #side-bar > a.tw-bg-gray-200 i,
    .modern-sidebar #side-bar > a.tw-bg-gray-200 span,
    .modern-sidebar #side-bar > a.tw-text-primary-700 i,
    .modern-sidebar #side-bar > a.tw-text-primary-700 span {
        color: #000000 !important;
    }

    /* Override hover background colors from Tailwind */
    .modern-sidebar #side-bar a.hover\:tw-bg-gray-100:hover,
    .modern-sidebar #side-bar a[class*="hover:tw-bg-gray"]:hover {
        background: #FF9500 !important;
    }

    /* Fix focus states */
    .modern-sidebar #side-bar a:focus,
    .modern-sidebar #side-bar a.focus\:tw-bg-gray-100:focus {
        background: #FF9500 !important;
        color: #000000 !important;
    }

    /* Collapsed sidebar state */
    .sidebar-collapse .modern-sidebar {
        width: 70px !important;
    }

    .sidebar-collapse .modern-sidebar .sidebar-logo span,
    .sidebar-collapse .modern-sidebar .sidebar-user-card,
    .sidebar-collapse .modern-sidebar .sidebar-section-header,
    .sidebar-collapse .modern-sidebar .sidebar-footer a span,
    .sidebar-collapse .modern-sidebar .sidebar-menu > li > a > span,
    .sidebar-collapse .modern-sidebar .sidebar-menu > li > a > .pull-right-container,
    .sidebar-collapse .modern-sidebar .treeview-menu {
        display: none !important;
    }

    .sidebar-collapse .modern-sidebar .sidebar-logo {
        padding: 1rem;
    }

    .sidebar-collapse .modern-sidebar .sidebar-logo a {
        justify-content: center;
    }

    .sidebar-collapse .modern-sidebar .sidebar-logo img {
        height: 2rem;
    }

    .sidebar-collapse .modern-sidebar .sidebar-menu > li > a {
        justify-content: center;
        padding: 0.75rem;
        margin: 0 0.5rem;
    }

    .sidebar-collapse .modern-sidebar .sidebar-menu > li > a > i {
        margin: 0;
        font-size: 1.125rem;
    }

    .sidebar-collapse .modern-sidebar .sidebar-footer {
        padding: 0.75rem;
    }

    .sidebar-collapse .modern-sidebar .sidebar-footer a {
        justify-content: center;
    }

    /* Mobile sidebar styles */
    @media (max-width: 1023px) {
        .modern-sidebar {
            display: none !important;
        }

        .modern-sidebar.small-view-side-active {
            position: fixed !important;
            left: 0 !important;
            top: 0 !important;
            bottom: 0 !important;
            width: 280px !important;
            height: 100vh !important;
            z-index: 9999 !important;
            display: flex !important;
            flex-direction: column !important;
            background: linear-gradient(180deg, #1a1a2e 0%, #16162a 100%) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.5) !important;
            animation: slideIn 0.3s ease !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        /* Mobile close button */
        .modern-sidebar.small-view-side-active .sidebar-logo {
            position: relative !important;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    }

    /* Pulse animation for online indicator */
    @keyframes pulse-green {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4);
        }
        50% {
            box-shadow: 0 0 0 6px rgba(34, 197, 94, 0);
        }
    }

    #online_indicator {
        animation: pulse-green 2s infinite;
    }
</style>

<script>
    // User Profile Dropdown Toggle
    function toggleUserDropdown(event) {
        event.stopPropagation();
        const trigger = event.currentTarget;
        const popup = document.getElementById('userDropdownPopup');

        if (popup.classList.contains('show')) {
            popup.classList.remove('show');
            trigger.classList.remove('active');
        } else {
            popup.classList.add('show');
            trigger.classList.add('active');
        }
    }

    // Close Mobile Sidebar
    function closeMobileSidebar() {
        const sidebar = document.querySelector('.modern-sidebar');
        const overlay = document.querySelector('.overlay');

        if (sidebar) {
            sidebar.classList.remove('small-view-side-active');
        }
        if (overlay) {
            $(overlay).fadeOut('slow');
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const popup = document.getElementById('userDropdownPopup');
        const trigger = document.querySelector('.user-profile-trigger');

        if (popup && !popup.contains(event.target) && !trigger.contains(event.target)) {
            popup.classList.remove('show');
            if (trigger) trigger.classList.remove('active');
        }
    });

    // Close dropdown on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const popup = document.getElementById('userDropdownPopup');
            const trigger = document.querySelector('.user-profile-trigger');
            if (popup) popup.classList.remove('show');
            if (trigger) trigger.classList.remove('active');

            // Also close mobile sidebar on Escape
            closeMobileSidebar();
        }
    });
</script>
