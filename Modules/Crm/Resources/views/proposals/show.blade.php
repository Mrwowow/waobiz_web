<div class="modal-header" style="background: #1a1a2e; border-bottom: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px 8px 0 0;">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.8;">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="color: #fff; display: flex; align-items: center; gap: 10px;">
        <span style="color: #FF9500;">@lang('crm::lang.proposal_details')</span>
        @php
            $status_colors = [
                'draft' => 'background: rgba(107, 114, 128, 0.2); color: #9CA3AF;',
                'sent' => 'background: rgba(59, 130, 246, 0.2); color: #60A5FA;',
                'viewed' => 'background: rgba(245, 158, 11, 0.2); color: #FBBF24;',
                'accepted' => 'background: rgba(34, 197, 94, 0.2); color: #4ADE80;',
                'rejected' => 'background: rgba(239, 68, 68, 0.2); color: #F87171;',
            ];
        @endphp
        <span style="font-size: 0.75rem; padding: 4px 10px; border-radius: 12px; {{ $status_colors[$proposal->status] ?? '' }}">
            {{ ucfirst($proposal->status) }}
        </span>
    </h4>
</div>

<div class="modal-body" style="background: #1e1e36; padding: 1.5rem;">
    <!-- Subject -->
    <div style="margin-bottom: 1.5rem;">
        <h3 style="color: #fff; font-size: 1.25rem; font-weight: 600; margin: 0;">{{ $proposal->subject }}</h3>
    </div>

    <!-- Info Grid -->
    <div class="row">
        <div class="col-md-6">
            <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-user"></i> @lang('crm::lang.lead')
                </div>
                <div style="color: #fff; font-weight: 500;">
                    @if($proposal->lead)
                        {{ $proposal->lead->name }}
                        @if($proposal->lead->email)
                            <br><small style="color: #9ca3af;">{{ $proposal->lead->email }}</small>
                        @endif
                    @else
                        <span style="color: #6b7280;">-</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-file-alt"></i> @lang('crm::lang.template')
                </div>
                <div style="color: #fff; font-weight: 500;">
                    {{ $proposal->template ? $proposal->template->name : '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-calendar"></i> @lang('messages.created_at')
                </div>
                <div style="color: #fff; font-weight: 500;">
                    {{ @format_datetime($proposal->created_at) }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
                    <i class="fas fa-paper-plane"></i> @lang('crm::lang.sent_at')
                </div>
                <div style="color: #fff; font-weight: 500;">
                    {{ $proposal->sent_at ? @format_datetime($proposal->sent_at) : '-' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Body Content -->
    <div style="background: rgba(255, 255, 255, 0.03); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
        <div style="color: #9ca3af; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem;">
            <i class="fas fa-align-left"></i> @lang('crm::lang.body')
        </div>
        <div style="color: #e5e7eb; line-height: 1.6; background: rgba(255,255,255,0.02); padding: 1rem; border-radius: 4px; max-height: 300px; overflow-y: auto;">
            {!! $proposal->body !!}
        </div>
    </div>

    <!-- Attachments -->
    @if($proposal->attachments && count($proposal->attachments) > 0)
    <div style="background: rgba(255, 149, 0, 0.05); border: 1px solid rgba(255, 149, 0, 0.2); border-radius: 8px; padding: 1rem;">
        <div style="color: #FF9500; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem;">
            <i class="fas fa-paperclip"></i> @lang('crm::lang.attachments')
        </div>
        <div>
            @foreach($proposal->attachments as $attachment)
                <a href="{{ asset('storage/' . $attachment) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255, 255, 255, 0.05); padding: 0.5rem 1rem; border-radius: 4px; margin-right: 0.5rem; margin-bottom: 0.5rem; color: #e5e7eb; text-decoration: none;">
                    <i class="fas fa-file" style="color: #FF9500;"></i>
                    {{ basename($attachment) }}
                    <i class="fas fa-download" style="color: #6b7280; font-size: 0.75rem;"></i>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Meta Info -->
    <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 1rem; margin-top: 1rem;">
        <div style="color: #6b7280; font-size: 0.75rem;">
            <i class="fas fa-user-plus"></i> @lang('crm::lang.created_by'):
            <span style="color: #9ca3af;">{{ $proposal->createdBy ? $proposal->createdBy->user_full_name : '-' }}</span>
        </div>
    </div>
</div>

<div class="modal-footer" style="background: #1a1a2e; border-top: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0 0 8px 8px;">
    <button type="button" class="tw-dw-btn tw-dw-btn-ghost" data-dismiss="modal">@lang('messages.close')</button>
    @if($proposal->status === 'draft')
    <a href="#" class="tw-dw-btn tw-dw-btn-info send-proposal-btn" data-href="{{ url('crm/proposals/send/' . $proposal->id) }}">
        <i class="fas fa-paper-plane"></i> @lang('crm::lang.send_proposal')
    </a>
    @endif
    <a href="#" class="tw-dw-btn tw-dw-btn-primary edit-proposal" data-href="{{ url('crm/proposals/' . $proposal->id . '/edit') }}">
        <i class="fas fa-edit"></i> @lang('messages.edit')
    </a>
</div>

<script>
$(document).ready(function() {
    // Edit button in show modal
    $('.edit-proposal').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#proposal_modal .modal-content').html(response);
            }
        });
    });

    // Send proposal button
    $('.send-proposal-btn').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        swal({
            title: '@lang("crm::lang.send_proposal")',
            text: '@lang("messages.are_you_sure")',
            icon: 'info',
            buttons: true,
        }).then((confirmed) => {
            if (confirmed) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.msg);
                            $('#proposal_modal').modal('hide');
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
