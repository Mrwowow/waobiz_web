@extends('layouts.app')

@section('title', __('crm::lang.reports'))

@section('content')
<section class="content-header">
    <h1>
        <span class="tw-text-xl tw-font-bold tw-text-white">@lang('crm::lang.crm')</span>
        <small class="tw-text-gray-400">@lang('crm::lang.reports')</small>
    </h1>
</section>

<section class="content">
    @include('crm::layouts.nav')

    <div style="margin-top: 1rem;">
        <div class="row">
            <!-- Follow-ups by User -->
            <div class="col-md-4">
                <a href="{{ url('crm/reports/followups-by-user') }}" style="text-decoration: none;">
                    <div style="background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08); padding: 1.5rem; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.borderColor='#FF9500'" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 60px; height: 60px; background: rgba(255, 149, 0, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-clock" style="font-size: 1.5rem; color: #FF9500;"></i>
                            </div>
                            <div>
                                <h4 style="color: #fff; font-size: 1.125rem; font-weight: 600; margin: 0;">@lang('crm::lang.followups_by_user')</h4>
                                <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.25rem 0 0 0;">@lang('crm::lang.followups_by_user_desc')</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Follow-ups by Contacts -->
            <div class="col-md-4">
                <a href="{{ url('crm/reports/followups-by-contacts') }}" style="text-decoration: none;">
                    <div style="background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08); padding: 1.5rem; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.borderColor='#60A5FA'" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 60px; height: 60px; background: rgba(59, 130, 246, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-address-book" style="font-size: 1.5rem; color: #60A5FA;"></i>
                            </div>
                            <div>
                                <h4 style="color: #fff; font-size: 1.125rem; font-weight: 600; margin: 0;">@lang('crm::lang.followups_by_contacts')</h4>
                                <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.25rem 0 0 0;">@lang('crm::lang.followups_by_contacts_desc')</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Lead Conversion -->
            <div class="col-md-4">
                <a href="{{ url('crm/reports/lead-conversion') }}" style="text-decoration: none;">
                    <div style="background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08); padding: 1.5rem; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.borderColor='#4ADE80'" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 60px; height: 60px; background: rgba(34, 197, 94, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chart-line" style="font-size: 1.5rem; color: #4ADE80;"></i>
                            </div>
                            <div>
                                <h4 style="color: #fff; font-size: 1.125rem; font-weight: 600; margin: 0;">@lang('crm::lang.lead_conversion')</h4>
                                <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.25rem 0 0 0;">@lang('crm::lang.lead_conversion_desc')</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
