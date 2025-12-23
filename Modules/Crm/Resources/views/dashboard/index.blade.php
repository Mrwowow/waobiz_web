@extends('layouts.app')

@section('title', __('crm::lang.crm'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div class="tw-mt-4">
        <!-- Statistics Cards -->
        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 lg:tw-grid-cols-6 tw-gap-4 tw-mb-6">
            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-p-4 tw-border tw-border-gray-700/50">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.total_leads')</p>
                        <p class="tw-text-2xl tw-font-bold tw-text-white">{{ $total_leads }}</p>
                    </div>
                    <div class="tw-w-12 tw-h-12 tw-rounded-lg tw-bg-blue-500/20 tw-flex tw-items-center tw-justify-center">
                        <i class="fas fa-user-tie tw-text-blue-400 tw-text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-p-4 tw-border tw-border-gray-700/50">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.converted_leads')</p>
                        <p class="tw-text-2xl tw-font-bold tw-text-white">{{ $converted_leads }}</p>
                    </div>
                    <div class="tw-w-12 tw-h-12 tw-rounded-lg tw-bg-green-500/20 tw-flex tw-items-center tw-justify-center">
                        <i class="fas fa-user-check tw-text-green-400 tw-text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-p-4 tw-border tw-border-gray-700/50">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.upcoming_followups')</p>
                        <p class="tw-text-2xl tw-font-bold tw-text-white">{{ $upcoming_followups }}</p>
                    </div>
                    <div class="tw-w-12 tw-h-12 tw-rounded-lg tw-bg-orange-500/20 tw-flex tw-items-center tw-justify-center">
                        <i class="fas fa-calendar-check tw-text-orange-400 tw-text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-p-4 tw-border tw-border-gray-700/50">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.overdue_followups')</p>
                        <p class="tw-text-2xl tw-font-bold tw-text-white">{{ $overdue_followups }}</p>
                    </div>
                    <div class="tw-w-12 tw-h-12 tw-rounded-lg tw-bg-red-500/20 tw-flex tw-items-center tw-justify-center">
                        <i class="fas fa-exclamation-triangle tw-text-red-400 tw-text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-p-4 tw-border tw-border-gray-700/50">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.total_campaigns')</p>
                        <p class="tw-text-2xl tw-font-bold tw-text-white">{{ $total_campaigns }}</p>
                    </div>
                    <div class="tw-w-12 tw-h-12 tw-rounded-lg tw-bg-purple-500/20 tw-flex tw-items-center tw-justify-center">
                        <i class="fas fa-bullhorn tw-text-purple-400 tw-text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-p-4 tw-border tw-border-gray-700/50">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.sent_campaigns')</p>
                        <p class="tw-text-2xl tw-font-bold tw-text-white">{{ $sent_campaigns }}</p>
                    </div>
                    <div class="tw-w-12 tw-h-12 tw-rounded-lg tw-bg-teal-500/20 tw-flex tw-items-center tw-justify-center">
                        <i class="fas fa-paper-plane tw-text-teal-400 tw-text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-6">
            <!-- Recent Leads -->
            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
                <div class="tw-p-4 tw-border-b tw-border-gray-700/50">
                    <h3 class="tw-text-lg tw-font-semibold tw-text-white">@lang('crm::lang.recent_leads')</h3>
                </div>
                <div class="tw-p-4">
                    @if($recent_leads->count() > 0)
                        <div class="tw-space-y-3">
                            @foreach($recent_leads as $lead)
                                <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-bg-[#0f0f1a] tw-rounded-lg">
                                    <div>
                                        <p class="tw-text-white tw-font-medium">{{ $lead->name }}</p>
                                        <p class="tw-text-gray-400 tw-text-sm">{{ $lead->email ?? $lead->mobile ?? '-' }}</p>
                                    </div>
                                    <div class="tw-text-right">
                                        @if($lead->lifeStage)
                                            <span class="tw-px-2 tw-py-1 tw-rounded tw-text-xs tw-text-white" style="background-color: {{ $lead->lifeStage->color }}">
                                                {{ $lead->lifeStage->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="tw-text-gray-400 tw-text-center tw-py-4">@lang('crm::lang.no_leads_found')</p>
                    @endif
                </div>
            </div>

            <!-- Upcoming Follow-ups -->
            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
                <div class="tw-p-4 tw-border-b tw-border-gray-700/50">
                    <h3 class="tw-text-lg tw-font-semibold tw-text-white">@lang('crm::lang.upcoming_followups')</h3>
                </div>
                <div class="tw-p-4">
                    @if($upcoming_schedules->count() > 0)
                        <div class="tw-space-y-3">
                            @foreach($upcoming_schedules as $schedule)
                                <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-bg-[#0f0f1a] tw-rounded-lg">
                                    <div>
                                        <p class="tw-text-white tw-font-medium">{{ $schedule->title }}</p>
                                        <p class="tw-text-gray-400 tw-text-sm">{{ $schedule->contact_name }}</p>
                                    </div>
                                    <div class="tw-text-right">
                                        <p class="tw-text-orange-400 tw-text-sm">{{ $schedule->start_datetime->format('M d, Y H:i') }}</p>
                                        <span class="tw-px-2 tw-py-1 tw-rounded tw-text-xs tw-bg-blue-500/20 tw-text-blue-400">
                                            {{ __('crm::lang.' . $schedule->followup_type) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="tw-text-gray-400 tw-text-center tw-py-4">@lang('crm::lang.no_upcoming_followups')</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
