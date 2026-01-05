@extends('layouts.app')

@section('title', __('crm::lang.schedules'))

@section('css')
<style>
    .followup-stats {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .stat-card {
        flex: 1;
        background: linear-gradient(145deg, #1e1e36 0%, #252540 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .stat-icon.scheduled { background: rgba(59, 130, 246, 0.15); color: #60A5FA; }
    .stat-icon.open { background: rgba(245, 158, 11, 0.15); color: #FBBF24; }
    .stat-icon.completed { background: rgba(34, 197, 94, 0.15); color: #4ADE80; }
    .stat-icon.total { background: rgba(255, 149, 0, 0.15); color: #FF9500; }
    .stat-info h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        margin: 0;
        line-height: 1;
    }
    .stat-info p {
        color: #9ca3af;
        font-size: 0.75rem;
        margin: 0.25rem 0 0 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .filter-section {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    #schedule_modal .modal-content {
        background: #1a1a2e !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 8px !important;
        overflow: hidden;
    }
    #schedule_modal .modal-header,
    #schedule_modal .modal-footer {
        background: #1a1a2e !important;
    }
    #schedule_modal .modal-body {
        background: #1e1e36 !important;
    }

    /* CRM Dropdown Menu Styles */
    #schedules_table .dropdown-menu {
        background: #1e1e36 !important;
        border: 1px solid rgba(255,255,255,0.15) !important;
        border-radius: 8px !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.5) !important;
        padding: 8px 0 !important;
        min-width: 180px !important;
    }
    #schedules_table .dropdown-menu > li > a {
        padding: 10px 16px !important;
        color: #e5e7eb !important;
    }
    #schedules_table .dropdown-menu > li > a:hover,
    #schedules_table .dropdown-menu > li > a:focus {
        background: rgba(255, 149, 0, 0.15) !important;
        color: #FF9500 !important;
    }
    #schedules_table .dropdown-menu > li > a i {
        margin-right: 10px !important;
        width: 16px !important;
    }
    #schedules_table .dropdown-menu .divider {
        background: rgba(255,255,255,0.1) !important;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.schedules')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div style="margin-top: 1rem;">
        <!-- Stats Cards -->
        <div class="followup-stats">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info">
                    <h4 id="stat_total">0</h4>
                    <p>@lang('crm::lang.all_followups')</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon scheduled">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h4 id="stat_scheduled">0</h4>
                    <p>@lang('crm::lang.scheduled')</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon open">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="stat-info">
                    <h4 id="stat_open">0</h4>
                    <p>@lang('crm::lang.open')</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon completed">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h4 id="stat_completed">0</h4>
                    <p>@lang('crm::lang.completed')</p>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div style="background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.3);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-calendar-check" style="color: #FF9500;"></i>
                    @lang('crm::lang.schedules')
                </h3>
                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm" id="add_schedule">
                    <i class="fas fa-plus"></i> @lang('crm::lang.add_followup')
                </button>
            </div>

            <!-- Filters -->
            <div class="filter-section" style="margin: 1rem; background: rgba(255, 255, 255, 0.02); border-radius: 8px; padding: 1rem;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">@lang('crm::lang.filter_by_status')</label>
                            {!! Form::select('status_filter', ['' => __('messages.all'), 'scheduled' => __('crm::lang.scheduled'), 'open' => __('crm::lang.open'), 'completed' => __('crm::lang.completed'), 'cancelled' => __('crm::lang.cancelled')], null, ['class' => 'form-control select2', 'id' => 'status_filter', 'style' => 'width: 100%;']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">@lang('crm::lang.contact_type')</label>
                            {!! Form::select('contact_type_filter', ['' => __('messages.all'), 'lead' => __('crm::lang.lead'), 'customer' => __('crm::lang.customer'), 'supplier' => __('crm::lang.supplier')], null, ['class' => 'form-control select2', 'id' => 'contact_type_filter', 'style' => 'width: 100%;']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">@lang('crm::lang.filter_by_type')</label>
                            {!! Form::select('followup_type_filter', ['' => __('messages.all'), 'call' => __('crm::lang.call'), 'email' => __('crm::lang.email'), 'meeting' => __('crm::lang.meeting'), 'sms' => __('crm::lang.sms'), 'other' => __('crm::lang.other')], null, ['class' => 'form-control select2', 'id' => 'followup_type_filter', 'style' => 'width: 100%;']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">@lang('crm::lang.filter_by_assigned')</label>
                            {!! Form::select('assigned_to_filter', ['' => __('messages.all')] + $users->toArray(), null, ['class' => 'form-control select2', 'id' => 'assigned_to_filter', 'style' => 'width: 100%;']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive" style="padding: 0 1rem 1rem 1rem; overflow: visible;">
                <table class="table table-bordered table-striped" id="schedules_table" style="width: 100%;">
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
        <div class="modal-content" style="background: #1a1a2e; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; overflow: hidden;"></div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    // Initialize select2
    $('.select2').select2();

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
        ],
        drawCallback: function() {
            updateStats();
        }
    });

    // Update statistics
    function updateStats() {
        $.ajax({
            url: '{{ url("crm/schedules/stats") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#stat_total').text(response.total || 0);
                    $('#stat_scheduled').text(response.scheduled || 0);
                    $('#stat_open').text(response.open || 0);
                    $('#stat_completed').text(response.completed || 0);
                }
            }
        });
    }

    // Initial stats load
    updateStats();

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

    // View schedule
    $(document).on('click', '.view-schedule', function(e) {
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
        swal({
            title: '@lang("crm::lang.mark_complete")',
            text: '@lang("messages.are_you_sure")',
            icon: 'info',
            buttons: true,
        }).then((confirmed) => {
            if (confirmed) {
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

    // Reload table after modal close
    $('#schedule_modal').on('hidden.bs.modal', function() {
        schedules_table.ajax.reload();
    });

});
</script>
@endsection
