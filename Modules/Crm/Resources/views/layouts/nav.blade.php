<ul class="nav nav-tabs">
    <li class="{{ request()->segment(2) == '' || request()->segment(2) == 'schedules' ? 'active' : '' }}">
        <a href="{{ url('crm/schedules') }}">
            <i class="fas fa-calendar-check"></i> @lang('crm::lang.schedules')
        </a>
    </li>
    <li class="{{ request()->segment(2) == 'leads' || request()->segment(2) == 'leads-kanban' ? 'active' : '' }}">
        <a href="{{ url('crm/leads') }}">
            <i class="fas fa-user-tie"></i> @lang('crm::lang.leads')
        </a>
    </li>
    <li class="{{ request()->segment(2) == 'campaigns' ? 'active' : '' }}">
        <a href="{{ url('crm/campaigns') }}">
            <i class="fas fa-bullhorn"></i> @lang('crm::lang.campaigns')
        </a>
    </li>
    <li class="{{ request()->segment(2) == 'contacts-login' ? 'active' : '' }}">
        <a href="{{ url('crm/contacts-login') }}">
            <i class="fas fa-users"></i> @lang('crm::lang.contacts_login')
        </a>
    </li>
    <li class="{{ request()->segment(2) == 'sources' ? 'active' : '' }}">
        <a href="{{ url('crm/sources') }}">
            <i class="fas fa-sitemap"></i> @lang('crm::lang.sources')
        </a>
    </li>
    <li class="{{ request()->segment(2) == 'life-stages' ? 'active' : '' }}">
        <a href="{{ url('crm/life-stages') }}">
            <i class="fas fa-flag"></i> @lang('crm::lang.life_stages')
        </a>
    </li>
</ul>
