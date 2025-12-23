<?php

namespace Modules\Crm\Http\Controllers;

use App\Contact;
use App\Transaction;
use App\Utils\ModuleUtil;
use App\Utils\Util;
use App\Utils\TransactionUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Crm\Entities\CrmContactLogin;
use Yajra\DataTables\Facades\DataTables;

class ContactLoginController extends Controller
{
    protected $moduleUtil;
    protected $commonUtil;
    protected $transactionUtil;

    public function __construct(ModuleUtil $moduleUtil, Util $commonUtil, TransactionUtil $transactionUtil)
    {
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
        $this->transactionUtil = $transactionUtil;
    }

    /**
     * Display a listing of contact logins.
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
            $contact_logins = CrmContactLogin::forBusiness($business_id)
                ->with(['contact', 'createdBy'])
                ->select('crm_contact_logins.*');

            // Apply filters
            if (!empty($request->contact_id)) {
                $contact_logins->where('contact_id', $request->contact_id);
            }

            return DataTables::of($contact_logins)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                        <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' . __('messages.action') . '</button>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu">';

                    $html .= '<li><a href="#" class="edit-contact-login" data-href="' . action([\Modules\Crm\Http\Controllers\ContactLoginController::class, 'edit'], [$row->id]) . '"><i class="fas fa-edit"></i> ' . __('messages.edit') . '</a></li>';
                    $html .= '<li><a href="#" class="delete-contact-login" data-href="' . action([\Modules\Crm\Http\Controllers\ContactLoginController::class, 'destroy'], [$row->id]) . '"><i class="fas fa-trash"></i> ' . __('messages.delete') . '</a></li>';
                    $html .= '</ul></div>';

                    return $html;
                })
                ->editColumn('contact', function ($row) {
                    return $row->contact ? $row->contact->name : '-';
                })
                ->editColumn('username', function ($row) {
                    return $row->username;
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('email', function ($row) {
                    return $row->email ?? '-';
                })
                ->editColumn('is_active', function ($row) {
                    return $row->is_active
                        ? '<span class="tw-dw-badge tw-dw-badge-success">' . __('crm::lang.active') . '</span>'
                        : '<span class="tw-dw-badge tw-dw-badge-danger">' . __('crm::lang.inactive') . '</span>';
                })
                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }

        $contacts = Contact::where('business_id', $business_id)
            ->whereIn('type', ['customer', 'supplier'])
            ->pluck('name', 'id');

        return view('crm::contacts_login.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new contact login.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        $contacts = Contact::where('business_id', $business_id)
            ->whereIn('type', ['customer', 'supplier'])
            ->pluck('name', 'id');

        return view('crm::contacts_login.create', compact('contacts'));
    }

    /**
     * Store a newly created contact login.
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
            $request->validate([
                'contact_id' => 'required|exists:contacts,id',
                'username' => 'required|unique:crm_contact_logins,username',
                'password' => 'required|min:6',
                'name' => 'required',
                'email' => 'nullable|email',
            ]);

            $input = $request->only(['contact_id', 'username', 'name', 'email']);
            $input['business_id'] = $business_id;
            $input['created_by'] = auth()->user()->id;
            $input['password'] = Hash::make($request->password);
            $input['is_active'] = $request->has('is_active');

            CrmContactLogin::create($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.contact_login_added_successfully'),
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
     * Show the form for editing the specified contact login.
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

        $contact_login = CrmContactLogin::forBusiness($business_id)->findOrFail($id);
        $contacts = Contact::where('business_id', $business_id)
            ->whereIn('type', ['customer', 'supplier'])
            ->pluck('name', 'id');

        return view('crm::contacts_login.edit', compact('contact_login', 'contacts'));
    }

    /**
     * Update the specified contact login.
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
            $contact_login = CrmContactLogin::forBusiness($business_id)->findOrFail($id);

            $request->validate([
                'contact_id' => 'required|exists:contacts,id',
                'username' => 'required|unique:crm_contact_logins,username,' . $id,
                'name' => 'required',
                'email' => 'nullable|email',
            ]);

            $input = $request->only(['contact_id', 'username', 'name', 'email']);
            $input['is_active'] = $request->has('is_active');

            if (!empty($request->password)) {
                $input['password'] = Hash::make($request->password);
            }

            $contact_login->update($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.contact_login_updated_successfully'),
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
     * Remove the specified contact login.
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
            $contact_login = CrmContactLogin::forBusiness($business_id)->findOrFail($id);
            $contact_login->delete();

            $output = [
                'success' => true,
                'msg' => __('crm::lang.contact_login_deleted_successfully'),
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
     * Contact portal home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $contact_login = auth()->guard('contact')->user();
        if (!$contact_login) {
            return redirect()->route('login');
        }

        $contact = $contact_login->contact;
        $business_id = $contact_login->business_id;

        // Get totals
        $total_sale = Transaction::where('business_id', $business_id)
            ->where('contact_id', $contact->id)
            ->where('type', 'sell')
            ->where('status', 'final')
            ->sum('final_total');

        $total_payment = Transaction::where('business_id', $business_id)
            ->where('contact_id', $contact->id)
            ->where('type', 'sell')
            ->where('status', 'final')
            ->sum('total_paid');

        $total_due = $total_sale - $total_payment;

        return view('crm::contacts_login.portal.home', compact(
            'contact_login',
            'contact',
            'total_sale',
            'total_payment',
            'total_due'
        ));
    }

    /**
     * Contact portal sales page.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales(Request $request)
    {
        $contact_login = auth()->guard('contact')->user();
        if (!$contact_login) {
            return redirect()->route('login');
        }

        $contact = $contact_login->contact;
        $business_id = $contact_login->business_id;

        if ($request->ajax()) {
            $sales = Transaction::where('business_id', $business_id)
                ->where('contact_id', $contact->id)
                ->where('type', 'sell')
                ->where('status', 'final')
                ->select('transactions.*');

            return DataTables::of($sales)
                ->editColumn('transaction_date', function ($row) {
                    return $this->commonUtil->format_date($row->transaction_date, true);
                })
                ->editColumn('final_total', function ($row) {
                    return $this->transactionUtil->num_f($row->final_total);
                })
                ->editColumn('total_paid', function ($row) {
                    return $this->transactionUtil->num_f($row->total_paid);
                })
                ->addColumn('due', function ($row) {
                    return $this->transactionUtil->num_f($row->final_total - $row->total_paid);
                })
                ->make(true);
        }

        return view('crm::contacts_login.portal.sales', compact('contact_login', 'contact'));
    }

    /**
     * Contact portal ledger page.
     *
     * @return \Illuminate\Http\Response
     */
    public function ledger()
    {
        $contact_login = auth()->guard('contact')->user();
        if (!$contact_login) {
            return redirect()->route('login');
        }

        $contact = $contact_login->contact;
        $business_id = $contact_login->business_id;

        $ledger = $this->transactionUtil->getLedgerDetails($contact->id, $business_id);

        return view('crm::contacts_login.portal.ledger', compact('contact_login', 'contact', 'ledger'));
    }

    /**
     * Contact portal bookings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function bookings()
    {
        $contact_login = auth()->guard('contact')->user();
        if (!$contact_login) {
            return redirect()->route('login');
        }

        $contact = $contact_login->contact;
        $business_id = $contact_login->business_id;

        // Check if bookings module is enabled
        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'booking_module')) {
            abort(403, 'Bookings not enabled.');
        }

        return view('crm::contacts_login.portal.bookings', compact('contact_login', 'contact'));
    }
}
