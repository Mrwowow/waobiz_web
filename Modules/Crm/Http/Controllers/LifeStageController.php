<?php

namespace Modules\Crm\Http\Controllers;

use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Crm\Entities\CrmLifeStage;
use Yajra\DataTables\Facades\DataTables;

class LifeStageController extends Controller
{
    protected $moduleUtil;

    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of life stages.
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
            $life_stages = CrmLifeStage::forBusiness($business_id)
                ->with(['createdBy'])
                ->select('crm_life_stages.*');

            return DataTables::of($life_stages)
                ->addColumn('action', function ($row) {
                    $html = '<button class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-primary edit-life-stage" data-href="' . action([\Modules\Crm\Http\Controllers\LifeStageController::class, 'edit'], [$row->id]) . '"><i class="fas fa-edit"></i></button> ';
                    $html .= '<button class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-error delete-life-stage" data-href="' . action([\Modules\Crm\Http\Controllers\LifeStageController::class, 'destroy'], [$row->id]) . '"><i class="fas fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('name', function ($row) {
                    return '<span class="tw-dw-badge" style="background-color: ' . $row->color . '; color: #fff;">' . $row->name . '</span>';
                })
                ->editColumn('is_active', function ($row) {
                    return $row->is_active
                        ? '<span class="tw-dw-badge tw-dw-badge-success">' . __('crm::lang.active') . '</span>'
                        : '<span class="tw-dw-badge tw-dw-badge-danger">' . __('crm::lang.inactive') . '</span>';
                })
                ->rawColumns(['action', 'name', 'is_active'])
                ->make(true);
        }

        return view('crm::life_stages.index');
    }

    /**
     * Show the form for creating a new life stage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        return view('crm::life_stages.create');
    }

    /**
     * Store a newly created life stage.
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
            $input = $request->only(['name', 'color', 'description', 'sort_order']);
            $input['business_id'] = $business_id;
            $input['created_by'] = auth()->user()->id;
            $input['is_active'] = $request->has('is_active');

            CrmLifeStage::create($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.life_stage_added_successfully'),
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
     * Show the form for editing the specified life stage.
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

        $life_stage = CrmLifeStage::forBusiness($business_id)->findOrFail($id);

        return view('crm::life_stages.edit', compact('life_stage'));
    }

    /**
     * Update the specified life stage.
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
            $life_stage = CrmLifeStage::forBusiness($business_id)->findOrFail($id);

            $input = $request->only(['name', 'color', 'description', 'sort_order']);
            $input['is_active'] = $request->has('is_active');

            $life_stage->update($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.life_stage_updated_successfully'),
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
     * Remove the specified life stage.
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
            $life_stage = CrmLifeStage::forBusiness($business_id)->findOrFail($id);
            $life_stage->delete();

            $output = [
                'success' => true,
                'msg' => __('crm::lang.life_stage_deleted_successfully'),
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
