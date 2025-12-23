<?php

namespace Modules\Crm\Http\Controllers;

use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Crm\Entities\CrmLead;
use Modules\Crm\Entities\CrmSchedule;
use Modules\Crm\Entities\CrmCampaign;

class CrmController extends Controller
{
    protected $moduleUtil;

    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display the CRM dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        // Get statistics
        $total_leads = CrmLead::forBusiness($business_id)->notConverted()->count();
        $converted_leads = CrmLead::forBusiness($business_id)->converted()->count();
        $upcoming_followups = CrmSchedule::forBusiness($business_id)->upcoming()->count();
        $overdue_followups = CrmSchedule::forBusiness($business_id)->overdue()->count();
        $total_campaigns = CrmCampaign::forBusiness($business_id)->count();
        $sent_campaigns = CrmCampaign::forBusiness($business_id)->status('sent')->count();

        // Recent leads
        $recent_leads = CrmLead::forBusiness($business_id)
            ->with(['source', 'lifeStage', 'assignedTo'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Upcoming followups
        $upcoming_schedules = CrmSchedule::forBusiness($business_id)
            ->upcoming()
            ->with(['lead', 'contact', 'assignedTo'])
            ->orderBy('start_datetime', 'asc')
            ->limit(5)
            ->get();

        return view('crm::dashboard.index', compact(
            'total_leads',
            'converted_leads',
            'upcoming_followups',
            'overdue_followups',
            'total_campaigns',
            'sent_campaigns',
            'recent_leads',
            'upcoming_schedules'
        ));
    }
}
