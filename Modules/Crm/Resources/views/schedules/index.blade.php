@extends('layouts.app')

@section('title', __('crm::lang.schedules'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.schedules')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div class="tw-mt-4">
        <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
            <div class="tw-p-4 tw-border-b tw-border-gray-700/50 tw-flex tw-justify-between tw-items-center">
                <h3 class="tw-text-lg tw-font-semibold tw-text-white">@lang('crm::lang.schedules')</h3>
                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm" id="add_schedule">
                    <i class="fas fa-plus"></i> @lang('crm::lang.add_followup')
                </button>
            </div>

            <!-- Filters -->
            <div class="tw-p-4 tw-border-b tw-border-gray-700/50">
                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-4 tw-gap-4">
                    <div>
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.status')</label>
                        {!! Form::select('status_filter', ['' => __('messages.all'), 'scheduled' => __('crm::lang.scheduled'), 'open' => __('crm::lang.open'), 'completed' => __('crm::lang.completed'), 'cancelled' => __('crm::lang.cancelled')], null, ['class' => 'form-control select2', 'id' => 'status_filter']) !!}
                    </div>
                    <div>
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.contact_type')</label>
                        {!! Form::select('contact_type_filter', ['' => __('messages.all'), 'lead' => __('crm::lang.lead'), 'customer' => __('crm::lang.customer'), 'supplier' => __('crm::lang.supplier')], null, ['class' => 'form-control select2', 'id' => 'contact_type_filter']) !!}
                    </div>
                    <div>
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.followup_type')</label>
                        {!! Form::select('followup_type_filter', ['' => __('messages.all'), 'call' => __('crm::lang.call'), 'email' => __('crm::lang.email'), 'meeting' => __('crm::lang.meeting'), 'sms' => __('crm::lang.sms'), 'other' => __('crm::lang.other')], null, ['class' => 'form-control select2', 'id' => 'followup_type_filter']) !!}
                    </div>
                    <div>
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.assigned_to')</label>
                        {!! Form::select('assigned_to_filter', ['' => __('messages.all')] + $users->toArray(), null, ['class' => 'form-control select2', 'id' => 'assigned_to_filter']) !!}
                    </div>
                </div>
            </div>

            <div class="tw-p-4">
                <table class="table table-bordered table-striped" id="schedules_table">
                    <thead>
                        <tr>
                            <th>@lang('messages.action')</th>
                            <th>@lang('crm::lang.title')</th>
                            <th>@lang('crm::lang.contact')</th>
                            <th>@lang('crm::lang.status')</th>
                            <th>@lang('crm::lang.followup_type')</th>
                            <th>@lang('crm::lang.start_datetime')</th>
                            <th>@lang('crm::lang.assigned_to')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="schedule_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"></div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var schedules_table = $('#schedules_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("crm/schedules") }}',
            data: function(d) {
                d.status = $('#status_filter').val();
                d.contact_type = $('#contact_type_filter').val();
                d.followup_type = $('#followup_type_filter').val();
                d.assigned_to = $('#assigned_to_filter').val();
            }
        },
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'contact_name', name: 'contact_name' },
            { data: 'status', name: 'status' },
            { data: 'followup_type', name: 'followup_type' },
            { data: 'start_datetime', name: 'start_datetime' },
            { data: 'assigned_to', name: 'assigned_to' }
        ]
    });

    // Filter change handlers
    $('#status_filter, #contact_type_filter, #followup_type_filter, #assigned_to_filter').on('change', function() {
        schedules_table.ajax.reload();
    });

    // Add schedule
    $('#add_schedule').on('click', function() {
        $.ajax({
            url: '{{ url("crm/schedules/create") }}',
            method: 'GET',
            success: function(response) {
                $('#schedule_modal .modal-content').html(response);
                $('#schedule_modal').modal('show');
            }
        });
    });

    // Edit schedule
    $(document).on('click', '.edit-schedule', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#schedule_modal .modal-content').html(response);
                $('#schedule_modal').modal('show');
            }
        });
    });

    // Complete schedule
    $(document).on('click', '.complete-schedule', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'POST',
            data: { status: 'completed', _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.msg);
                    schedules_table.ajax.reload();
                } else {
                    toastr.error(response.msg);
                }
            }
        });
    });

    // Delete schedule
    $(document).on('click', '.delete-schedule', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        swal({
            title: LANG.sure,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((confirmed) => {
            if (confirmed) {
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.msg);
                            schedules_table.ajax.reload();
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
