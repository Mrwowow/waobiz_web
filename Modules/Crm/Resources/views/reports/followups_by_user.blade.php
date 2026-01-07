@extends('layouts.app')

@section('title', __('crm::lang.followups_by_user'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.followups_by_user')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div style="margin-top: 1rem;">
        <div style="background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.3);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-user-clock" style="color: #FF9500;"></i>
                    @lang('crm::lang.followups_by_user')
                </h3>
                <a href="{{ url('crm/reports') }}" class="tw-dw-btn tw-dw-btn-ghost tw-dw-btn-sm">
                    <i class="fas fa-arrow-left"></i> @lang('crm::lang.back_to_reports')
                </a>
            </div>

            <!-- Filters -->
            <div style="margin: 1rem; background: rgba(255, 255, 255, 0.02); border-radius: 8px; padding: 1rem;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase;">@lang('report.start_date')</label>
                            {!! Form::text('start_date', null, ['class' => 'form-control date_picker', 'id' => 'start_date', 'placeholder' => __('report.start_date')]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase;">@lang('report.end_date')</label>
                            {!! Form::text('end_date', null, ['class' => 'form-control date_picker', 'id' => 'end_date', 'placeholder' => __('report.end_date')]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
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
                <table class="table table-bordered table-striped" id="followups_by_user_table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>@lang('crm::lang.assigned_to')</th>
                            <th>@lang('crm::lang.total_followups')</th>
                            <th>@lang('crm::lang.completed')</th>
                            <th>@lang('crm::lang.scheduled')</th>
                            <th>@lang('crm::lang.open')</th>
                            <th>@lang('crm::lang.cancelled')</th>
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
    $('.date_picker').datetimepicker({
        format: moment_date_format,
        ignoreReadonly: true,
    });

    var table = $('#followups_by_user_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("crm/reports/followups-by-user") }}',
            data: function(d) {
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            }
        },
        columns: [
            { data: 'assigned_to', name: 'assigned_to' },
            { data: 'total_followups', name: 'total_followups' },
            { data: 'completed', name: 'completed' },
            { data: 'scheduled', name: 'scheduled' },
            { data: 'open', name: 'open' },
            { data: 'cancelled', name: 'cancelled' }
        ]
    });

    $('#filter_btn').on('click', function() {
        table.ajax.reload();
    });
});
</script>
@endsection
