<?php

namespace Modules\Crm\Http\Controllers;

use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Crm\Entities\CrmSource;
use Yajra\DataTables\Facades\DataTables;

class SourceController extends Controller
{
    protected $moduleUtil;

    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of sources.
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
            $sources = CrmSource::forBusiness($business_id)
                ->with(['createdBy'])
                ->select('crm_sources.*');

            return DataTables::of($sources)
                ->addColumn('action', function ($row) {
                    $html = '<button class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-primary edit-source" data-href="' . action([\Modules\Crm\Http\Controllers\SourceController::class, 'edit'], [$row->id]) . '"><i class="fas fa-edit"></i></button> ';
                    $html .= '<button class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-error delete-source" data-href="' . action([\Modules\Crm\Http\Controllers\SourceController::class, 'destroy'], [$row->id]) . '"><i class="fas fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('is_active', function ($row) {
                    return $row->is_active
                        ? '<span class="tw-dw-badge tw-dw-badge-success">' . __('crm::lang.active') . '</span>'
                        : '<span class="tw-dw-badge tw-dw-badge-danger">' . __('crm::lang.inactive') . '</span>';
                })
                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }

        return view('crm::sources.index');
    }

    /**
     * Show the form for creating a new source.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        return view('crm::sources.create');
    }

    /**
     * Store a newly created source.
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
            $input = $request->only(['name', 'description', 'sort_order']);
            $input['business_id'] = $business_id;
            $input['created_by'] = auth()->user()->id;
            $input['is_active'] = $request->has('is_active');

            CrmSource::create($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.source_added_successfully'),
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
     * Show the form for editing the specified source.
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

        $source = CrmSource::forBusiness($business_id)->findOrFail($id);

        return view('crm::sources.edit', compact('source'));
    }

    /**
     * Update the specified source.
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
            $source = CrmSource::forBusiness($business_id)->findOrFail($id);

            $input = $request->only(['name', 'description', 'sort_order']);
            $input['is_active'] = $request->has('is_active');

            $source->update($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.source_updated_successfully'),
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
     * Remove the specified source.
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
            $source = CrmSource::forBusiness($business_id)->findOrFail($id);
            $source->delete();

            $output = [
                'success' => true,
                'msg' => __('crm::lang.source_deleted_successfully'),
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
