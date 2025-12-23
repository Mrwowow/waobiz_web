@extends('layouts.app')

@section('title', __('crm::lang.edit_lead'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.edit_lead')</span>
    </h1>
</section>

<section class="content">
    <div class="tw-bg-gradient-to-br tw-from-[#1a1a2e] tw-to-[#252540] tw-rounded-xl tw-border tw-border-gray-700/50">
        {!! Form::open(['url' => url('crm/leads/' . $lead->id), 'method' => 'PUT']) !!}

        <div class="tw-p-6">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('name', __('crm::lang.name') . ':*') !!}
                        {!! Form::text('name', $lead->name, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('email', __('crm::lang.email') . ':') !!}
                        {!! Form::email('email', $lead->email, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('mobile', __('crm::lang.mobile') . ':') !!}
                        {!! Form::text('mobile', $lead->mobile, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('alternate_number', __('crm::lang.alternate_number') . ':') !!}
                        {!! Form::text('alternate_number', $lead->alternate_number, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('tax_number', __('crm::lang.tax_number') . ':') !!}
                        {!! Form::text('tax_number', $lead->tax_number, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('source_id', __('crm::lang.source') . ':') !!}
                        {!! Form::select('source_id', $sources, $lead->source_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('life_stage_id', __('crm::lang.life_stage') . ':') !!}
                        {!! Form::select('life_stage_id', $life_stages, $lead->life_stage_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('assigned_to', __('crm::lang.assigned_to') . ':') !!}
                        {!! Form::select('assigned_to', $users, $lead->assigned_to, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]) !!}
                    </div>
                </div>
            </div>

            <hr class="tw-border-gray-700">

            <h4 class="tw-text-white tw-mb-4">@lang('crm::lang.address_info')</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('address', __('crm::lang.address') . ':') !!}
                        {!! Form::textarea('address', $lead->address, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('city', __('crm::lang.city') . ':') !!}
                        {!! Form::text('city', $lead->city, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('state', __('crm::lang.state') . ':') !!}
                        {!! Form::text('state', $lead->state, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('country', __('crm::lang.country') . ':') !!}
                        {!! Form::text('country', $lead->country, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('zip_code', __('crm::lang.zip_code') . ':') !!}
                        {!! Form::text('zip_code', $lead->zip_code, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <hr class="tw-border-gray-700">

            <h4 class="tw-text-white tw-mb-4">@lang('crm::lang.custom_fields')</h4>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('custom_field_1', __('crm::lang.custom_field_1') . ':') !!}
                        {!! Form::text('custom_field_1', $lead->custom_field_1, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('custom_field_2', __('crm::lang.custom_field_2') . ':') !!}
                        {!! Form::text('custom_field_2', $lead->custom_field_2, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('custom_field_3', __('crm::lang.custom_field_3') . ':') !!}
                        {!! Form::text('custom_field_3', $lead->custom_field_3, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('custom_field_4', __('crm::lang.custom_field_4') . ':') !!}
                        {!! Form::text('custom_field_4', $lead->custom_field_4, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('additional_info', __('crm::lang.additional_info') . ':') !!}
                        {!! Form::textarea('additional_info', $lead->additional_info, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="tw-p-4 tw-border-t tw-border-gray-700/50 tw-flex tw-justify-end tw-gap-2">
            <a href="{{ url('crm/leads') }}" class="tw-dw-btn tw-dw-btn-ghost">
                @lang('messages.cancel')
            </a>
            <button type="submit" class="tw-dw-btn tw-dw-btn-primary">
                @lang('messages.update')
            </button>
        </div>

        {!! Form::close() !!}
    </div>
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
@endsection
