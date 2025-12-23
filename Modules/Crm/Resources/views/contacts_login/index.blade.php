@extends('layouts.app')

@section('title', __('crm::lang.contacts_login'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.contacts_login')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div class="tw-mt-4">
        <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
            <div class="tw-p-4 tw-border-b tw-border-gray-700/50 tw-flex tw-justify-between tw-items-center">
                <div>
                    <h3 class="tw-text-lg tw-font-semibold tw-text-white">@lang('crm::lang.contacts_login')</h3>
                    <p class="tw-text-gray-400 tw-text-sm tw-mt-1">
                        Add logins for customers & suppliers. They can view their purchases, sales, payments, and ledger.
                    </p>
                </div>
                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm" id="add_contact_login">
                    <i class="fas fa-plus"></i> @lang('crm::lang.add_contact_login')
                </button>
            </div>

            <!-- Filters -->
            <div class="tw-p-4 tw-border-b tw-border-gray-700/50">
                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                    <div>
                        <label class="tw-text-gray-400 tw-text-sm">@lang('crm::lang.contact')</label>
                        {!! Form::select('contact_filter', ['' => __('messages.all')] + $contacts->toArray(), null, ['class' => 'form-control select2', 'id' => 'contact_filter']) !!}
                    </div>
                </div>
            </div>

            <div class="tw-p-4">
                <table class="table table-bordered table-striped" id="contacts_login_table">
                    <thead>
                        <tr>
                            <th>@lang('messages.action')</th>
                            <th>@lang('crm::lang.contact')</th>
                            <th>@lang('crm::lang.username')</th>
                            <th>@lang('crm::lang.name')</th>
                            <th>@lang('crm::lang.email')</th>
                            <th>@lang('crm::lang.status')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="contact_login_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var contacts_login_table = $('#contacts_login_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("crm/contacts-login") }}',
            data: function(d) {
                d.contact_id = $('#contact_filter').val();
            }
        },
        columns: [
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'contact', name: 'contact' },
            { data: 'username', name: 'username' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'is_active', name: 'is_active' }
        ]
    });

    // Filter change handlers
    $('#contact_filter').on('change', function() {
        contacts_login_table.ajax.reload();
    });

    // Add contact login
    $('#add_contact_login').on('click', function() {
        $.ajax({
            url: '{{ url("crm/contacts-login/create") }}',
            method: 'GET',
            success: function(response) {
                $('#contact_login_modal .modal-content').html(response);
                $('#contact_login_modal').modal('show');
            }
        });
    });

    // Edit contact login
    $(document).on('click', '.edit-contact-login', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#contact_login_modal .modal-content').html(response);
                $('#contact_login_modal').modal('show');
            }
        });
    });

    // Delete contact login
    $(document).on('click', '.delete-contact-login', function(e) {
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
                            contacts_login_table.ajax.reload();
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
