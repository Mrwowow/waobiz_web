@extends('layouts.app')

@section('title', __('crm::lang.leads') . ' - ' . __('crm::lang.kanban_view'))

@section('css')
<style>
    .kanban-board {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 1rem;
        min-height: 500px;
    }
    .kanban-column {
        min-width: 280px;
        max-width: 280px;
        background: rgba(26, 26, 46, 0.8);
        border-radius: 0.5rem;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }
    .kanban-column-header {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid rgba(107, 114, 128, 0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .kanban-column-title {
        font-weight: 600;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .kanban-column-title .color-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    .kanban-column-count {
        background: rgba(255, 149, 0, 0.2);
        color: #FF9500;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .kanban-cards {
        padding: 0.5rem;
        min-height: 400px;
    }
    .kanban-card {
        background: rgba(37, 37, 64, 0.9);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 0.375rem;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        cursor: grab;
        transition: all 0.2s;
    }
    .kanban-card:hover {
        border-color: #FF9500;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
    }
    .kanban-card.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }
    .kanban-card-title {
        font-weight: 600;
        color: #fff;
        margin-bottom: 0.25rem;
    }
    .kanban-card-info {
        font-size: 0.75rem;
        color: #9CA3AF;
    }
    .kanban-card-info i {
        width: 14px;
    }
    .kanban-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid rgba(107, 114, 128, 0.2);
    }
    .kanban-card-source {
        font-size: 0.625rem;
        background: rgba(59, 130, 246, 0.2);
        color: #60A5FA;
        padding: 0.125rem 0.375rem;
        border-radius: 0.25rem;
    }
    .kanban-card-actions {
        display: flex;
        gap: 0.25rem;
    }
    .kanban-card-actions a {
        color: #9CA3AF;
        font-size: 0.75rem;
    }
    .kanban-card-actions a:hover {
        color: #FF9500;
    }
    .drop-zone-highlight {
        background: rgba(255, 149, 0, 0.1) !important;
        border: 2px dashed #FF9500 !important;
    }
    /* Override any white backgrounds */
    .kanban-board,
    .kanban-board * {
        background-color: transparent;
    }
    .kanban-column {
        background: rgba(26, 26, 46, 0.8) !important;
    }
    .kanban-card {
        background: rgba(37, 37, 64, 0.9) !important;
    }
    .empty-state-container {
        background: transparent !important;
    }
    /* CRM Card styling */
    .crm-card {
        background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%) !important;
    }
    .crm-card * {
        background-color: inherit;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.leads') - @lang('crm::lang.kanban_view')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div style="margin-top: 1rem;">
        <div class="crm-card" style="background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%) !important; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.3);">
            <div style="padding: 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #ffffff; margin: 0;">@lang('crm::lang.kanban_view')</h3>
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ url('crm/leads') }}" class="tw-dw-btn tw-dw-btn-ghost tw-dw-btn-sm">
                        <i class="fas fa-list"></i> @lang('crm::lang.list_view')
                    </a>
                    <a href="{{ url('crm/leads/create') }}" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm">
                        <i class="fas fa-plus"></i> @lang('crm::lang.add_lead')
                    </a>
                </div>
            </div>

            <div style="padding: 1rem;">
                <div class="kanban-board" id="kanban-board">
                    @foreach($life_stages as $stage)
                    <div class="kanban-column" data-stage-id="{{ $stage->id }}">
                        <div class="kanban-column-header">
                            <div class="kanban-column-title">
                                <span class="color-dot" style="background-color: {{ $stage->color }}"></span>
                                {{ $stage->name }}
                            </div>
                            <span class="kanban-column-count">
                                {{ isset($leads[$stage->id]) ? $leads[$stage->id]->count() : 0 }}
                            </span>
                        </div>
                        <div class="kanban-cards" data-stage-id="{{ $stage->id }}">
                            @if(isset($leads[$stage->id]))
                                @foreach($leads[$stage->id] as $lead)
                                <div class="kanban-card" draggable="true" data-lead-id="{{ $lead->id }}">
                                    <div class="kanban-card-title">{{ $lead->name }}</div>
                                    <div class="kanban-card-info">
                                        @if($lead->email)
                                        <div><i class="fas fa-envelope"></i> {{ $lead->email }}</div>
                                        @endif
                                        @if($lead->mobile)
                                        <div><i class="fas fa-phone"></i> {{ $lead->mobile }}</div>
                                        @endif
                                    </div>
                                    <div class="kanban-card-footer">
                                        @if($lead->source)
                                        <span class="kanban-card-source">{{ $lead->source->name }}</span>
                                        @else
                                        <span></span>
                                        @endif
                                        <div class="kanban-card-actions">
                                            <a href="{{ url('crm/leads/' . $lead->id . '/edit') }}" title="@lang('messages.edit')">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="convert-lead" data-href="{{ url('crm/leads/' . $lead->id . '/convert') }}" title="@lang('crm::lang.convert_to_customer')">
                                                <i class="fas fa-user-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @endforeach

                    @if($life_stages->isEmpty())
                    <div class="empty-state-container" style="width: 100%; display: flex; justify-content: center; align-items: center; padding: 3rem; background: transparent !important;">
                        <div style="text-align: center; padding: 2rem 3rem; background: rgba(255, 255, 255, 0.03); border: 1px dashed rgba(255, 149, 0, 0.3); border-radius: 16px;">
                            <i class="fas fa-flag" style="font-size: 3rem; color: #FF9500; margin-bottom: 1rem; display: block;"></i>
                            <p style="color: #9ca3af; margin-bottom: 1.5rem; font-size: 1rem;">@lang('crm::lang.no_life_stages_found')</p>
                            <a href="{{ url('crm/life-stages') }}" class="tw-dw-btn tw-dw-btn-primary">
                                <i class="fas fa-plus"></i> @lang('crm::lang.add_life_stage')
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    // Drag and drop functionality
    const cards = document.querySelectorAll('.kanban-card');
    const columns = document.querySelectorAll('.kanban-cards');

    cards.forEach(card => {
        card.addEventListener('dragstart', dragStart);
        card.addEventListener('dragend', dragEnd);
    });

    columns.forEach(column => {
        column.addEventListener('dragover', dragOver);
        column.addEventListener('dragenter', dragEnter);
        column.addEventListener('dragleave', dragLeave);
        column.addEventListener('drop', drop);
    });

    function dragStart(e) {
        e.target.classList.add('dragging');
        e.dataTransfer.setData('text/plain', e.target.dataset.leadId);
    }

    function dragEnd(e) {
        e.target.classList.remove('dragging');
    }

    function dragOver(e) {
        e.preventDefault();
    }

    function dragEnter(e) {
        e.preventDefault();
        e.currentTarget.classList.add('drop-zone-highlight');
    }

    function dragLeave(e) {
        e.currentTarget.classList.remove('drop-zone-highlight');
    }

    function drop(e) {
        e.preventDefault();
        e.currentTarget.classList.remove('drop-zone-highlight');

        const leadId = e.dataTransfer.getData('text/plain');
        const newStageId = e.currentTarget.dataset.stageId;
        const card = document.querySelector(`.kanban-card[data-lead-id="${leadId}"]`);

        if (card) {
            e.currentTarget.appendChild(card);
            updateLeadStage(leadId, newStageId);
        }
    }

    function updateLeadStage(leadId, stageId) {
        $.ajax({
            url: '{{ url("crm/leads") }}/' + leadId + '/update-stage',
            method: 'POST',
            data: {
                life_stage_id: stageId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.msg);
                    updateColumnCounts();
                } else {
                    toastr.error(response.msg);
                    location.reload();
                }
            },
            error: function() {
                toastr.error('@lang("messages.something_went_wrong")');
                location.reload();
            }
        });
    }

    function updateColumnCounts() {
        document.querySelectorAll('.kanban-column').forEach(column => {
            const stageId = column.dataset.stageId;
            const count = column.querySelectorAll('.kanban-card').length;
            column.querySelector('.kanban-column-count').textContent = count;
        });
    }

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
                            location.reload();
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
