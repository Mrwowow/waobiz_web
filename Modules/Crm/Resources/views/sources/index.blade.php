@extends('layouts.app')

@section('title', __('crm::lang.sources'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.sources')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div class="tw-mt-4">
        <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
            <div class="tw-p-4 tw-border-b tw-border-gray-700/50 tw-flex tw-justify-between tw-items-center">
                <h3 class="tw-text-lg tw-font-semibold tw-text-white">@lang('crm::lang.sources')</h3>
                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm" id="add_source">
                    <i class="fas fa-plus"></i> @lang('crm::lang.add_source')
                </button>
            </div>

            <div class="tw-p-4">
                <table class="table table-bordered table-striped" id="sources_table">
                    <thead>
                        <tr>
                            <th>@lang('messages.action')</th>
                            <th>@lang('crm::lang.name')</th>
                            <th>@lang('crm::lang.description')</th>
                            <th>@lang('crm::lang.sort_order')</th>
                            <th>@lang('crm::lang.status')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="source_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var sources_table = $('#sources_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url("crm/sources") }}',
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'sort_order', name: 'sort_order' },
            { data: 'is_active', name: 'is_active' }
        ]
    });

    // Add source
    $('#add_source').on('click', function() {
        $.ajax({
            url: '{{ url("crm/sources/create") }}',
            method: 'GET',
            success: function(response) {
                $('#source_modal .modal-content').html(response);
                $('#source_modal').modal('show');
            }
        });
    });

    // Edit source
    $(document).on('click', '.edit-source', function() {
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#source_modal .modal-content').html(response);
                $('#source_modal').modal('show');
            }
        });
    });

    // Delete source
    $(document).on('click', '.delete-source', function() {
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
                            sources_table.ajax.reload();
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
