<?php

namespace Modules\Crm\Http\Controllers;

use App\Contact;
use App\User;
use App\Utils\ModuleUtil;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Crm\Entities\CrmLead;
use Modules\Crm\Entities\CrmLifeStage;
use Modules\Crm\Entities\CrmSource;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    protected $moduleUtil;
    protected $commonUtil;

    public function __construct(ModuleUtil $moduleUtil, Util $commonUtil)
    {
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
    }

    /**
     * Display a listing of leads.
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
            $leads = CrmLead::forBusiness($business_id)
                ->with(['source', 'lifeStage', 'assignedTo', 'createdBy'])
                ->select('crm_leads.*');

            // Apply filters
            if (!empty($request->source_id)) {
                $leads->where('source_id', $request->source_id);
            }
            if (!empty($request->life_stage_id)) {
                $leads->where('life_stage_id', $request->life_stage_id);
            }
            if (!empty($request->assigned_to)) {
                $leads->where('assigned_to', $request->assigned_to);
            }

            return DataTables::of($leads)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                        <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' . __('messages.action') . '</button>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu">';

                    $html .= '<li><a href="' . action([\Modules\Crm\Http\Controllers\LeadController::class, 'show'], [$row->id]) . '"><i class="fas fa-eye"></i> ' . __('messages.view') . '</a></li>';
                    $html .= '<li><a href="' . action([\Modules\Crm\Http\Controllers\LeadController::class, 'edit'], [$row->id]) . '"><i class="fas fa-edit"></i> ' . __('messages.edit') . '</a></li>';

                    if (!$row->isConverted()) {
                        $html .= '<li><a href="#" class="convert-lead" data-href="' . action([\Modules\Crm\Http\Controllers\LeadController::class, 'convertToCustomer'], [$row->id]) . '"><i class="fas fa-user-plus"></i> ' . __('crm::lang.convert_to_customer') . '</a></li>';
                    }

                    $html .= '<li><a href="#" class="delete-lead" data-href="' . action([\Modules\Crm\Http\Controllers\LeadController::class, 'destroy'], [$row->id]) . '"><i class="fas fa-trash"></i> ' . __('messages.delete') . '</a></li>';
                    $html .= '</ul></div>';

                    return $html;
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('source', function ($row) {
                    return $row->source ? $row->source->name : '-';
                })
                ->editColumn('life_stage', function ($row) {
                    if ($row->lifeStage) {
                        return '<span class="tw-dw-badge" style="background-color: ' . $row->lifeStage->color . '; color: #fff;">' . $row->lifeStage->name . '</span>';
                    }
                    return '-';
                })
                ->editColumn('assigned_to', function ($row) {
                    return $row->assignedTo ? $row->assignedTo->user_full_name : '-';
                })
                ->editColumn('created_at', function ($row) {
                    return $this->commonUtil->format_date($row->created_at, true);
                })
                ->rawColumns(['action', 'life_stage'])
                ->make(true);
        }

        $sources = CrmSource::forBusiness($business_id)->active()->pluck('name', 'id');
        $life_stages = CrmLifeStage::forBusiness($business_id)->active()->pluck('name', 'id');
        $users = User::where('business_id', $business_id)->pluck('username', 'id');

        return view('crm::leads.index', compact('sources', 'life_stages', 'users'));
    }

    /**
     * Show the form for creating a new lead.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        $sources = CrmSource::forBusiness($business_id)->active()->pluck('name', 'id');
        $life_stages = CrmLifeStage::forBusiness($business_id)->active()->pluck('name', 'id');
        $users = User::where('business_id', $business_id)->pluck('username', 'id');

        return view('crm::leads.create', compact('sources', 'life_stages', 'users'));
    }

    /**
     * Store a newly created lead.
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
                'name', 'email', 'mobile', 'alternate_number', 'tax_number',
                'city', 'state', 'country', 'zip_code', 'address',
                'source_id', 'life_stage_id', 'assigned_to', 'additional_info',
                'custom_field_1', 'custom_field_2', 'custom_field_3', 'custom_field_4'
            ]);

            $input['business_id'] = $business_id;
            $input['created_by'] = auth()->user()->id;

            // Generate contact ID prefix
            $count = CrmLead::forBusiness($business_id)->count() + 1;
            $input['contact_id_prefix'] = 'CO' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $lead = CrmLead::create($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.lead_added_successfully'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ' Message: ' . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()
            ->action([\Modules\Crm\Http\Controllers\LeadController::class, 'index'])
            ->with('status', $output);
    }

    /**
     * Display the specified lead.
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

        $lead = CrmLead::forBusiness($business_id)
            ->with(['source', 'lifeStage', 'assignedTo', 'createdBy', 'schedules', 'proposals'])
            ->findOrFail($id);

        return view('crm::leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified lead.
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

        $lead = CrmLead::forBusiness($business_id)->findOrFail($id);
        $sources = CrmSource::forBusiness($business_id)->active()->pluck('name', 'id');
        $life_stages = CrmLifeStage::forBusiness($business_id)->active()->pluck('name', 'id');
        $users = User::where('business_id', $business_id)->pluck('username', 'id');

        return view('crm::leads.edit', compact('lead', 'sources', 'life_stages', 'users'));
    }

    /**
     * Update the specified lead.
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
            $lead = CrmLead::forBusiness($business_id)->findOrFail($id);

            $input = $request->only([
                'name', 'email', 'mobile', 'alternate_number', 'tax_number',
                'city', 'state', 'country', 'zip_code', 'address',
                'source_id', 'life_stage_id', 'assigned_to', 'additional_info',
                'custom_field_1', 'custom_field_2', 'custom_field_3', 'custom_field_4'
            ]);

            $lead->update($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.lead_updated_successfully'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ' Message: ' . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()
            ->action([\Modules\Crm\Http\Controllers\LeadController::class, 'index'])
            ->with('status', $output);
    }

    /**
     * Remove the specified lead.
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
            $lead = CrmLead::forBusiness($business_id)->findOrFail($id);
            $lead->delete();

            $output = [
                'success' => true,
                'msg' => __('crm::lang.lead_deleted_successfully'),
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
     * Display leads in Kanban view.
     *
     * @return \Illuminate\Http\Response
     */
    public function kanban()
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        $life_stages = CrmLifeStage::forBusiness($business_id)
            ->active()
            ->orderBy('sort_order')
            ->get();

        $leads = CrmLead::forBusiness($business_id)
            ->notConverted()
            ->with(['source', 'lifeStage', 'assignedTo'])
            ->get()
            ->groupBy('life_stage_id');

        return view('crm::leads.kanban', compact('life_stages', 'leads'));
    }

    /**
     * Convert lead to customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function convertToCustomer($id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $lead = CrmLead::forBusiness($business_id)->findOrFail($id);

            if ($lead->isConverted()) {
                throw new \Exception(__('crm::lang.lead_already_converted'));
            }

            // Create new contact from lead
            $contact_data = [
                'business_id' => $business_id,
                'type' => 'customer',
                'name' => $lead->name,
                'email' => $lead->email,
                'mobile' => $lead->mobile,
                'alternate_number' => $lead->alternate_number,
                'tax_number' => $lead->tax_number,
                'city' => $lead->city,
                'state' => $lead->state,
                'country' => $lead->country,
                'zip_code' => $lead->zip_code,
                'address_line_1' => $lead->address,
                'created_by' => auth()->user()->id,
            ];

            $contact = Contact::create($contact_data);

            // Update lead with conversion info
            $lead->update([
                'converted_contact_id' => $contact->id,
                'converted_at' => now(),
                'converted_by' => auth()->user()->id,
            ]);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.lead_converted_successfully'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ' Message: ' . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => $e->getMessage(),
            ];
        }

        return $output;
    }

    /**
     * Update lead life stage (for Kanban drag & drop).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateLifeStage(Request $request, $id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $lead = CrmLead::forBusiness($business_id)->findOrFail($id);
            $lead->update(['life_stage_id' => $request->life_stage_id]);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.life_stage_updated_successfully'),
            ];
        } catch (\Exception $e) {
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }
}
