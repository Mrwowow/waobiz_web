@extends('layouts.app')

@section('title', __('crm::lang.crm'))

@section('css')
<style>
    /* Dashboard Modern Styles */
    .crm-dashboard {
        padding: 1rem 0;
    }

    /* Welcome Header */
    .welcome-header {
        background: linear-gradient(135deg, #FF9500 0%, #FF6B00 100%);
        border-radius: 16px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .welcome-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    .welcome-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: 10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }
    .welcome-header h2 {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.25rem 0;
        position: relative;
        z-index: 1;
    }
    .welcome-header p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
        position: relative;
        z-index: 1;
    }
    .welcome-header .quick-actions {
        position: relative;
        z-index: 1;
        margin-top: 1rem;
    }
    .welcome-header .quick-actions a {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        transition: all 0.2s;
    }
    .welcome-header .quick-actions a:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .stats-grid { grid-template-columns: 1fr; }
    }

    /* Stat Card */
    .stat-card {
        background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px -12px rgba(0, 0, 0, 0.4);
    }
    .stat-card .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    .stat-card .stat-label {
        color: #9ca3af;
        font-size: 0.875rem;
    }

    /* Color variants for stat cards */
    .stat-card.primary .stat-icon { background: rgba(255, 149, 0, 0.15); color: #FF9500; }
    .stat-card.success .stat-icon { background: rgba(34, 197, 94, 0.15); color: #4ADE80; }
    .stat-card.warning .stat-icon { background: rgba(245, 158, 11, 0.15); color: #FBBF24; }
    .stat-card.danger .stat-icon { background: rgba(239, 68, 68, 0.15); color: #F87171; }
    .stat-card.info .stat-icon { background: rgba(59, 130, 246, 0.15); color: #60A5FA; }
    .stat-card.purple .stat-icon { background: rgba(139, 92, 246, 0.15); color: #A78BFA; }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1200px) {
        .dashboard-grid { grid-template-columns: 1fr; }
    }

    /* Widget Card */
    .widget-card {
        background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        overflow: hidden;
    }
    .widget-card .widget-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .widget-card .widget-header h3 {
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .widget-card .widget-header h3 i {
        color: #FF9500;
    }
    .widget-card .widget-header .view-all {
        color: #FF9500;
        font-size: 0.875rem;
        text-decoration: none;
    }
    .widget-card .widget-header .view-all:hover {
        text-decoration: underline;
    }
    .widget-card .widget-body {
        padding: 1rem 1.25rem;
    }

    /* Today's Tasks */
    .task-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.875rem;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 10px;
        margin-bottom: 0.75rem;
        transition: background 0.2s;
    }
    .task-item:last-child { margin-bottom: 0; }
    .task-item:hover { background: rgba(255, 255, 255, 0.04); }
    .task-item .task-time {
        min-width: 70px;
        text-align: center;
    }
    .task-item .task-time .time {
        font-size: 0.875rem;
        font-weight: 600;
        color: #FF9500;
    }
    .task-item .task-time .period {
        font-size: 0.7rem;
        color: #9ca3af;
        text-transform: uppercase;
    }
    .task-item .task-info {
        flex: 1;
    }
    .task-item .task-info .task-title {
        color: #fff;
        font-weight: 500;
        margin-bottom: 0.125rem;
    }
    .task-item .task-info .task-contact {
        color: #9ca3af;
        font-size: 0.8rem;
    }
    .task-item .task-type {
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .task-type.call { background: rgba(59, 130, 246, 0.15); color: #60A5FA; }
    .task-type.email { background: rgba(139, 92, 246, 0.15); color: #A78BFA; }
    .task-type.meeting { background: rgba(34, 197, 94, 0.15); color: #4ADE80; }
    .task-type.sms { background: rgba(245, 158, 11, 0.15); color: #FBBF24; }
    .task-type.other { background: rgba(107, 114, 128, 0.15); color: #9CA3AF; }

    /* Lead Item */
    .lead-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.875rem;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 10px;
        margin-bottom: 0.75rem;
        transition: background 0.2s;
    }
    .lead-item:last-child { margin-bottom: 0; }
    .lead-item:hover { background: rgba(255, 255, 255, 0.04); }
    .lead-item .lead-avatar {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: linear-gradient(135deg, #FF9500 0%, #FF6B00 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
    }
    .lead-item .lead-info {
        flex: 1;
    }
    .lead-item .lead-info .lead-name {
        color: #fff;
        font-weight: 500;
        margin-bottom: 0.125rem;
    }
    .lead-item .lead-info .lead-contact {
        color: #9ca3af;
        font-size: 0.8rem;
    }
    .lead-item .lead-stage {
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Activity Feed */
    .activity-item {
        display: flex;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-item .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        flex-shrink: 0;
    }
    .activity-icon.blue { background: rgba(59, 130, 246, 0.15); color: #60A5FA; }
    .activity-icon.green { background: rgba(34, 197, 94, 0.15); color: #4ADE80; }
    .activity-icon.orange { background: rgba(255, 149, 0, 0.15); color: #FF9500; }
    .activity-icon.purple { background: rgba(139, 92, 246, 0.15); color: #A78BFA; }
    .activity-item .activity-content {
        flex: 1;
    }
    .activity-item .activity-title {
        color: #fff;
        font-size: 0.875rem;
        margin-bottom: 0.125rem;
    }
    .activity-item .activity-desc {
        color: #9ca3af;
        font-size: 0.8rem;
    }
    .activity-item .activity-time {
        color: #6b7280;
        font-size: 0.75rem;
    }

    /* Pipeline Chart */
    .pipeline-chart {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .pipeline-stage {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .pipeline-stage .stage-name {
        min-width: 100px;
        color: #9ca3af;
        font-size: 0.875rem;
    }
    .pipeline-stage .stage-bar {
        flex: 1;
        height: 28px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 6px;
        overflow: hidden;
        position: relative;
    }
    .pipeline-stage .stage-bar .bar-fill {
        height: 100%;
        border-radius: 6px;
        display: flex;
        align-items: center;
        padding: 0 0.75rem;
        transition: width 0.5s ease;
    }
    .pipeline-stage .stage-bar .bar-fill span {
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .pipeline-stage .stage-count {
        min-width: 40px;
        text-align: right;
        color: #fff;
        font-weight: 600;
    }

    /* Conversion Rate Circle */
    .conversion-widget {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1.5rem;
    }
    .conversion-circle {
        position: relative;
        width: 140px;
        height: 140px;
    }
    .conversion-circle svg {
        transform: rotate(-90deg);
    }
    .conversion-circle .circle-bg {
        fill: none;
        stroke: rgba(255, 255, 255, 0.08);
        stroke-width: 12;
    }
    .conversion-circle .circle-progress {
        fill: none;
        stroke: #FF9500;
        stroke-width: 12;
        stroke-linecap: round;
        transition: stroke-dashoffset 0.5s ease;
    }
    .conversion-value {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
    .conversion-value .value {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
    }
    .conversion-value .label {
        color: #9ca3af;
        font-size: 0.75rem;
    }
    .conversion-stats {
        display: flex;
        gap: 2rem;
        margin-top: 1.5rem;
    }
    .conversion-stats .stat {
        text-align: center;
    }
    .conversion-stats .stat-num {
        font-size: 1.25rem;
        font-weight: 600;
        color: #fff;
    }
    .conversion-stats .stat-label {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #9ca3af;
    }
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    .empty-state p {
        margin: 0;
    }

    /* Trend Chart */
    .trend-chart {
        display: flex;
        align-items: flex-end;
        gap: 0.5rem;
        height: 100px;
        padding: 1rem 0;
    }
    .trend-bar {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .trend-bar .bar {
        width: 100%;
        max-width: 40px;
        background: linear-gradient(180deg, #FF9500 0%, #FF6B00 100%);
        border-radius: 4px 4px 0 0;
        transition: height 0.3s ease;
    }
    .trend-bar .label {
        margin-top: 0.5rem;
        font-size: 0.7rem;
        color: #9ca3af;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.dashboard')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div class="crm-dashboard">
        <!-- Welcome Header -->
        <div class="welcome-header">
            <h2>@lang('crm::lang.welcome_back'), {{ auth()->user()->first_name ?? auth()->user()->username }}!</h2>
            <p>@lang('crm::lang.dashboard_subtitle')</p>
            <div class="quick-actions">
                <a href="{{ url('crm/leads/create') }}">
                    <i class="fas fa-plus"></i> @lang('crm::lang.add_lead')
                </a>
                <a href="{{ url('crm/schedules/create') }}">
                    <i class="fas fa-calendar-plus"></i> @lang('crm::lang.add_followup')
                </a>
                <a href="{{ url('crm/leads-kanban') }}">
                    <i class="fas fa-columns"></i> @lang('crm::lang.kanban_view')
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-value">{{ $total_leads }}</div>
                <div class="stat-label">@lang('crm::lang.active_leads')</div>
            </div>

            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-value">{{ $converted_leads }}</div>
                <div class="stat-label">@lang('crm::lang.converted_leads')</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value">{{ $upcoming_followups }}</div>
                <div class="stat-label">@lang('crm::lang.upcoming_followups')</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-value">{{ $overdue_followups }}</div>
                <div class="stat-label">@lang('crm::lang.overdue_followups')</div>
            </div>
        </div>

        <!-- Secondary Stats -->
        <div class="stats-grid">
            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="stat-value">{{ $total_proposals }}</div>
                <div class="stat-label">@lang('crm::lang.total_proposals')</div>
            </div>

            <div class="stat-card purple">
                <div class="stat-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="stat-value">{{ $total_campaigns }}</div>
                <div class="stat-label">@lang('crm::lang.total_campaigns')</div>
            </div>

            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-value">{{ $accepted_proposals }}</div>
                <div class="stat-label">@lang('crm::lang.accepted_proposals')</div>
            </div>

            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-value">{{ $sent_campaigns }}</div>
                <div class="stat-label">@lang('crm::lang.sent_campaigns')</div>
            </div>
        </div>

        <!-- Main Dashboard Grid -->
        <div class="dashboard-grid">
            <div>
                <!-- Today's Follow-ups -->
                <div class="widget-card" style="margin-bottom: 1.5rem;">
                    <div class="widget-header">
                        <h3><i class="fas fa-calendar-day"></i> @lang('crm::lang.todays_followups')</h3>
                        <a href="{{ url('crm/schedules') }}" class="view-all">@lang('messages.view_all') <i class="fas fa-chevron-right"></i></a>
                    </div>
                    <div class="widget-body">
                        @if($todays_followups->count() > 0)
                            @foreach($todays_followups as $followup)
                                <div class="task-item">
                                    <div class="task-time">
                                        <div class="time">{{ $followup->start_datetime->format('h:i') }}</div>
                                        <div class="period">{{ $followup->start_datetime->format('A') }}</div>
                                    </div>
                                    <div class="task-info">
                                        <div class="task-title">{{ $followup->title }}</div>
                                        <div class="task-contact">{{ $followup->contact_name ?? '-' }}</div>
                                    </div>
                                    <span class="task-type {{ $followup->followup_type }}">
                                        {{ __('crm::lang.' . $followup->followup_type) }}
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="fas fa-calendar-check"></i>
                                <p>@lang('crm::lang.no_followups_today')</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pipeline Overview -->
                <div class="widget-card" style="margin-bottom: 1.5rem;">
                    <div class="widget-header">
                        <h3><i class="fas fa-funnel-dollar"></i> @lang('crm::lang.pipeline_overview')</h3>
                    </div>
                    <div class="widget-body">
                        @if($leads_by_stage->count() > 0)
                            @php
                                $max_count = $leads_by_stage->max('leads_count') ?: 1;
                            @endphp
                            <div class="pipeline-chart">
                                @foreach($leads_by_stage as $stage)
                                    @php
                                        $percentage = ($stage->leads_count / $max_count) * 100;
                                    @endphp
                                    <div class="pipeline-stage">
                                        <div class="stage-name">{{ $stage->name }}</div>
                                        <div class="stage-bar">
                                            <div class="bar-fill" style="width: {{ $percentage }}%; background-color: {{ $stage->color }};">
                                                @if($stage->leads_count > 0)
                                                    <span>{{ $stage->leads_count }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="stage-count">{{ $stage->leads_count }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-funnel-dollar"></i>
                                <p>@lang('crm::lang.no_pipeline_data')</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Leads -->
                <div class="widget-card">
                    <div class="widget-header">
                        <h3><i class="fas fa-users"></i> @lang('crm::lang.recent_leads')</h3>
                        <a href="{{ url('crm/leads') }}" class="view-all">@lang('messages.view_all') <i class="fas fa-chevron-right"></i></a>
                    </div>
                    <div class="widget-body">
                        @if($recent_leads->count() > 0)
                            @foreach($recent_leads as $lead)
                                <div class="lead-item">
                                    <div class="lead-avatar">
                                        {{ strtoupper(substr($lead->name, 0, 1)) }}
                                    </div>
                                    <div class="lead-info">
                                        <div class="lead-name">{{ $lead->name }}</div>
                                        <div class="lead-contact">{{ $lead->email ?? $lead->mobile ?? '-' }}</div>
                                    </div>
                                    @if($lead->lifeStage)
                                        <span class="lead-stage" style="background: {{ $lead->lifeStage->color }}20; color: {{ $lead->lifeStage->color }};">
                                            {{ $lead->lifeStage->name }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <p>@lang('crm::lang.no_leads_found')</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <!-- Conversion Rate Widget -->
                <div class="widget-card" style="margin-bottom: 1.5rem;">
                    <div class="widget-header">
                        <h3><i class="fas fa-chart-pie"></i> @lang('crm::lang.conversion_rate')</h3>
                    </div>
                    <div class="conversion-widget">
                        @php
                            $circumference = 2 * 3.14159 * 54;
                            $offset = $circumference - ($conversion_rate / 100) * $circumference;
                        @endphp
                        <div class="conversion-circle">
                            <svg width="140" height="140" viewBox="0 0 140 140">
                                <circle class="circle-bg" cx="70" cy="70" r="54"></circle>
                                <circle class="circle-progress" cx="70" cy="70" r="54"
                                    stroke-dasharray="{{ $circumference }}"
                                    stroke-dashoffset="{{ $offset }}"></circle>
                            </svg>
                            <div class="conversion-value">
                                <div class="value">{{ $conversion_rate }}%</div>
                                <div class="label">@lang('crm::lang.converted')</div>
                            </div>
                        </div>
                        <div class="conversion-stats">
                            <div class="stat">
                                <div class="stat-num">{{ $total_leads + $converted_leads }}</div>
                                <div class="stat-label">@lang('crm::lang.total')</div>
                            </div>
                            <div class="stat">
                                <div class="stat-num">{{ $converted_leads }}</div>
                                <div class="stat-label">@lang('crm::lang.converted')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leads Trend -->
                <div class="widget-card" style="margin-bottom: 1.5rem;">
                    <div class="widget-header">
                        <h3><i class="fas fa-chart-line"></i> @lang('crm::lang.leads_this_week')</h3>
                    </div>
                    <div class="widget-body">
                        @php
                            $max_trend = collect($leads_trend)->max('count') ?: 1;
                        @endphp
                        <div class="trend-chart">
                            @foreach($leads_trend as $day)
                                @php
                                    $height = ($day['count'] / $max_trend) * 80;
                                @endphp
                                <div class="trend-bar">
                                    <div class="bar" style="height: {{ max($height, 4) }}px;"></div>
                                    <div class="label">{{ $day['date'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="widget-card">
                    <div class="widget-header">
                        <h3><i class="fas fa-history"></i> @lang('crm::lang.recent_activity')</h3>
                    </div>
                    <div class="widget-body">
                        @if($recent_activities->count() > 0)
                            @foreach($recent_activities as $activity)
                                <div class="activity-item">
                                    <div class="activity-icon {{ $activity['color'] }}">
                                        <i class="{{ $activity['icon'] }}"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-title">{{ $activity['title'] }}</div>
                                        <div class="activity-desc">{{ $activity['description'] }}</div>
                                    </div>
                                    <div class="activity-time">{{ $activity['time']->diffForHumans() }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="fas fa-history"></i>
                                <p>@lang('crm::lang.no_recent_activity')</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Follow-ups -->
        <div class="widget-card">
            <div class="widget-header">
                <h3><i class="fas fa-calendar-alt"></i> @lang('crm::lang.upcoming_followups')</h3>
                <a href="{{ url('crm/schedules') }}" class="view-all">@lang('messages.view_all') <i class="fas fa-chevron-right"></i></a>
            </div>
            <div class="widget-body">
                @if($upcoming_schedules->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem;">
                        @foreach($upcoming_schedules as $schedule)
                            <div class="task-item">
                                <div class="task-time">
                                    <div class="time">{{ $schedule->start_datetime->format('M d') }}</div>
                                    <div class="period">{{ $schedule->start_datetime->format('h:i A') }}</div>
                                </div>
                                <div class="task-info">
                                    <div class="task-title">{{ $schedule->title }}</div>
                                    <div class="task-contact">{{ $schedule->contact_name ?? '-' }}</div>
                                </div>
                                <span class="task-type {{ $schedule->followup_type }}">
                                    {{ __('crm::lang.' . $schedule->followup_type) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-alt"></i>
                        <p>@lang('crm::lang.no_upcoming_followups')</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
