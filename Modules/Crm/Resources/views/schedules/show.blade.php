<div class="modal-header" style="background: #1a1a2e; border-bottom: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px 8px 0 0;">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.8;">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="color: #fff; display: flex; align-items: center; gap: 10px;">
        <span style="color: #FF9500;">@lang('crm::lang.followup_details')</span>
        @php
            $status_colors = [
                'scheduled' => 'background: rgba(59, 130, 246, 0.2); color: #60A5FA;',
                'open' => 'background: rgba(245, 158, 11, 0.2); color: #FBBF24;',
                'completed' => 'background: rgba(34, 197, 94, 0.2); color: #4ADE80;',
                'cancelled' => 'background: rgba(239, 68, 68, 0.2); color: #F87171;',
            ];
        @endphp
        <span style="font-size: 0.75rem; padding: 4px 10px; border-radius: 12px; {{ $status_colors[$schedule->status] ?? '' }}">
            @lang('crm::lang.' . $schedule->status)
        </span>
    </h4>
</div>

<div class="modal-body" style="background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%); padding: 1.5rem;">
    <!-- Title Section -->
    <div style="margin-bottom: 1.5rem;">
        <h3 style="color: #fff; font-size: 1.25rem; font-weight: 600; margin: 0;">{{ $schedule->title }}</h3>
        <div style="color: #9ca3af; font-size: 0.875rem; margin-top: 0.25rem;">
            <i class="fas fa-{{ $schedule->followup_type == 'call' ? 'phone' : ($schedule->followup_type == 'email' ? 'envelope' : ($schedule->followup_type == 'meeting' ? 'users' : ($schedule->followup_type == 'sms' ? 'sms' : 'clipboard'))) }}" style="color: #FF9500;"></i>
            @lang('crm::lang.' . $schedule->followup_type)
        </div>
    </div>

    <!-- Info Grid -->
    <div class="row">
        <div class="col-md-6">
            <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-user"></i> @lang('crm::lang.contact_type')
                </div>
                <div style="color: #fff; font-weight: 500;">
                    @lang('crm::lang.' . $schedule->contact_type)
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-address-book"></i> @lang('crm::lang.contact_name')
                </div>
                <div style="color: #fff; font-weight: 500;">
                    @if($schedule->contact_type == 'lead' && $schedule->lead)
                        {{ $schedule->lead->name }}
                    @elseif($schedule->contact)
                        {{ $schedule->contact->name }}
                    @else
                        <span style="color: #6b7280;">-</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-calendar-alt"></i> @lang('crm::lang.start_datetime')
                </div>
                <div style="color: #fff; font-weight: 500;">
                    @if($schedule->start_datetime)
                        {{ @format_datetime($schedule->start_datetime) }}
                    @else
                        <span style="color: #6b7280;">-</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-calendar-check"></i> @lang('crm::lang.end_datetime')
                </div>
                <div style="color: #fff; font-weight: 500;">
                    @if($schedule->end_datetime)
                        {{ @format_datetime($schedule->end_datetime) }}
                    @else
                        <span style="color: #6b7280;">-</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-user-check"></i> @lang('crm::lang.assigned_to')
                </div>
                <div style="color: #fff; font-weight: 500;">
                    @if($schedule->assignedTo)
                        {{ $schedule->assignedTo->user_full_name }}
                    @else
                        <span style="color: #6b7280;">-</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-tag"></i> @lang('crm::lang.followup_category')
                </div>
                <div style="color: #fff; font-weight: 500;">
                    @lang('crm::lang.' . ($schedule->followup_category ?? 'one_time'))
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    @if($schedule->description)
    <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
        <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
            <i class="fas fa-align-left"></i> @lang('crm::lang.description')
        </div>
        <div style="color: #e5e7eb; line-height: 1.6;">
            {!! $schedule->description !!}
        </div>
    </div>
    @endif

    <!-- Invoice Based Info -->
    @if(($schedule->followup_category ?? '') == 'invoice_based')
    <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
        <div style="color: #60A5FA; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem;">
            <i class="fas fa-file-invoice"></i> @lang('crm::lang.invoice_followup_settings')
        </div>
        <div class="row">
            <div class="col-md-6">
                <div style="color: #9ca3af; font-size: 0.75rem;">@lang('crm::lang.invoice_status')</div>
                <div style="color: #fff;">
                    @if($schedule->invoice_status)
                        @lang('crm::lang.' . $schedule->invoice_status)
                    @else
                        <span style="color: #6b7280;">-</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div style="color: #9ca3af; font-size: 0.75rem;">@lang('crm::lang.notes')</div>
                <div style="color: #fff;">{{ $schedule->notes ?? '-' }}</div>
            </div>
        </div>
    </div>
    @endif

    <!-- Meta Info -->
    <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 1rem; margin-top: 1rem;">
        <div class="row">
            <div class="col-md-6">
                <div style="color: #6b7280; font-size: 0.75rem;">
                    <i class="fas fa-user-plus"></i> @lang('crm::lang.created_by'):
                    <span style="color: #9ca3af;">{{ $schedule->createdBy ? $schedule->createdBy->user_full_name : '-' }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div style="color: #6b7280; font-size: 0.75rem;">
                    <i class="fas fa-clock"></i> @lang('messages.created_at'):
                    <span style="color: #9ca3af;">{{ @format_datetime($schedule->created_at) }}</span>
                </div>
            </div>
        </div>
        @if($schedule->send_notification)
        <div style="margin-top: 0.5rem;">
            <span style="background: rgba(255, 149, 0, 0.1); color: #FF9500; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem;">
                <i class="fas fa-bell"></i> @lang('crm::lang.notification_enabled')
            </span>
        </div>
        @endif
    </div>
</div>

<div class="modal-footer" style="background: #1a1a2e; border-top: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0 0 8px 8px;">
    <button type="button" class="tw-dw-btn tw-dw-btn-ghost" data-dismiss="modal">@lang('messages.close')</button>
    <a href="#" class="tw-dw-btn tw-dw-btn-primary edit-schedule" data-href="{{ url('crm/schedules/' . $schedule->id . '/edit') }}">
        <i class="fas fa-edit"></i> @lang('messages.edit')
    </a>
</div>

<script>
$(document).ready(function() {
    // Edit button in show modal
    $('.edit-schedule').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#schedule_modal .modal-content').html(response);
            }
        });
    });
});
</script>
