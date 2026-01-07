@extends('layouts.app')

@section('title', __('crm::lang.lead_conversion'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.lead_conversion')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div style="margin-top: 1rem;">
        <!-- Stats Cards -->
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col-md-4">
                <div style="background: linear-gradient(145deg, #1e1e36 0%, #252540 100%); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 1rem 1.25rem; display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; background: rgba(255, 149, 0, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users" style="font-size: 1.25rem; color: #FF9500;"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0;">{{ $total_leads }}</h4>
                        <p style="color: #9ca3af; font-size: 0.75rem; margin: 0; text-transform: uppercase;">@lang('crm::lang.total_leads')</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background: linear-gradient(145deg, #1e1e36 0%, #252540 100%); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 1rem 1.25rem; display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; background: rgba(34, 197, 94, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-check" style="font-size: 1.25rem; color: #4ADE80;"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0;">{{ $converted_leads }}</h4>
                        <p style="color: #9ca3af; font-size: 0.75rem; margin: 0; text-transform: uppercase;">@lang('crm::lang.converted_leads')</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background: linear-gradient(145deg, #1e1e36 0%, #252540 100%); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 1rem 1.25rem; display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; background: rgba(59, 130, 246, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-percentage" style="font-size: 1.25rem; color: #60A5FA;"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0;">{{ $conversion_rate }}%</h4>
                        <p style="color: #9ca3af; font-size: 0.75rem; margin: 0; text-transform: uppercase;">@lang('crm::lang.conversion_rate')</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conversion by Source -->
        @if($conversion_by_source->count() > 0)
        <div style="background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08); margin-bottom: 1rem;">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                <h3 style="font-size: 1rem; font-weight: 600; color: #ffffff; margin: 0;">
                    <i class="fas fa-chart-pie" style="color: #FF9500;"></i> @lang('crm::lang.conversion_by_source')
                </h3>
            </div>
            <div style="padding: 1rem;">
                <div class="row">
                    @foreach($conversion_by_source as $source)
                    <div class="col-md-3" style="margin-bottom: 1rem;">
                        <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem;">
                            <div style="color: #fff; font-weight: 600; margin-bottom: 0.5rem;">
                                {{ $source->source ? $source->source->name : __('crm::lang.unknown_source') }}
                            </div>
                            <div style="display: flex; justify-content: space-between; color: #9ca3af; font-size: 0.875rem;">
                                <span>@lang('crm::lang.total'): {{ $source->total }}</span>
                                <span style="color: #4ADE80;">@lang('crm::lang.converted'): {{ $source->converted }}</span>
                            </div>
                            @php
                                $rate = $source->total > 0 ? round(($source->converted / $source->total) * 100, 1) : 0;
                            @endphp
                            <div style="background: rgba(255, 255, 255, 0.1); border-radius: 4px; height: 6px; margin-top: 0.5rem; overflow: hidden;">
                                <div style="background: linear-gradient(90deg, #FF9500, #FBBF24); height: 100%; width: {{ $rate }}%; border-radius: 4px;"></div>
                            </div>
                            <div style="color: #FF9500; font-size: 0.75rem; margin-top: 0.25rem;">{{ $rate }}% @lang('crm::lang.conversion_rate')</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Leads Table -->
        <div style="background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.3);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-chart-line" style="color: #4ADE80;"></i>
                    @lang('crm::lang.lead_conversion')
                </h3>
                <a href="{{ url('crm/reports') }}" class="tw-dw-btn tw-dw-btn-ghost tw-dw-btn-sm">
                    <i class="fas fa-arrow-left"></i> @lang('crm::lang.back_to_reports')
                </a>
            </div>

            <!-- Filters -->
            <div style="margin: 1rem; background: rgba(255, 255, 255, 0.02); border-radius: 8px; padding: 1rem;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase;">@lang('report.start_date')</label>
                            {!! Form::text('start_date', null, ['class' => 'form-control date_picker', 'id' => 'start_date', 'placeholder' => __('report.start_date')]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase;">@lang('report.end_date')</label>
                            {!! Form::text('end_date', null, ['class' => 'form-control date_picker', 'id' => 'end_date', 'placeholder' => __('report.end_date')]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase;">@lang('crm::lang.conversion_status')</label>
                            {!! Form::select('conversion_status', ['' => __('messages.all'), 'converted' => __('crm::lang.converted'), 'not_converted' => __('crm::lang.not_converted')], null, ['class' => 'form-control select2', 'id' => 'conversion_status']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase;">&nbsp;</label>
                            <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-block" id="filter_btn">
                                <i class="fas fa-filter"></i> @lang('report.filter')
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 0 1rem 1rem 1rem;">
                <table class="table table-bordered table-striped" id="lead_conversion_table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>@lang('crm::lang.name')</th>
                            <th>@lang('crm::lang.source')</th>
                            <th>@lang('crm::lang.life_stage')</th>
                            <th>@lang('crm::lang.status')</th>
                            <th>@lang('crm::lang.converted_at')</th>
                            <th>@lang('crm::lang.converted_by')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('.select2').select2();

    $('.date_picker').datetimepicker({
        format: moment_date_format,
        ignoreReadonly: true,
    });

    var table = $('#lead_conversion_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("crm/reports/lead-conversion") }}',
            data: function(d) {
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
                d.conversion_status = $('#conversion_status').val();
            }
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'source', name: 'source' },
            { data: 'life_stage', name: 'life_stage' },
            { data: 'status', name: 'status' },
            { data: 'converted_at', name: 'converted_at' },
            { data: 'converted_by', name: 'converted_by' }
        ]
    });

    $('#filter_btn').on('click', function() {
        table.ajax.reload();
    });
});
</script>
@endsection
