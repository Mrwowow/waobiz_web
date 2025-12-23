@extends('layouts.app')

@section('title', __('crm::lang.campaigns'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.campaigns')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div class="tw-mt-4">
        <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
            <div class="tw-p-4 tw-border-b tw-border-gray-700/50 tw-flex tw-justify-between tw-items-center">
                <h3 class="tw-text-lg tw-font-semibold tw-text-white">@lang('crm::lang.campaigns')</h3>
                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm" id="add_campaign">
                    <i class="fas fa-plus"></i> @lang('crm::lang.add_campaign')
                </button>
            </div>

            <!-- Filters -->
            <div class="tw-p-4 tw-border-b tw-border-gray-700/50">
                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                    <div>
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.campaign_type')</label>
                        {!! Form::select('campaign_type_filter', ['' => __('messages.all'), 'email' => 'Email', 'sms' => 'SMS'], null, ['class' => 'form-control select2', 'id' => 'campaign_type_filter']) !!}
                    </div>
                    <div>
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.status')</label>
                        {!! Form::select('status_filter', ['' => __('messages.all'), 'draft' => __('crm::lang.draft'), 'scheduled' => __('crm::lang.scheduled'), 'sent' => __('crm::lang.sent'), 'failed' => __('crm::lang.failed')], null, ['class' => 'form-control select2', 'id' => 'status_filter']) !!}
                    </div>
                </div>
            </div>

            <div class="tw-p-4">
                <table class="table table-bordered table-striped" id="campaigns_table">
                    <thead>
                        <tr>
                            <th>@lang('messages.action')</th>
                            <th>@lang('crm::lang.name')</th>
                            <th>@lang('crm::lang.campaign_type')</th>
                            <th>@lang('crm::lang.status')</th>
                            <th>@lang('crm::lang.created_by')</th>
                            <th>@lang('crm::lang.added_on')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="campaign_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"></div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var campaigns_table = $('#campaigns_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("crm/campaigns") }}',
            data: function(d) {
                d.campaign_type = $('#campaign_type_filter').val();
                d.status = $('#status_filter').val();
            }
        },
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'campaign_type', name: 'campaign_type' },
            { data: 'status', name: 'status' },
            { data: 'created_by', name: 'created_by' },
            { data: 'created_at', name: 'created_at' }
        ]
    });

    // Filter change handlers
    $('#campaign_type_filter, #status_filter').on('change', function() {
        campaigns_table.ajax.reload();
    });

    // Add campaign
    $('#add_campaign').on('click', function() {
        $.ajax({
            url: '{{ url("crm/campaigns/create") }}',
            method: 'GET',
            success: function(response) {
                $('#campaign_modal .modal-content').html(response);
                $('#campaign_modal').modal('show');
            }
        });
    });

    // View campaign
    $(document).on('click', '.view-campaign', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#campaign_modal .modal-content').html(response);
                $('#campaign_modal').modal('show');
            }
        });
    });

    // Edit campaign
    $(document).on('click', '.edit-campaign', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#campaign_modal .modal-content').html(response);
                $('#campaign_modal').modal('show');
            }
        });
    });

    // Send campaign
    $(document).on('click', '.send-campaign', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        swal({
            title: '@lang("crm::lang.send_notification")',
            text: '@lang("messages.are_you_sure")',
            icon: 'warning',
            buttons: true,
        }).then((confirmed) => {
            if (confirmed) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.msg);
                            campaigns_table.ajax.reload();
                        } else {
                            toastr.error(response.msg);
                        }
                    }
                });
            }
        });
    });

    // Delete campaign
    $(document).on('click', '.delete-campaign', function(e) {
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
                            campaigns_table.ajax.reload();
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
