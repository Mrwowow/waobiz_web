@extends('layouts.app')

@section('title', __('crm::lang.life_stages'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.life_stages')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div class="tw-mt-4">
        <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
            <div class="tw-p-4 tw-border-b tw-border-gray-700/50 tw-flex tw-justify-between tw-items-center">
                <h3 class="tw-text-lg tw-font-semibold tw-text-white">@lang('crm::lang.life_stages')</h3>
                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm" id="add_life_stage">
                    <i class="fas fa-plus"></i> @lang('crm::lang.add_life_stage')
                </button>
            </div>

            <div class="tw-p-4">
                <table class="table table-bordered table-striped" id="life_stages_table">
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

<div class="modal fade" id="life_stage_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var life_stages_table = $('#life_stages_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url("crm/life-stages") }}',
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'sort_order', name: 'sort_order' },
            { data: 'is_active', name: 'is_active' }
        ]
    });

    // Add life stage
    $('#add_life_stage').on('click', function() {
        $.ajax({
            url: '{{ url("crm/life-stages/create") }}',
            method: 'GET',
            success: function(response) {
                $('#life_stage_modal .modal-content').html(response);
                $('#life_stage_modal').modal('show');
            }
        });
    });

    // Edit life stage
    $(document).on('click', '.edit-life-stage', function() {
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#life_stage_modal .modal-content').html(response);
                $('#life_stage_modal').modal('show');
            }
        });
    });

    // Delete life stage
    $(document).on('click', '.delete-life-stage', function() {
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
                            life_stages_table.ajax.reload();
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
