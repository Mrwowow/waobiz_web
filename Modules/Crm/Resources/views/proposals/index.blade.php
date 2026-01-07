@extends('layouts.app')

@section('title', __('crm::lang.proposals'))

@section('css')
<style>
    #proposal_modal .modal-content {
        background: #1a1a2e !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 8px !important;
        overflow: hidden;
    }
    #proposal_modal .modal-header,
    #proposal_modal .modal-footer {
        background: #1a1a2e !important;
    }
    #proposal_modal .modal-body {
        background: #1e1e36 !important;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.proposals')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div style="margin-top: 1rem;">
        <div style="background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.3);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-file-alt" style="color: #FF9500;"></i>
                    @lang('crm::lang.proposals')
                </h3>
                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm" id="add_proposal">
                    <i class="fas fa-plus"></i> @lang('crm::lang.add_proposal')
                </button>
            </div>

            <!-- Filters -->
            <div style="margin: 1rem; background: rgba(255, 255, 255, 0.02); border-radius: 8px; padding: 1rem;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">@lang('crm::lang.status')</label>
                            {!! Form::select('status_filter', ['' => __('messages.all'), 'draft' => __('crm::lang.draft'), 'sent' => __('crm::lang.sent'), 'viewed' => __('crm::lang.viewed'), 'accepted' => __('crm::lang.accepted'), 'rejected' => __('crm::lang.rejected')], null, ['class' => 'form-control select2', 'id' => 'status_filter', 'style' => 'width: 100%;']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">@lang('crm::lang.lead')</label>
                            {!! Form::select('lead_filter', ['' => __('messages.all')] + $leads->toArray(), null, ['class' => 'form-control select2', 'id' => 'lead_filter', 'style' => 'width: 100%;']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 0 1rem 1rem 1rem;">
                <table class="table table-bordered table-striped" id="proposals_table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>@lang('messages.action')</th>
                            <th>@lang('crm::lang.subject')</th>
                            <th>@lang('crm::lang.lead')</th>
                            <th>@lang('crm::lang.status')</th>
                            <th>@lang('messages.created_at')</th>
                            <th>@lang('crm::lang.sent_at')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="proposal_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background: #1a1a2e; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; overflow: hidden;"></div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('.select2').select2();

    var proposals_table = $('#proposals_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("crm/proposals") }}',
            data: function(d) {
                d.status = $('#status_filter').val();
                d.lead_id = $('#lead_filter').val();
            }
        },
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'subject', name: 'subject' },
            { data: 'lead', name: 'lead' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'sent_at', name: 'sent_at' }
        ]
    });

    // Filter change handlers
    $('#status_filter, #lead_filter').on('change', function() {
        proposals_table.ajax.reload();
    });

    // Add proposal
    $('#add_proposal').on('click', function() {
        $.ajax({
            url: '{{ url("crm/proposals/create") }}',
            method: 'GET',
            success: function(response) {
                $('#proposal_modal .modal-content').html(response);
                $('#proposal_modal').modal('show');
            }
        });
    });

    // View proposal
    $(document).on('click', '.view-proposal', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#proposal_modal .modal-content').html(response);
                $('#proposal_modal').modal('show');
            }
        });
    });

    // Edit proposal
    $(document).on('click', '.edit-proposal', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#proposal_modal .modal-content').html(response);
                $('#proposal_modal').modal('show');
            }
        });
    });

    // Send proposal
    $(document).on('click', '.send-proposal', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        swal({
            title: '@lang("crm::lang.send_proposal")',
            text: '@lang("messages.are_you_sure")',
            icon: 'info',
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
                            proposals_table.ajax.reload();
                        } else {
                            toastr.error(response.msg);
                        }
                    }
                });
            }
        });
    });

    // Delete proposal
    $(document).on('click', '.delete-proposal', function(e) {
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
                            proposals_table.ajax.reload();
                        } else {
                            toastr.error(response.msg);
                        }
                    }
                });
            }
        });
    });

    // Reload table after modal close
    $('#proposal_modal').on('hidden.bs.modal', function() {
        proposals_table.ajax.reload();
    });
});
</script>
@endsection
