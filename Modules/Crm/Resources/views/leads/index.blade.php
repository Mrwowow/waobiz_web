@extends('layouts.app')

@section('title', __('crm::lang.leads'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.leads')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div class="tw-mt-4">
        <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
            <div class="tw-p-4 tw-border-b tw-border-gray-700/50 tw-flex tw-justify-between tw-items-center">
                <h3 class="tw-text-lg tw-font-semibold tw-text-white">@lang('crm::lang.leads')</h3>
                <div class="tw-flex tw-gap-2">
                    <a href="{{ url('crm/leads-kanban') }}" class="tw-dw-btn tw-dw-btn-ghost tw-dw-btn-sm">
                        <i class="fas fa-columns"></i> @lang('crm::lang.kanban_view')
                    </a>
                    <a href="{{ url('crm/leads/create') }}" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm">
                        <i class="fas fa-plus"></i> @lang('crm::lang.add_lead')
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="tw-p-4 tw-border-b tw-border-gray-700/50">
                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-4">
                    <div>
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.source')</label>
                        {!! Form::select('source_filter', ['' => __('messages.all')] + $sources->toArray(), null, ['class' => 'form-control select2', 'id' => 'source_filter']) !!}
                    </div>
                    <div>
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.life_stage')</label>
                        {!! Form::select('life_stage_filter', ['' => __('messages.all')] + $life_stages->toArray(), null, ['class' => 'form-control select2', 'id' => 'life_stage_filter']) !!}
                    </div>
                    <div>
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.assigned_to')</label>
                        {!! Form::select('assigned_to_filter', ['' => __('messages.all')] + $users->toArray(), null, ['class' => 'form-control select2', 'id' => 'assigned_to_filter']) !!}
                    </div>
                </div>
            </div>

            <div class="tw-p-4">
                <table class="table table-bordered table-striped" id="leads_table">
                    <thead>
                        <tr>
                            <th>@lang('messages.action')</th>
                            <th>@lang('crm::lang.contact_id')</th>
                            <th>@lang('crm::lang.name')</th>
                            <th>@lang('crm::lang.email')</th>
                            <th>@lang('crm::lang.source')</th>
                            <th>@lang('crm::lang.life_stage')</th>
                            <th>@lang('crm::lang.mobile')</th>
                            <th>@lang('crm::lang.assigned_to')</th>
                            <th>@lang('crm::lang.added_on')</th>
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
    var leads_table = $('#leads_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("crm/leads") }}',
            data: function(d) {
                d.source_id = $('#source_filter').val();
                d.life_stage_id = $('#life_stage_filter').val();
                d.assigned_to = $('#assigned_to_filter').val();
            }
        },
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'contact_id_prefix', name: 'contact_id_prefix' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'source', name: 'source' },
            { data: 'life_stage', name: 'life_stage' },
            { data: 'mobile', name: 'mobile' },
            { data: 'assigned_to', name: 'assigned_to' },
            { data: 'created_at', name: 'created_at' }
        ]
    });

    // Filter change handlers
    $('#source_filter, #life_stage_filter, #assigned_to_filter').on('change', function() {
        leads_table.ajax.reload();
    });

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
                            leads_table.ajax.reload();
                        } else {
                            toastr.error(response.msg);
                        }
                    }
                });
            }
        });
    });

    // Delete lead
    $(document).on('click', '.delete-lead', function(e) {
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
                            leads_table.ajax.reload();
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
