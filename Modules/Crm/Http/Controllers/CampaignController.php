<?php

namespace Modules\Crm\Http\Controllers;

use App\Contact;
use App\Utils\ModuleUtil;
use App\Utils\Util;
use App\Utils\NotificationUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Crm\Entities\CrmCampaign;
use Modules\Crm\Entities\CrmLead;
use Yajra\DataTables\Facades\DataTables;

class CampaignController extends Controller
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
     * Display a listing of campaigns.
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
            $campaigns = CrmCampaign::forBusiness($business_id)
                ->with(['createdBy'])
                ->select('crm_campaigns.*');

            // Apply filters
            if (!empty($request->campaign_type)) {
                $campaigns->where('campaign_type', $request->campaign_type);
            }
            if (!empty($request->status)) {
                $campaigns->where('status', $request->status);
            }

            return DataTables::of($campaigns)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                        <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' . __('messages.action') . '</button>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu">';

                    $html .= '<li><a href="#" class="view-campaign" data-href="' . action([\Modules\Crm\Http\Controllers\CampaignController::class, 'show'], [$row->id]) . '"><i class="fas fa-eye"></i> ' . __('messages.view') . '</a></li>';
                    $html .= '<li><a href="#" class="edit-campaign" data-href="' . action([\Modules\Crm\Http\Controllers\CampaignController::class, 'edit'], [$row->id]) . '"><i class="fas fa-edit"></i> ' . __('messages.edit') . '</a></li>';

                    if ($row->status !== 'sent') {
                        $html .= '<li><a href="#" class="send-campaign" data-href="' . action([\Modules\Crm\Http\Controllers\CampaignController::class, 'sendNotification'], [$row->id]) . '"><i class="fas fa-paper-plane"></i> ' . __('crm::lang.send_notification') . '</a></li>';
                    }

                    $html .= '<li><a href="#" class="delete-campaign" data-href="' . action([\Modules\Crm\Http\Controllers\CampaignController::class, 'destroy'], [$row->id]) . '"><i class="fas fa-trash"></i> ' . __('messages.delete') . '</a></li>';
                    $html .= '</ul></div>';

                    return $html;
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('campaign_type', function ($row) {
                    $types = [
                        'email' => '<span class="tw-dw-badge tw-dw-badge-info">Email</span>',
                        'sms' => '<span class="tw-dw-badge tw-dw-badge-warning">SMS</span>',
                    ];
                    return $types[$row->campaign_type] ?? '-';
                })
                ->editColumn('status', function ($row) {
                    $colors = [
                        'draft' => 'secondary',
                        'scheduled' => 'info',
                        'sent' => 'success',
                        'failed' => 'danger',
                    ];
                    $color = $colors[$row->status] ?? 'secondary';
                    return '<span class="tw-dw-badge tw-dw-badge-' . $color . '">' . ucfirst($row->status) . '</span>';
                })
                ->editColumn('created_by', function ($row) {
                    return $row->createdBy ? $row->createdBy->user_full_name : '-';
                })
                ->editColumn('created_at', function ($row) {
                    return $this->commonUtil->format_date($row->created_at, true);
                })
                ->rawColumns(['action', 'campaign_type', 'status'])
                ->make(true);
        }

        return view('crm::campaigns.index');
    }

    /**
     * Show the form for creating a new campaign.
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

        return view('crm::campaigns.create', compact('leads', 'customers', 'suppliers'));
    }

    /**
     * Store a newly created campaign.
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
                'name', 'campaign_type', 'subject', 'body', 'recipient_type', 'status'
            ]);

            $input['business_id'] = $business_id;
            $input['created_by'] = auth()->user()->id;

            // Handle recipients
            if ($request->recipient_type === 'selected') {
                $input['recipients'] = $request->recipients;
            }

            // Handle scheduled_at
            if ($request->status === 'scheduled' && $request->scheduled_at) {
                $input['scheduled_at'] = $this->commonUtil->uf_date($request->scheduled_at, true);
            }

            // Handle attachments
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('crm/campaigns', 'public');
                    $attachments[] = $path;
                }
                $input['attachments'] = $attachments;
            }

            $campaign = CrmCampaign::create($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.campaign_added_successfully'),
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
     * Display the specified campaign.
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

        $campaign = CrmCampaign::forBusiness($business_id)
            ->with(['createdBy'])
            ->findOrFail($id);

        return view('crm::campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified campaign.
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

        $campaign = CrmCampaign::forBusiness($business_id)->findOrFail($id);
        $leads = CrmLead::forBusiness($business_id)->notConverted()->pluck('name', 'id');
        $customers = Contact::where('business_id', $business_id)->where('type', 'customer')->pluck('name', 'id');
        $suppliers = Contact::where('business_id', $business_id)->where('type', 'supplier')->pluck('name', 'id');

        return view('crm::campaigns.edit', compact('campaign', 'leads', 'customers', 'suppliers'));
    }

    /**
     * Update the specified campaign.
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
            $campaign = CrmCampaign::forBusiness($business_id)->findOrFail($id);

            $input = $request->only([
                'name', 'campaign_type', 'subject', 'body', 'recipient_type', 'status'
            ]);

            // Handle recipients
            if ($request->recipient_type === 'selected') {
                $input['recipients'] = $request->recipients;
            }

            // Handle scheduled_at
            if ($request->status === 'scheduled' && $request->scheduled_at) {
                $input['scheduled_at'] = $this->commonUtil->uf_date($request->scheduled_at, true);
            }

            // Handle attachments
            if ($request->hasFile('attachments')) {
                $attachments = $campaign->attachments ?? [];
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('crm/campaigns', 'public');
                    $attachments[] = $path;
                }
                $input['attachments'] = $attachments;
            }

            $campaign->update($input);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.campaign_updated_successfully'),
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
     * Remove the specified campaign.
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
            $campaign = CrmCampaign::forBusiness($business_id)->findOrFail($id);
            $campaign->delete();

            $output = [
                'success' => true,
                'msg' => __('crm::lang.campaign_deleted_successfully'),
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
     * Send campaign notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendNotification($id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (!$this->moduleUtil->hasThePermissionInSubscription($business_id, 'crm_module')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $campaign = CrmCampaign::forBusiness($business_id)->findOrFail($id);

            // Get recipients based on type
            $recipients = $this->getRecipients($campaign, $business_id);

            $total_sent = 0;
            $total_failed = 0;

            foreach ($recipients as $recipient) {
                try {
                    if ($campaign->campaign_type === 'email') {
                        // Send email
                        $this->notificationUtil->sendEmailNotification(
                            $recipient['email'],
                            $campaign->subject,
                            $campaign->body
                        );
                    } else {
                        // Send SMS
                        $this->notificationUtil->sendSms(
                            $recipient['mobile'],
                            $campaign->body
                        );
                    }
                    $total_sent++;
                } catch (\Exception $e) {
                    $total_failed++;
                }
            }

            $campaign->update([
                'status' => 'sent',
                'sent_at' => now(),
                'total_sent' => $total_sent,
                'total_failed' => $total_failed,
            ]);

            $output = [
                'success' => true,
                'msg' => __('crm::lang.campaign_sent_successfully', ['sent' => $total_sent, 'failed' => $total_failed]),
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
     * Get recipients for campaign.
     *
     * @param  CrmCampaign  $campaign
     * @param  int  $business_id
     * @return array
     */
    private function getRecipients(CrmCampaign $campaign, $business_id)
    {
        $recipients = [];

        switch ($campaign->recipient_type) {
            case 'all_customers':
                $contacts = Contact::where('business_id', $business_id)
                    ->where('type', 'customer')
                    ->get(['name', 'email', 'mobile']);
                foreach ($contacts as $contact) {
                    $recipients[] = [
                        'name' => $contact->name,
                        'email' => $contact->email,
                        'mobile' => $contact->mobile,
                    ];
                }
                break;

            case 'all_suppliers':
                $contacts = Contact::where('business_id', $business_id)
                    ->where('type', 'supplier')
                    ->get(['name', 'email', 'mobile']);
                foreach ($contacts as $contact) {
                    $recipients[] = [
                        'name' => $contact->name,
                        'email' => $contact->email,
                        'mobile' => $contact->mobile,
                    ];
                }
                break;

            case 'all_leads':
                $leads = CrmLead::forBusiness($business_id)
                    ->notConverted()
                    ->get(['name', 'email', 'mobile']);
                foreach ($leads as $lead) {
                    $recipients[] = [
                        'name' => $lead->name,
                        'email' => $lead->email,
                        'mobile' => $lead->mobile,
                    ];
                }
                break;

            case 'selected':
                // Recipients are stored in the campaign
                if (!empty($campaign->recipients)) {
                    $recipients = $campaign->recipients;
                }
                break;
        }

        return $recipients;
    }
}
