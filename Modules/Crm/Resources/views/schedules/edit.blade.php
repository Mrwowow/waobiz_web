<div class="modal-header" style="background: #1a1a2e; border-bottom: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px 8px 0 0;">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.8;">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="color: #fff; display: flex; align-items: center; gap: 10px;">
        <span style="color: #FF9500;">@lang('crm::lang.edit_followup')</span>
        <small style="color: #9ca3af; font-size: 0.75rem;">@lang('crm::lang.editing_followup')</small>
    </h4>
</div>

{!! Form::open(['url' => url('crm/schedules/' . $schedule->id), 'method' => 'PUT', 'id' => 'edit_schedule_form']) !!}

<div class="modal-body" style="background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%); padding: 1.5rem;">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('title', __('crm::lang.title') . ':*', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::text('title', $schedule->title, ['class' => 'form-control', 'required', 'placeholder' => __('crm::lang.enter_title')]) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('contact_type', __('crm::lang.customer_lead') . ':*', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::select('contact_type', ['lead' => __('crm::lang.lead'), 'customer' => __('crm::lang.customer'), 'supplier' => __('crm::lang.supplier')], $schedule->contact_type, ['class' => 'form-control select2', 'id' => 'edit_contact_type', 'required']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('status', __('crm::lang.status') . ':', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::select('status', ['scheduled' => __('crm::lang.scheduled'), 'open' => __('crm::lang.open'), 'completed' => __('crm::lang.completed'), 'cancelled' => __('crm::lang.cancelled')], $schedule->status, ['class' => 'form-control select2']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('start_datetime', __('crm::lang.start_datetime') . ':*', ['style' => 'color: #e5e7eb;']) !!}
                <div class="input-group">
                    {!! Form::text('start_datetime', @format_datetime($schedule->start_datetime), ['class' => 'form-control datetime_picker', 'required', 'placeholder' => __('crm::lang.select_datetime')]) !!}
                    <span class="input-group-addon" style="background: rgba(255, 149, 0, 0.1); border-color: rgba(255, 255, 255, 0.1); color: #FF9500;"><i class="fas fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('end_datetime', __('crm::lang.end_datetime') . ':', ['style' => 'color: #e5e7eb;']) !!}
                <div class="input-group">
                    {!! Form::text('end_datetime', $schedule->end_datetime ? @format_datetime($schedule->end_datetime) : null, ['class' => 'form-control datetime_picker', 'placeholder' => __('crm::lang.select_datetime')]) !!}
                    <span class="input-group-addon" style="background: rgba(255, 149, 0, 0.1); border-color: rgba(255, 255, 255, 0.1); color: #FF9500;"><i class="fas fa-calendar"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 {{ $schedule->contact_type == 'lead' ? '' : 'tw-hidden' }}" id="edit_lead_select_div">
            <div class="form-group">
                {!! Form::label('lead_id', __('crm::lang.lead') . ':', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::select('lead_id', $leads, $schedule->lead_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]) !!}
            </div>
        </div>
        <div class="col-md-6 {{ $schedule->contact_type != 'lead' ? '' : 'tw-hidden' }}" id="edit_contact_select_div">
            <div class="form-group">
                {!! Form::label('contact_id', __('crm::lang.contact') . ':', ['style' => 'color: #e5e7eb;']) !!}
                <select name="contact_id" id="edit_contact_id" class="form-control select2">
                    <option value="">@lang('messages.please_select')</option>
                    @if($schedule->contact_type == 'customer')
                        @foreach($customers as $id => $name)
                            <option value="{{ $id }}" {{ $schedule->contact_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    @elseif($schedule->contact_type == 'supplier')
                        @foreach($suppliers as $id => $name)
                            <option value="{{ $id }}" {{ $schedule->contact_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('description', __('crm::lang.description') . ':', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::textarea('description', $schedule->description, ['class' => 'form-control tinymce_editor', 'id' => 'edit_followup_description', 'rows' => 6]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('followup_type', __('crm::lang.followup_type') . ':*', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::select('followup_type', ['call' => __('crm::lang.call'), 'email' => __('crm::lang.email'), 'meeting' => __('crm::lang.meeting'), 'sms' => __('crm::lang.sms'), 'other' => __('crm::lang.other')], $schedule->followup_type, ['class' => 'form-control select2', 'required']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('assigned_to', __('crm::lang.assigned_to') . ':', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::select('assigned_to', $users, $schedule->assigned_to, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <div class="checkbox" style="margin-top: 8px;">
                    <label style="color: #e5e7eb; display: flex; align-items: center; gap: 8px;">
                        {!! Form::checkbox('send_notification', 1, $schedule->send_notification, ['style' => 'width: 18px; height: 18px;']) !!}
                        @lang('crm::lang.send_notification')
                        <i class="fas fa-info-circle" style="color: #FF9500;" title="@lang('crm::lang.send_notification_info')"></i>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('followup_category', __('crm::lang.followup_category') . ':', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::select('followup_category', ['one_time' => __('crm::lang.one_time'), 'recurring' => __('crm::lang.recurring'), 'invoice_based' => __('crm::lang.invoice_based')], $schedule->followup_category ?? 'one_time', ['class' => 'form-control select2', 'id' => 'edit_followup_category']) !!}
            </div>
        </div>
    </div>

    <!-- Invoice Based Options -->
    <div class="row {{ ($schedule->followup_category ?? '') == 'invoice_based' ? '' : 'tw-hidden' }}" id="edit_invoice_options" style="background: rgba(59, 130, 246, 0.05); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(59, 130, 246, 0.2);">
        <div class="col-md-12">
            <h5 style="color: #60A5FA; margin-bottom: 15px;"><i class="fas fa-file-invoice"></i> @lang('crm::lang.invoice_followup_settings')</h5>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('invoice_status', __('crm::lang.invoice_status') . ':', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::select('invoice_status', ['' => __('messages.please_select'), 'pending' => __('crm::lang.pending'), 'partial' => __('crm::lang.partial'), 'overdue' => __('crm::lang.overdue')], $schedule->invoice_status, ['class' => 'form-control select2']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('notes', __('crm::lang.notes') . ':', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::text('notes', $schedule->notes, ['class' => 'form-control', 'placeholder' => __('crm::lang.invoice_notes_placeholder')]) !!}
            </div>
        </div>
    </div>
</div>

<div class="modal-footer" style="background: #1a1a2e; border-top: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0 0 8px 8px;">
    <button type="button" class="tw-dw-btn tw-dw-btn-ghost" data-dismiss="modal">@lang('messages.close')</button>
    <button type="submit" class="tw-dw-btn tw-dw-btn-primary">@lang('messages.update')</button>
</div>

{!! Form::close() !!}

<script>
$(document).ready(function() {
    $('.select2').select2({
        dropdownParent: $('#schedule_modal')
    });

    $('.datetime_picker').datetimepicker({
        format: moment_date_format + ' HH:mm',
        ignoreReadonly: true,
    });

    // Initialize TinyMCE
    if (typeof tinymce !== 'undefined') {
        // Remove existing instance if any
        tinymce.remove('#edit_followup_description');

        tinymce.init({
            selector: '#edit_followup_description',
            height: 200,
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
            branding: false
        });
    }

    // Contact type change
    $('#edit_contact_type').on('change', function() {
        var type = $(this).val();
        if (type === 'lead') {
            $('#edit_lead_select_div').removeClass('tw-hidden');
            $('#edit_contact_select_div').addClass('tw-hidden');
        } else {
            $('#edit_lead_select_div').addClass('tw-hidden');
            $('#edit_contact_select_div').removeClass('tw-hidden');
            loadEditContacts(type);
        }
    });

    // Followup category change
    $('#edit_followup_category').on('change', function() {
        var category = $(this).val();
        if (category === 'invoice_based') {
            $('#edit_invoice_options').removeClass('tw-hidden');
        } else {
            $('#edit_invoice_options').addClass('tw-hidden');
        }
    });

    function loadEditContacts(type) {
        var customers = @json($customers);
        var suppliers = @json($suppliers);
        var contacts = type === 'customer' ? customers : suppliers;

        var options = '<option value="">@lang("messages.please_select")</option>';
        $.each(contacts, function(id, name) {
            options += '<option value="' + id + '">' + name + '</option>';
        });
        $('#edit_contact_id').html(options).trigger('change');
    }

    // Form submission
    $('#edit_schedule_form').on('submit', function(e) {
        e.preventDefault();

        // Update TinyMCE content
        if (typeof tinymce !== 'undefined' && tinymce.get('edit_followup_description')) {
            tinymce.get('edit_followup_description').save();
        }

        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.msg);
                    $('#schedule_modal').modal('hide');
                    if (typeof schedules_table !== 'undefined') {
                        schedules_table.ajax.reload();
                    }
                    if ($('#schedules_table').length) {
                        $('#schedules_table').DataTable().ajax.reload();
                    }
                } else {
                    toastr.error(response.msg);
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : '@lang("messages.something_went_wrong")';
                toastr.error(msg);
            }
        });
    });
});
</script>
