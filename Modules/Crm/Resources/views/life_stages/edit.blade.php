<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">@lang('crm::lang.edit_life_stage')</h4>
</div>

{!! Form::open(['url' => url('crm/life-stages/' . $life_stage->id), 'method' => 'PUT', 'id' => 'life_stage_form']) !!}

<div class="modal-body">
    <div class="form-group">
        {!! Form::label('name', __('crm::lang.name') . ':*') !!}
        {!! Form::text('name', $life_stage->name, ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('color', __('crm::lang.color') . ':') !!}
        {!! Form::color('color', $life_stage->color, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', __('crm::lang.description') . ':') !!}
        {!! Form::textarea('description', $life_stage->description, ['class' => 'form-control', 'rows' => 3]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('sort_order', __('crm::lang.sort_order') . ':') !!}
        {!! Form::number('sort_order', $life_stage->sort_order, ['class' => 'form-control', 'min' => 0]) !!}
    </div>

    <div class="form-group">
        <div class="checkbox">
            <label>
                {!! Form::checkbox('is_active', 1, $life_stage->is_active) !!} @lang('crm::lang.active')
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
    $('#life_stage_form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.msg);
                    $('#life_stage_modal').modal('hide');
                    $('#life_stages_table').DataTable().ajax.reload();
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
