<?php

namespace Modules\Crm\Http\Controllers;

use App\Contact;
use App\User;
use App\Utils\ModuleUtil;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Crm\Entities\CrmLead;
use Modules\Crm\Entities\CrmSchedule;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    protected $moduleUtil;
    protected $commonUtil;

    public function __construct(ModuleUtil $moduleUtil, Util $commonUtil)
    {
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
    }

    /**
     * Display a listing of schedules.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            $schedules = CrmSchedule::forBusiness($business_id)
                ->with(['lead', 'contact', 'assignedTo', 'createdBy'])
                ->select('crm_schedules.*');

            // Apply filters
            if (!empty($request->status)) {
                $schedules->where('status', $request->status);
            }
            if (!empty($request->contact_type)) {
                $schedules->where('contact_type', $request->contact_type);
            }
            if (!empty($request->followup_type)) {
                $schedules->where('followup_type', $request->followup_type);
            }
            if (!empty($request->assigned_to)) {
                $schedules->where('assigned_to', $request->assigned_to);
            }

            return DataTables::of($schedules)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                        <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' . __('messages.action') . '</button>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu">';

                    $html .= '<li><a href="#" class="view-schedule" data-href="' . action([\Modules\Crm\Http\Controllers\ScheduleController::class, 'show'], [$row->id]) . '"><i class="fas fa-eye"></i> ' . __('messages.view') . '</a></li>';
                    $html .= '<li><a href="#" class="edit-schedule" data-href="' . action([\Modules\Crm\Http\Controllers\ScheduleController::class, 'edit'], [$row->id]) . '"><i class="fas fa-edit"></i> ' . __('messages.edit') . '</a></li>';

                    if ($row->status !== 'completed') {
                        $html .= '<li><a href="#" class="complete-schedule" data-href="' . action([\Modules\Crm\Http\Controllers\ScheduleController::class, 'updateStatus'], [$row->id]) . '"><i class="fas fa-check"></i> ' . __('crm::lang.mark_complete') . '</a></li>';
                    }

                    $html .= '<li><a href="#" class="delete-schedule" data-href="' . action([\Modules\Crm\Http\Controllers\ScheduleController::class, 'destroy'], [$row->id]) . '"><i class="fas fa-trash"></i> ' . __('messages.delete') . '</a></li>';
                    $html .= '</ul></div>';

                    return $html;
                })
                ->editColumn('title', function ($row) {
                    return $row->title;
                })
                ->editColumn('contact_name', function ($row) {
                    return $row->contact_name ?? '-';
                })
                ->editColumn('status', function ($row) {
                    $colors = [
                        'scheduled' => 'info',
                        'open' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    ];
                    $color = $colors[$row->status] ?? 'secondary';
                    return '<span class="tw-dw-badge tw-dw-badge-' . $color . '">' . __('crm::lang.' . $row->status) . '</span>';
                })
                ->editColumn('followup_type', function ($row) {
                    return __('crm::lang.' . $row->followup_type);
                })
                ->editColumn('start_datetime', function ($row) {
                    return $this->commonUtil->format_date($row->start_datetime, true);
                })
                ->editColumn('assigned_to', function ($row) {
                    return $row->assignedTo ? $row->assignedTo->user_full_name : '-';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $users = User::where('business_id', $business_id)->pluck('username', 'id');

        return view('crm::schedules.index', compact('users'));
    }

    /**
     * Show the form for creating a new schedule.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        $leads = CrmLead::forBusiness($business_id)->notConverted()->pluck('name', 'id');
        $customers = Contact::where('business_id', $business_id)->where('type', 'customer')->pluck('name', 'id');
        $suppliers = Contact::where('business_id', $business_id)->where('type', 'supplier')->pluck('name', 'id');
        $users = User::where('business_id', $business_id)->pluck('username', 'id');

        return view('crm::schedules.create', compact('leads', 'customers', 'suppliers', 'users'));
    }

    /**
     * Store a newly created schedule.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only([
                'title', 'contact_type', 'status', 'description', 'followup_type',
                'assigned_to', 'send_notification', 'is_recurring', 'recurrence_type',
                'recurrence_interval', 'followup_category', 'invoice_status', 'notes'
            ]);

            $input['business_id'] = $business_id;
            $input['created_by'] = auth()->user()->id;
            $input['send_notification'] = $request->has('send_notification');
            $input['is_recurring'] = $request->has('is_recurring');

            // Handle contact based on type
            if ($request->contact_type === 'lead') {
                $input['lead_id'] = $request->lead_id;
                $input['contact_id'] = null;
            } else {
                $input['contact_id'] = $request->contact_id;
                $input['lead_id'] = null;
            }

            // Handle datetime
            $input['start_datetime'] = $this->commonUtil->uf_date($request->start_datetime, true);
            $input['end_datetime'] = $request->end_datetime ? $this->commonUtil->uf_date($request->end_datetime, true) : null;

            if ($request->is_recurring && $request->recurrence_end_date) {
                $input['recurrence_end_date'] = $this->commonUtil->uf_date($request->recurrence_end_date);
            }

            $schedule = CrmSchedule::create($input);

            // Create recurring schedules if needed
            if ($schedule->is_recurring) {
                $this->createRecurringSchedules($schedule);
            }

            $output = [
                'success' => true,
                'msg' => __('crm::lang.schedule_added_successfully'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ' Message: ' . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Display the specified schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        $schedule = CrmSchedule::forBusiness($business_id)
            ->with(['lead', 'contact', 'assignedTo', 'createdBy'])
            ->findOrFail($id);

        return view('crm::schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        $schedule = CrmSchedule::forBusiness($business_id)->findOrFail($id);
        $leads = CrmLead::forBusiness($business_id)->notConverted()->pluck('name', 'id');
        $customers = Contact::where('business_id', $business_id)->where('type', 'customer')->pluck('name', 'id');
        $suppliers = Contact::where('business_id', $business_id)->where('type', 'supplier')->pluck('name', 'id');
        $users = User::where('business_id', $business_id)->pluck('username', 'id');

        return view('crm::schedules.edit', compact('schedule', 'leads', 'customers', 'suppliers', 'users'));
    }

    /**
     * Update the specified schedule.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $schedule = CrmSchedule::forBusiness($business_id)->findOrFail($id);

            $input = $request->only([
                'title', 'contact_type', 'status', 'description', 'followup_type',
                'assigned_to', 'followup_category', 'invoice_status', 'notes'
            ]);

            $input['send_notification'] = $request->has('send_notification');

            // Handle contact based on type
            if ($request->contact_type === 'lead') {
                $input['lead_id'] = $request->lead_id;
                $input['contact_id'] = null;
            } else {
                $input['contact_id'] = $request->contact_id;
                $input['lead_id'] = null;
            }

            // Handle datetime
            $input['start_datetime'] = $this->commonUtil->uf_date($request->start_datetime, true);
            $input['end_datetime'] = $request->end_datetime ? $this->commonUtil->uf_date($request->end_datetime, true) : null;

            $schedule->update($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.schedule_updated_successfully'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ' Message: ' . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Remove the specified schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $schedule = CrmSchedule::forBusiness($business_id)->findOrFail($id);
            $schedule->delete();

            $output = [
                'success' => true,
                'msg' => __('crm::lang.schedule_deleted_successfully'),
            ];
        } catch (\Exception $e) {
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Update schedule status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $schedule = CrmSchedule::forBusiness($business_id)->findOrFail($id);
            $schedule->update(['status' => $request->status ?? 'completed']);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.status_updated_successfully'),
            ];
        } catch (\Exception $e) {
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Create recurring schedules based on parent schedule.
     *
     * @param  CrmSchedule  $schedule
     * @return void
     */
    private function createRecurringSchedules(CrmSchedule $schedule)
    {
        if (!$schedule->recurrence_end_date || !$schedule->recurrence_type) {
            return;
        }

        $start_date = Carbon::parse($schedule->start_datetime);
        $end_date = Carbon::parse($schedule->recurrence_end_date);
        $interval = $schedule->recurrence_interval ?? 1;

        $current_date = clone $start_date;

        while ($current_date->lt($end_date)) {
            switch ($schedule->recurrence_type) {
                case 'daily':
                    $current_date->addDays($interval);
                    break;
                case 'weekly':
                    $current_date->addWeeks($interval);
                    break;
                case 'monthly':
                    $current_date->addMonths($interval);
                    break;
                case 'yearly':
                    $current_date->addYears($interval);
                    break;
            }

            if ($current_date->lte($end_date)) {
                CrmSchedule::create([
                    'business_id' => $schedule->business_id,
                    'title' => $schedule->title,
                    'contact_type' => $schedule->contact_type,
                    'lead_id' => $schedule->lead_id,
                    'contact_id' => $schedule->contact_id,
                    'status' => 'scheduled',
                    'start_datetime' => $current_date,
                    'end_datetime' => $schedule->end_datetime ? Carbon::parse($schedule->end_datetime)->addDays($current_date->diffInDays($start_date)) : null,
                    'description' => $schedule->description,
                    'followup_type' => $schedule->followup_type,
                    'assigned_to' => $schedule->assigned_to,
                    'send_notification' => $schedule->send_notification,
                    'is_recurring' => false,
                    'parent_schedule_id' => $schedule->id,
                    'followup_category' => $schedule->followup_category,
                    'notes' => $schedule->notes,
                    'created_by' => $schedule->created_by,
                ]);
            }
        }
    }
}
