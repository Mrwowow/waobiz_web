<div class="modal-header" style="background: #1a1a2e; border-bottom: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px 8px 0 0;">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.8;">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="color: #fff; display: flex; align-items: center; gap: 10px;">
        <span style="color: #FF9500;">@lang('crm::lang.add_proposal')</span>
        <small style="color: #9ca3af; font-size: 0.75rem;">@lang('crm::lang.create_new_proposal')</small>
    </h4>
</div>

{!! Form::open(['url' => url('crm/proposals'), 'method' => 'POST', 'id' => 'proposal_form', 'enctype' => 'multipart/form-data']) !!}

<div class="modal-body" style="background: #1e1e36; padding: 1.5rem;">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('lead_id', __('crm::lang.lead') . ':*', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::select('lead_id', $leads, null, ['class' => 'form-control select2', 'required', 'placeholder' => __('messages.please_select')]) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('template_id', __('crm::lang.template') . ':', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::select('template_id', $templates, null, ['class' => 'form-control select2', 'id' => 'template_select', 'placeholder' => __('messages.please_select')]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('subject', __('crm::lang.subject') . ':*', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::text('subject', null, ['class' => 'form-control', 'required', 'placeholder' => __('crm::lang.enter_subject')]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('body', __('crm::lang.body') . ':*', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::textarea('body', null, ['class' => 'form-control', 'id' => 'proposal_body', 'rows' => 8, 'required']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('status', __('crm::lang.status') . ':', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::select('status', ['draft' => __('crm::lang.draft'), 'sent' => __('crm::lang.sent')], 'draft', ['class' => 'form-control select2']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('attachments', __('crm::lang.attachments') . ':', ['style' => 'color: #e5e7eb;']) !!}
                {!! Form::file('attachments[]', ['class' => 'form-control', 'multiple', 'style' => 'background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: #e5e7eb;']) !!}
                <small style="color: #6b7280;">@lang('crm::lang.attachments_help')</small>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer" style="background: #1a1a2e; border-top: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0 0 8px 8px;">
    <button type="button" class="tw-dw-btn tw-dw-btn-ghost" data-dismiss="modal">@lang('messages.close')</button>
    <button type="submit" class="tw-dw-btn tw-dw-btn-primary">@lang('messages.save')</button>
</div>

{!! Form::close() !!}

<script>
$(document).ready(function() {
    $('.select2').select2({
        dropdownParent: $('#proposal_modal')
    });

    // Initialize TinyMCE
    if (typeof tinymce !== 'undefined') {
        tinymce.remove('#proposal_body');
        tinymce.init({
            selector: '#proposal_body',
            height: 300,
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

    // Template selection - load template content
    $('#template_select').on('change', function() {
        var templateId = $(this).val();
        if (templateId) {
            $.ajax({
                url: '{{ url("crm/proposals/get-template") }}/' + templateId,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('input[name="subject"]').val(response.template.subject);
                        if (typeof tinymce !== 'undefined' && tinymce.get('proposal_body')) {
                            tinymce.get('proposal_body').setContent(response.template.body || '');
                        } else {
                            $('#proposal_body').val(response.template.body);
                        }
                    }
                }
            });
        }
    });

    // Form submission
    $('#proposal_form').on('submit', function(e) {
        e.preventDefault();

        // Update TinyMCE content
        if (typeof tinymce !== 'undefined' && tinymce.get('proposal_body')) {
            tinymce.get('proposal_body').save();
        }

        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.msg);
                    $('#proposal_modal').modal('hide');
                    if ($('#proposals_table').length) {
                        $('#proposals_table').DataTable().ajax.reload();
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
