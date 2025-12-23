<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">@lang('crm::lang.add_contact_login')</h4>
</div>

{!! Form::open(['url' => url('crm/contacts-login'), 'method' => 'POST', 'id' => 'contact_login_form']) !!}

<div class="modal-body">
    <div class="form-group">
        {!! Form::label('contact_id', __('crm::lang.contact') . ':*') !!}
        {!! Form::select('contact_id', $contacts, null, ['class' => 'form-control select2', 'required', 'placeholder' => __('messages.please_select')]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('username', __('crm::lang.username') . ':*') !!}
        {!! Form::text('username', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', __('crm::lang.password') . ':*') !!}
        {!! Form::password('password', ['class' => 'form-control', 'required', 'minlength' => 6]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('name', __('crm::lang.name') . ':*') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', __('crm::lang.email') . ':') !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <div class="checkbox">
            <label>
                {!! Form::checkbox('is_active', 1, true) !!} @lang('crm::lang.active')
            </label>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="tw-dw-btn tw-dw-btn-ghost" data-dismiss="modal">@lang('messages.close')</button>
    <button type="submit" class="tw-dw-btn tw-dw-btn-primary">@lang('messages.save')</button>
</div>

{!! Form::close() !!}

<script>
$(document).ready(function() {
    $('.select2').select2();

    $('#contact_login_form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.msg);
                    $('#contact_login_modal').modal('hide');
                    $('#contacts_login_table').DataTable().ajax.reload();
                } else {
                    toastr.error(response.msg);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var firstError = Object.values(errors)[0][0];
                toastr.error(firstError);
            }
        });
    });
});
</script>
