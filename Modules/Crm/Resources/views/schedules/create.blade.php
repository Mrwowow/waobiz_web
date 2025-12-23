<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">@lang('crm::lang.add_followup')</h4>
</div>

{!! Form::open(['url' => url('crm/schedules'), 'method' => 'POST', 'id' => 'schedule_form']) !!}

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('title', __('crm::lang.title') . ':*') !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('contact_type', __('crm::lang.contact_type') . ':*') !!}
                {!! Form::select('contact_type', ['lead' => __('crm::lang.lead'), 'customer' => __('crm::lang.customer'), 'supplier' => __('crm::lang.supplier')], 'lead', ['class' => 'form-control select2', 'id' => 'contact_type', 'required']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6" id="lead_select_div">
            <div class="form-group">
                {!! Form::label('lead_id', __('crm::lang.lead') . ':') !!}
                {!! Form::select('lead_id', $leads, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]) !!}
            </div>
        </div>
        <div class="col-md-6 tw-hidden" id="contact_select_div">
            <div class="form-group">
                {!! Form::label('contact_id', __('crm::lang.contact') . ':') !!}
                <select name="contact_id" id="contact_id" class="form-control select2">
                    <option value="">@lang('messages.please_select')</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('status', __('crm::lang.status') . ':') !!}
                {!! Form::select('status', ['scheduled' => __('crm::lang.scheduled'), 'open' => __('crm::lang.open'), 'completed' => __('crm::lang.completed'), 'cancelled' => __('crm::lang.cancelled')], 'scheduled', ['class' => 'form-control select2']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('start_datetime', __('crm::lang.start_datetime') . ':*') !!}
                <div class="input-group">
                    {!! Form::text('start_datetime', null, ['class' => 'form-control datetime_picker', 'required']) !!}
                    <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('end_datetime', __('crm::lang.end_datetime') . ':') !!}
                <div class="input-group">
                    {!! Form::text('end_datetime', null, ['class' => 'form-control datetime_picker']) !!}
                    <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('followup_type', __('crm::lang.followup_type') . ':*') !!}
                {!! Form::select('followup_type', ['call' => __('crm::lang.call'), 'email' => __('crm::lang.email'), 'meeting' => __('crm::lang.meeting'), 'sms' => __('crm::lang.sms'), 'other' => __('crm::lang.other')], 'call', ['class' => 'form-control select2', 'required']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('assigned_to', __('crm::lang.assigned_to') . ':') !!}
                {!! Form::select('assigned_to', $users, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('description', __('crm::lang.description') . ':') !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('send_notification', 1, false) !!} @lang('crm::lang.send_notification')
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('is_recurring', 1, false, ['id' => 'is_recurring']) !!} @lang('crm::lang.is_recurring')
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row tw-hidden" id="recurring_options">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('recurrence_type', __('crm::lang.recurrence_type') . ':') !!}
                {!! Form::select('recurrence_type', ['daily' => __('crm::lang.daily'), 'weekly' => __('crm::lang.weekly'), 'monthly' => __('crm::lang.monthly'), 'yearly' => __('crm::lang.yearly')], null, ['class' => 'form-control select2']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('recurrence_interval', __('crm::lang.recurrence_interval') . ':') !!}
                {!! Form::number('recurrence_interval', 1, ['class' => 'form-control', 'min' => 1]) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('recurrence_end_date', __('crm::lang.recurrence_end_date') . ':') !!}
                <div class="input-group">
                    {!! Form::text('recurrence_end_date', null, ['class' => 'form-control date_picker']) !!}
                    <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                </div>
            </div>
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
    $('.datetime_picker').datetimepicker({
        format: moment_date_format + ' HH:mm',
        ignoreReadonly: true,
    });
    $('.date_picker').datetimepicker({
        format: moment_date_format,
        ignoreReadonly: true,
    });

    // Contact type change
    $('#contact_type').on('change', function() {
        var type = $(this).val();
        if (type === 'lead') {
            $('#lead_select_div').removeClass('tw-hidden');
            $('#contact_select_div').addClass('tw-hidden');
        } else {
            $('#lead_select_div').addClass('tw-hidden');
            $('#contact_select_div').removeClass('tw-hidden');
            // Load contacts based on type
            loadContacts(type);
        }
    });

    // Recurring toggle
    $('#is_recurring').on('change', function() {
        if ($(this).is(':checked')) {
            $('#recurring_options').removeClass('tw-hidden');
        } else {
            $('#recurring_options').addClass('tw-hidden');
        }
    });

    function loadContacts(type) {
        var customers = @json($customers);
        var suppliers = @json($suppliers);
        var contacts = type === 'customer' ? customers : suppliers;

        var options = '<option value="">@lang("messages.please_select")</option>';
        $.each(contacts, function(id, name) {
            options += '<option value="' + id + '">' + name + '</option>';
        });
        $('#contact_id').html(options).trigger('change');
    }

    // Form submission
    $('#schedule_form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.msg);
                    $('#schedule_modal').modal('hide');
                    $('#schedules_table').DataTable().ajax.reload();
                } else {
                    toastr.error(response.msg);
                }
            },
            error: function(xhr) {
                toastr.error('Something went wrong');
            }
        });
    });
});
</script>
