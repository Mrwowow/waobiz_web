<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">@lang('crm::lang.edit_source')</h4>
</div>

{!! Form::open(['url' => url('crm/sources/' . $source->id), 'method' => 'PUT', 'id' => 'source_form']) !!}

<div class="modal-body">
    <div class="form-group">
        {!! Form::label('name', __('crm::lang.name') . ':*') !!}
        {!! Form::text('name', $source->name, ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', __('crm::lang.description') . ':') !!}
        {!! Form::textarea('description', $source->description, ['class' => 'form-control', 'rows' => 3]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('sort_order', __('crm::lang.sort_order') . ':') !!}
        {!! Form::number('sort_order', $source->sort_order, ['class' => 'form-control', 'min' => 0]) !!}
    </div>

    <div class="form-group">
        <div class="checkbox">
            <label>
                {!! Form::checkbox('is_active', 1, $source->is_active) !!} @lang('crm::lang.active')
            </label>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="tw-dw-btn tw-dw-btn-ghost" data-dismiss="modal">@lang('messages.close')</button>
    <button type="submit" class="tw-dw-btn tw-dw-btn-primary">@lang('messages.update')</button>
</div>

{!! Form::close() !!}

<script>
$(document).ready(function() {
    $('#source_form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.msg);
                    $('#source_modal').modal('hide');
                    $('#sources_table').DataTable().ajax.reload();
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
