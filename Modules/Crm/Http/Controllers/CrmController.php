<?php

namespace Modules\Crm\Http\Controllers;

use App\Utils\ModuleUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Crm\Entities\CrmLead;
use Modules\Crm\Entities\CrmSchedule;
use Modules\Crm\Entities\CrmCampaign;
use Modules\Crm\Entities\CrmProposal;
use Modules\Crm\Entities\CrmLifeStage;

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

        // Proposal statistics
        $total_proposals = CrmProposal::where('business_id', $business_id)->count();
        $accepted_proposals = CrmProposal::where('business_id', $business_id)->where('status', 'accepted')->count();
        $pending_proposals = CrmProposal::where('business_id', $business_id)->whereIn('status', ['draft', 'sent', 'viewed'])->count();

        // Conversion rate
        $all_leads = CrmLead::forBusiness($business_id)->count();
        $conversion_rate = $all_leads > 0 ? round(($converted_leads / $all_leads) * 100, 1) : 0;

        // Leads by life stage for chart
        $leads_by_stage = CrmLifeStage::where('business_id', $business_id)
            ->withCount(['leads' => function ($query) use ($business_id) {
                $query->where('business_id', $business_id)->whereNull('converted_at');
            }])
            ->orderBy('sort_order')
            ->get();

        // Leads trend (last 7 days)
        $leads_trend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = CrmLead::forBusiness($business_id)
                ->whereDate('created_at', $date->toDateString())
                ->count();
            $leads_trend[] = [
                'date' => $date->format('M d'),
                'count' => $count
            ];
        }

        // Today's followups
        $todays_followups = CrmSchedule::forBusiness($business_id)
            ->whereDate('start_datetime', Carbon::today())
            ->whereIn('status', ['scheduled', 'open'])
            ->with(['lead', 'contact', 'assignedTo'])
            ->orderBy('start_datetime', 'asc')
            ->get();

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

        // Recent activities (combined leads and followups)
        $recent_activities = collect();

        // Add recent leads as activities
        CrmLead::forBusiness($business_id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->each(function ($lead) use ($recent_activities) {
                $recent_activities->push([
                    'type' => 'lead',
                    'icon' => 'fas fa-user-plus',
                    'color' => 'blue',
                    'title' => __('crm::lang.new_lead_added'),
                    'description' => $lead->name,
                    'time' => $lead->created_at
                ]);
            });

        // Add recent completed followups
        CrmSchedule::forBusiness($business_id)
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get()
            ->each(function ($schedule) use ($recent_activities) {
                $recent_activities->push([
                    'type' => 'followup',
                    'icon' => 'fas fa-check-circle',
                    'color' => 'green',
                    'title' => __('crm::lang.followup_completed'),
                    'description' => $schedule->title,
                    'time' => $schedule->updated_at
                ]);
            });

        $recent_activities = $recent_activities->sortByDesc('time')->take(5)->values();

        return view('crm::dashboard.index', compact(
            'total_leads',
            'converted_leads',
            'upcoming_followups',
            'overdue_followups',
            'total_campaigns',
            'sent_campaigns',
            'total_proposals',
            'accepted_proposals',
            'pending_proposals',
            'conversion_rate',
            'leads_by_stage',
            'leads_trend',
            'todays_followups',
            'recent_leads',
            'upcoming_schedules',
            'recent_activities'
        ));
    }
}
