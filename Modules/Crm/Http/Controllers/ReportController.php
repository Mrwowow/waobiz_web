<?php

namespace Modules\Crm\Http\Controllers;

use App\User;
use App\Utils\ModuleUtil;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Crm\Entities\CrmLead;
use Modules\Crm\Entities\CrmSchedule;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    protected $moduleUtil;
    protected $commonUtil;

    public function __construct(ModuleUtil $moduleUtil, Util $commonUtil)
    {
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
    }

    /**
     * Display reports index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        return view('crm::reports.index');
    }

    /**
     * Follow-ups by user report.
     *
     * @return \Illuminate\Http\Response
     */
    public function followupsByUser(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $query = CrmSchedule::forBusiness($business_id)
                ->select(
                    'assigned_to',
                    DB::raw('COUNT(*) as total_followups'),
                    DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed'),
                    DB::raw('SUM(CASE WHEN status = "scheduled" THEN 1 ELSE 0 END) as scheduled'),
                    DB::raw('SUM(CASE WHEN status = "open" THEN 1 ELSE 0 END) as open'),
                    DB::raw('SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled')
                )
                ->with('assignedTo')
                ->groupBy('assigned_to');

            if (!empty($start_date) && !empty($end_date)) {
                $start_date = $this->commonUtil->uf_date($start_date);
                $end_date = $this->commonUtil->uf_date($end_date);
                $query->whereBetween(DB::raw('DATE(start_datetime)'), [$start_date, $end_date]);
            }

            return DataTables::of($query)
                ->editColumn('assigned_to', function ($row) {
                    return $row->assignedTo ? $row->assignedTo->user_full_name : __('crm::lang.unassigned');
                })
                ->make(true);
        }

        $users = User::where('business_id', $business_id)->pluck('username', 'id');

        return view('crm::reports.followups_by_user', compact('users'));
    }

    /**
     * Follow-ups by contacts report.
     *
     * @return \Illuminate\Http\Response
     */
    public function followupsByContacts(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            // Leads followups
            $lead_query = CrmSchedule::forBusiness($business_id)
                ->where('contact_type', 'lead')
                ->select(
                    'lead_id',
                    DB::raw('"lead" as contact_type'),
                    DB::raw('COUNT(*) as total_followups'),
                    DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed'),
                    DB::raw('SUM(CASE WHEN status != "completed" THEN 1 ELSE 0 END) as pending')
                )
                ->with('lead')
                ->groupBy('lead_id');

            if (!empty($start_date) && !empty($end_date)) {
                $start_date = $this->commonUtil->uf_date($start_date);
                $end_date = $this->commonUtil->uf_date($end_date);
                $lead_query->whereBetween(DB::raw('DATE(start_datetime)'), [$start_date, $end_date]);
            }

            return DataTables::of($lead_query)
                ->editColumn('lead_id', function ($row) {
                    return $row->lead ? $row->lead->name : '-';
                })
                ->make(true);
        }

        return view('crm::reports.followups_by_contacts');
    }

    /**
     * Lead to customer conversion report.
     *
     * @return \Illuminate\Http\Response
     */
    public function leadConversion(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $query = CrmLead::forBusiness($business_id)
                ->with(['source', 'lifeStage', 'convertedBy'])
                ->select('crm_leads.*');

            if (!empty($start_date) && !empty($end_date)) {
                $start_date = $this->commonUtil->uf_date($start_date);
                $end_date = $this->commonUtil->uf_date($end_date);
                $query->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date]);
            }

            if ($request->conversion_status === 'converted') {
                $query->converted();
            } elseif ($request->conversion_status === 'not_converted') {
                $query->notConverted();
            }

            return DataTables::of($query)
                ->editColumn('source', function ($row) {
                    return $row->source ? $row->source->name : '-';
                })
                ->editColumn('life_stage', function ($row) {
                    if ($row->lifeStage) {
                        return '<span class="tw-dw-badge" style="background-color: ' . $row->lifeStage->color . '; color: #fff;">' . $row->lifeStage->name . '</span>';
                    }
                    return '-';
                })
                ->editColumn('converted_at', function ($row) {
                    return $row->converted_at ? $this->commonUtil->format_date($row->converted_at, true) : '-';
                })
                ->editColumn('converted_by', function ($row) {
                    return $row->convertedBy ? $row->convertedBy->user_full_name : '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->isConverted()
                        ? '<span class="tw-dw-badge tw-dw-badge-success">' . __('crm::lang.converted') . '</span>'
                        : '<span class="tw-dw-badge tw-dw-badge-warning">' . __('crm::lang.not_converted') . '</span>';
                })
                ->rawColumns(['life_stage', 'status'])
                ->make(true);
        }

        // Get conversion statistics
        $total_leads = CrmLead::forBusiness($business_id)->count();
        $converted_leads = CrmLead::forBusiness($business_id)->converted()->count();
        $conversion_rate = $total_leads > 0 ? round(($converted_leads / $total_leads) * 100, 2) : 0;

        // Conversion by source
        $conversion_by_source = CrmLead::forBusiness($business_id)
            ->select(
                'source_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN converted_contact_id IS NOT NULL THEN 1 ELSE 0 END) as converted')
            )
            ->with('source')
            ->groupBy('source_id')
            ->get();

        return view('crm::reports.lead_conversion', compact(
            'total_leads',
            'converted_leads',
            'conversion_rate',
            'conversion_by_source'
        ));
    }
}
