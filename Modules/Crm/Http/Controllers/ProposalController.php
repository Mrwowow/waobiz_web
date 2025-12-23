<?php

namespace Modules\Crm\Http\Controllers;

use App\Utils\ModuleUtil;
use App\Utils\Util;
use App\Utils\NotificationUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Crm\Entities\CrmLead;
use Modules\Crm\Entities\CrmProposal;
use Modules\Crm\Entities\CrmProposalTemplate;
use Yajra\DataTables\Facades\DataTables;

class ProposalController extends Controller
{
    protected $moduleUtil;
    protected $commonUtil;
    protected $notificationUtil;

    public function __construct(ModuleUtil $moduleUtil, Util $commonUtil, NotificationUtil $notificationUtil)
    {
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
        $this->notificationUtil = $notificationUtil;
    }

    /**
     * Display a listing of proposals.
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
            $proposals = CrmProposal::forBusiness($business_id)
                ->with(['lead', 'template', 'createdBy'])
                ->select('crm_proposals.*');

            // Apply filters
            if (!empty($request->status)) {
                $proposals->where('status', $request->status);
            }
            if (!empty($request->lead_id)) {
                $proposals->where('lead_id', $request->lead_id);
            }

            return DataTables::of($proposals)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                        <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' . __('messages.action') . '</button>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu">';

                    $html .= '<li><a href="#" class="view-proposal" data-href="' . action([\Modules\Crm\Http\Controllers\ProposalController::class, 'show'], [$row->id]) . '"><i class="fas fa-eye"></i> ' . __('messages.view') . '</a></li>';
                    $html .= '<li><a href="#" class="edit-proposal" data-href="' . action([\Modules\Crm\Http\Controllers\ProposalController::class, 'edit'], [$row->id]) . '"><i class="fas fa-edit"></i> ' . __('messages.edit') . '</a></li>';

                    if ($row->status === 'draft') {
                        $html .= '<li><a href="#" class="send-proposal" data-href="' . action([\Modules\Crm\Http\Controllers\ProposalController::class, 'send'], [$row->id]) . '"><i class="fas fa-paper-plane"></i> ' . __('crm::lang.send_proposal') . '</a></li>';
                    }

                    $html .= '<li><a href="#" class="delete-proposal" data-href="' . action([\Modules\Crm\Http\Controllers\ProposalController::class, 'destroy'], [$row->id]) . '"><i class="fas fa-trash"></i> ' . __('messages.delete') . '</a></li>';
                    $html .= '</ul></div>';

                    return $html;
                })
                ->editColumn('lead', function ($row) {
                    return $row->lead ? $row->lead->name : '-';
                })
                ->editColumn('subject', function ($row) {
                    return $row->subject;
                })
                ->editColumn('status', function ($row) {
                    $colors = [
                        'draft' => 'secondary',
                        'sent' => 'info',
                        'viewed' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                    ];
                    $color = $colors[$row->status] ?? 'secondary';
                    return '<span class="tw-dw-badge tw-dw-badge-' . $color . '">' . ucfirst($row->status) . '</span>';
                })
                ->editColumn('created_at', function ($row) {
                    return $this->commonUtil->format_date($row->created_at, true);
                })
                ->editColumn('sent_at', function ($row) {
                    return $row->sent_at ? $this->commonUtil->format_date($row->sent_at, true) : '-';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $leads = CrmLead::forBusiness($business_id)->notConverted()->pluck('name', 'id');

        return view('crm::proposals.index', compact('leads'));
    }

    /**
     * Show the form for creating a new proposal.
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
        $templates = CrmProposalTemplate::forBusiness($business_id)->active()->pluck('name', 'id');

        return view('crm::proposals.create', compact('leads', 'templates'));
    }

    /**
     * Store a newly created proposal.
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
            $input = $request->only(['lead_id', 'template_id', 'subject', 'body', 'status']);
            $input['business_id'] = $business_id;
            $input['created_by'] = auth()->user()->id;

            // Handle attachments
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('crm/proposals', 'public');
                    $attachments[] = $path;
                }
                $input['attachments'] = $attachments;
            }

            CrmProposal::create($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.proposal_added_successfully'),
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
     * Display the specified proposal.
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

        $proposal = CrmProposal::forBusiness($business_id)
            ->with(['lead', 'template', 'createdBy'])
            ->findOrFail($id);

        return view('crm::proposals.show', compact('proposal'));
    }

    /**
     * Show the form for editing the specified proposal.
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

        $proposal = CrmProposal::forBusiness($business_id)->findOrFail($id);
        $leads = CrmLead::forBusiness($business_id)->notConverted()->pluck('name', 'id');
        $templates = CrmProposalTemplate::forBusiness($business_id)->active()->pluck('name', 'id');

        return view('crm::proposals.edit', compact('proposal', 'leads', 'templates'));
    }

    /**
     * Update the specified proposal.
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
            $proposal = CrmProposal::forBusiness($business_id)->findOrFail($id);

            $input = $request->only(['lead_id', 'template_id', 'subject', 'body', 'status']);

            // Handle attachments
            if ($request->hasFile('attachments')) {
                $attachments = $proposal->attachments ?? [];
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('crm/proposals', 'public');
                    $attachments[] = $path;
                }
                $input['attachments'] = $attachments;
            }

            $proposal->update($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.proposal_updated_successfully'),
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
     * Remove the specified proposal.
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
            $proposal = CrmProposal::forBusiness($business_id)->findOrFail($id);
            $proposal->delete();

            $output = [
                'success' => true,
                'msg' => __('crm::lang.proposal_deleted_successfully'),
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
     * Send proposal to lead.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send($id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $proposal = CrmProposal::forBusiness($business_id)
                ->with(['lead'])
                ->findOrFail($id);

            if (!$proposal->lead || !$proposal->lead->email) {
                throw new \Exception(__('crm::lang.lead_email_required'));
            }

            // Send email
            $this->notificationUtil->sendEmailNotification(
                $proposal->lead->email,
                $proposal->subject,
                $proposal->body
            );

            $proposal->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.proposal_sent_successfully'),
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
}
