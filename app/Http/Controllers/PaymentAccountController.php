<?php

namespace App\Http\Controllers;

use App\PaymentAccount;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentAccountController extends Controller
{
    protected $moduleUtil;

    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    public function index()
    {
        if (! auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        if (request()->ajax()) {
            $accounts = PaymentAccount::where('business_id', $business_id)
                ->select(['id', 'name', 'account_number', 'account_type', 'note']);

            return Datatables::of($accounts)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('account.access')) {
                        $html .= '<button data-href="' . action([\App\Http\Controllers\PaymentAccountController::class, 'edit'], [$row->id]) . '" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-primary edit_payment_account_button"><i class="glyphicon glyphicon-edit"></i> ' . __('messages.edit') . '</button> ';
                        $html .= '<button data-href="' . action([\App\Http\Controllers\PaymentAccountController::class, 'destroy'], [$row->id]) . '" class="tw-dw-btn tw-dw-btn-outline tw-dw-btn-xs tw-dw-btn-error delete_payment_account_button"><i class="glyphicon glyphicon-trash"></i> ' . __('messages.delete') . '</button>';
                    }
                    return $html;
                })
                ->editColumn('account_type', function ($row) {
                    return PaymentAccount::account_name($row->account_type);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('payment_account.index');
    }

    public function create()
    {
        if (! auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        $account_types = PaymentAccount::account_types();

        return view('payment_account.create', compact('account_types'));
    }

    public function store(Request $request)
    {
        if (! auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'account_number', 'account_type', 'note']);
            $input['business_id'] = $request->session()->get('user.business_id');
            $input['created_by'] = $request->session()->get('user.id');

            PaymentAccount::create($input);
            $output = [
                'success' => true,
                'msg' => __('lang_v1.added_success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    public function edit($id)
    {
        if (! auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $account = PaymentAccount::where('business_id', $business_id)->findOrFail($id);
        $account_types = PaymentAccount::account_types();

        return view('payment_account.edit', compact('account', 'account_types'));
    }

    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'account_number', 'account_type', 'note']);
            $business_id = $request->session()->get('user.business_id');

            PaymentAccount::where('business_id', $business_id)
                ->where('id', $id)
                ->update($input);

            $output = [
                'success' => true,
                'msg' => __('lang_v1.updated_success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    public function destroy($id)
    {
        if (! auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            PaymentAccount::where('business_id', $business_id)->where('id', $id)->delete();

            $output = [
                'success' => true,
                'msg' => __('lang_v1.deleted_success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }
}
