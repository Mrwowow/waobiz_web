@extends('layouts.app')

@section('title', __('crm::lang.view_lead'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.view_lead')</span>
    </h1>
</section>

<section class="content">
    <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-4">
        <!-- Lead Info Card -->
        <div class="lg:tw-col-span-2">
            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
                <div class="tw-p-4 tw-border-b tw-border-gray-700/50 tw-flex tw-justify-between tw-items-center">
                    <h3 class="tw-text-lg tw-font-semibold tw-text-white">{{ $lead->name }}</h3>
                    <div class="tw-flex tw-gap-2">
                        <a href="{{ url('crm/leads/' . $lead->id . '/edit') }}" class="tw-dw-btn tw-dw-btn-ghost tw-dw-btn-sm">
                            <i class="fas fa-edit"></i> @lang('messages.edit')
                        </a>
                        @if(!$lead->isConverted())
                        <a href="#" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm convert-lead" data-href="{{ url('crm/leads/' . $lead->id . '/convert') }}">
                            <i class="fas fa-user-plus"></i> @lang('crm::lang.convert_to_customer')
                        </a>
                        @else
                        <span class="tw-dw-badge tw-dw-badge-success">@lang('crm::lang.converted')</span>
                        @endif
                    </div>
                </div>

                <div class="tw-p-4">
                    <div class="tw-grid tw-grid-cols-2 tw-gap-4">
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.contact_id')</label>
                            <p class="tw-text-white">{{ $lead->contact_id_prefix }}</p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.email')</label>
                            <p class="tw-text-white">{{ $lead->email ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.mobile')</label>
                            <p class="tw-text-white">{{ $lead->mobile ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.alternate_number')</label>
                            <p class="tw-text-white">{{ $lead->alternate_number ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.source')</label>
                            <p class="tw-text-white">{{ $lead->source ? $lead->source->name : '-' }}</p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.life_stage')</label>
                            <p class="tw-text-white">
                                @if($lead->lifeStage)
                                <span class="tw-dw-badge" style="background-color: {{ $lead->lifeStage->color }}; color: #fff;">{{ $lead->lifeStage->name }}</span>
                                @else
                                -
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.assigned_to')</label>
                            <p class="tw-text-white">{{ $lead->assignedTo ? $lead->assignedTo->user_full_name : '-' }}</p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.tax_number')</label>
                            <p class="tw-text-white">{{ $lead->tax_number ?: '-' }}</p>
                        </div>
                    </div>

                    <hr class="tw-border-gray-700 tw-my-4">

                    <h4 class="tw-text-white tw-font-semibold tw-mb-3">@lang('crm::lang.address_info')</h4>
                    <div class="tw-grid tw-grid-cols-2 tw-gap-4">
                        <div class="tw-col-span-2">
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.address')</label>
                            <p class="tw-text-white">{{ $lead->address ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.city')</label>
                            <p class="tw-text-white">{{ $lead->city ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.state')</label>
                            <p class="tw-text-white">{{ $lead->state ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.country')</label>
                            <p class="tw-text-white">{{ $lead->country ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.zip_code')</label>
                            <p class="tw-text-white">{{ $lead->zip_code ?: '-' }}</p>
                        </div>
                    </div>

                    @if($lead->additional_info)
                    <hr class="tw-border-gray-700 tw-my-4">
                    <h4 class="tw-text-white tw-font-semibold tw-mb-3">@lang('crm::lang.additional_info')</h4>
                    <p class="tw-text-gray-300">{{ $lead->additional_info }}</p>
                    @endif
                </div>

                <div class="tw-p-4 tw-border-t tw-border-gray-700/50">
                    <a href="{{ url('crm/leads') }}" class="tw-dw-btn tw-dw-btn-ghost">
                        <i class="fas fa-arrow-left"></i> @lang('crm::lang.back_to_leads')
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Meta Info -->
            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50 tw-mb-4">
                <div class="tw-p-4 tw-border-b tw-border-gray-700/50">
                    <h4 class="tw-text-white tw-font-semibold">@lang('crm::lang.meta_info')</h4>
                </div>
                <div class="tw-p-4">
                    <div class="tw-mb-3">
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.created_by')</label>
                        <p class="tw-text-white">{{ $lead->createdBy ? $lead->createdBy->user_full_name : '-' }}</p>
                    </div>
                    <div class="tw-mb-3">
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.added_on')</label>
                        <p class="tw-text-white">{{ \Carbon\Carbon::parse($lead->created_at)->format('M d, Y H:i') }}</p>
                    </div>
                    @if($lead->isConverted())
                    <div class="tw-mb-3">
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.converted_at')</label>
                        <p class="tw-text-white">{{ \Carbon\Carbon::parse($lead->converted_at)->format('M d, Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Follow-ups -->
            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50 tw-mb-4">
                <div class="tw-p-4 tw-border-b tw-border-gray-700/50">
                    <h4 class="tw-text-white tw-font-semibold">@lang('crm::lang.recent_followups')</h4>
                </div>
                <div class="tw-p-4">
                    @if($lead->schedules && $lead->schedules->count() > 0)
                        @foreach($lead->schedules->take(5) as $schedule)
                        <div class="tw-mb-3 tw-pb-3 tw-border-b tw-border-gray-700/50 last:tw-border-0">
                            <p class="tw-text-white tw-font-medium">{{ $schedule->title }}</p>
                            <p class="tw-text-gray-400 tw-text-sm">{{ \Carbon\Carbon::parse($schedule->start_datetime)->format('M d, Y H:i') }}</p>
                            <span class="tw-text-xs tw-px-2 tw-py-0.5 tw-rounded
                                @if($schedule->status == 'completed') tw-bg-green-500/20 tw-text-green-400
                                @elseif($schedule->status == 'scheduled') tw-bg-blue-500/20 tw-text-blue-400
                                @elseif($schedule->status == 'cancelled') tw-bg-red-500/20 tw-text-red-400
                                @else tw-bg-yellow-500/20 tw-text-yellow-400
                                @endif">
                                {{ __('crm::lang.' . $schedule->status) }}
                            </span>
                        </div>
                        @endforeach
                    @else
                        <p class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.no_followups')</p>
                    @endif
                </div>
            </div>

            <!-- Proposals -->
            <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
                <div class="tw-p-4 tw-border-b tw-border-gray-700/50">
                    <h4 class="tw-text-white tw-font-semibold">@lang('crm::lang.proposals')</h4>
                </div>
                <div class="tw-p-4">
                    @if($lead->proposals && $lead->proposals->count() > 0)
                        @foreach($lead->proposals as $proposal)
                        <div class="tw-mb-3 tw-pb-3 tw-border-b tw-border-gray-700/50 last:tw-border-0">
                            <p class="tw-text-white tw-font-medium">{{ $proposal->subject }}</p>
                            <p class="tw-text-gray-400 tw-text-sm">{{ \Carbon\Carbon::parse($proposal->created_at)->format('M d, Y') }}</p>
                        </div>
                        @endforeach
                    @else
                        <p class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.no_proposals')</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    // Convert lead to customer
    $(document).on('click', '.convert-lead', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        swal({
            title: '@lang("crm::lang.convert_to_customer_confirm")',
            icon: 'warning',
            buttons: true,
            dangerMode: false,
        }).then((confirmed) => {
            if (confirmed) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.msg);
                            location.reload();
                        } else {
                            toastr.error(response.msg);
                        }
                    }
                });
            }
        });
    });
});
</script>
@endsection
