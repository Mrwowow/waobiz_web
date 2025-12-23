<?php

namespace Modules\Crm\Http\Controllers;

use App\Utils\ModuleUtil;
use App\Utils\Util;
use Illuminate\Routing\Controller;
use Menu;
use Modules\Crm\Entities\CrmSchedule;

class DataController extends Controller
{
    /**
     * Superadmin package permissions
     *
     * @return array
     */
    public function superadmin_package()
    {
        return [
            [
                'name' => 'crm_module',
                'label' => __('crm::lang.crm_module'),
                'default' => false,
            ],
        ];
    }

    /**
     * Defines user permissions for the module.
     *
     * @return array
     */
    public function user_permissions()
    {
        return [
            [
                'value' => 'crm.access_crm',
                'label' => __('crm::lang.access_crm'),
                'default' => false,
            ],
            [
                'value' => 'crm.access_leads',
                'label' => __('crm::lang.access_leads'),
                'default' => false,
            ],
            [
                'value' => 'crm.add_leads',
                'label' => __('crm::lang.add_leads'),
                'default' => false,
            ],
            [
                'value' => 'crm.edit_leads',
                'label' => __('crm::lang.edit_leads'),
                'default' => false,
            ],
            [
                'value' => 'crm.delete_leads',
                'label' => __('crm::lang.delete_leads'),
                'default' => false,
            ],
            [
                'value' => 'crm.convert_leads',
                'label' => __('crm::lang.convert_leads'),
                'default' => false,
            ],
            [
                'value' => 'crm.access_schedules',
                'label' => __('crm::lang.access_schedules'),
                'default' => false,
            ],
            [
                'value' => 'crm.add_schedules',
                'label' => __('crm::lang.add_schedules'),
                'default' => false,
            ],
            [
                'value' => 'crm.edit_schedules',
                'label' => __('crm::lang.edit_schedules'),
                'default' => false,
            ],
            [
                'value' => 'crm.delete_schedules',
                'label' => __('crm::lang.delete_schedules'),
                'default' => false,
            ],
            [
                'value' => 'crm.access_campaigns',
                'label' => __('crm::lang.access_campaigns'),
                'default' => false,
            ],
            [
                'value' => 'crm.add_campaigns',
                'label' => __('crm::lang.add_campaigns'),
                'default' => false,
            ],
            [
                'value' => 'crm.edit_campaigns',
                'label' => __('crm::lang.edit_campaigns'),
                'default' => false,
            ],
            [
                'value' => 'crm.delete_campaigns',
                'label' => __('crm::lang.delete_campaigns'),
                'default' => false,
            ],
            [
                'value' => 'crm.send_campaigns',
                'label' => __('crm::lang.send_campaigns'),
                'default' => false,
            ],
            [
                'value' => 'crm.access_contact_login',
                'label' => __('crm::lang.access_contact_login'),
                'default' => false,
            ],
            [
                'value' => 'crm.add_contact_login',
                'label' => __('crm::lang.add_contact_login'),
                'default' => false,
            ],
            [
                'value' => 'crm.edit_contact_login',
                'label' => __('crm::lang.edit_contact_login'),
                'default' => false,
            ],
            [
                'value' => 'crm.delete_contact_login',
                'label' => __('crm::lang.delete_contact_login'),
                'default' => false,
            ],
            [
                'value' => 'crm.access_proposals',
                'label' => __('crm::lang.access_proposals'),
                'default' => false,
            ],
            [
                'value' => 'crm.add_proposals',
                'label' => __('crm::lang.add_proposals'),
                'default' => false,
            ],
            [
                'value' => 'crm.edit_proposals',
                'label' => __('crm::lang.edit_proposals'),
                'default' => false,
            ],
            [
                'value' => 'crm.delete_proposals',
                'label' => __('crm::lang.delete_proposals'),
                'default' => false,
            ],
            [
                'value' => 'crm.send_proposals',
                'label' => __('crm::lang.send_proposals'),
                'default' => false,
            ],
            [
                'value' => 'crm.access_sources',
                'label' => __('crm::lang.access_sources'),
                'default' => false,
            ],
            [
                'value' => 'crm.access_life_stages',
                'label' => __('crm::lang.access_life_stages'),
                'default' => false,
            ],
            [
                'value' => 'crm.access_reports',
                'label' => __('crm::lang.access_reports'),
                'default' => false,
            ],
        ];
    }

    /**
     * Parses notification message from database.
     *
     * @return array
     */
    public function parse_notification($notification)
    {
        $notification_datas = [];

        if ($notification->type == 'Modules\Crm\Notifications\NewFollowupAssignedNotification') {
            $data = $notification->data;
            $schedule = CrmSchedule::with('createdBy')->find($data['schedule_id']);

            if (!empty($schedule)) {
                $msg = __(
                    'crm::lang.new_followup_assigned_notification',
                    [
                        'created_by' => $schedule->createdBy->user_full_name,
                        'title' => $schedule->title,
                    ]
                );

                $link = action([\Modules\Crm\Http\Controllers\ScheduleController::class, 'index']);

                $notification_datas = [
                    'msg' => $msg,
                    'icon_class' => 'fas fa-calendar-check bg-green',
                    'link' => $link,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            }
        }

        return $notification_datas;
    }

    /**
     * Adds CRM menus
     *
     * @return null
     */
    public function modifyAdminMenu()
    {
        $business_id = session()->get('user.business_id');
        $module_util = new ModuleUtil();
        $commonUtil = new Util();
        $is_admin = $commonUtil->is_admin(auth()->user(), $business_id);

        $is_crm_enabled = (bool) $module_util->hasThePermissionInSubscription($business_id, 'crm_module');

        if ($is_crm_enabled) {
            Menu::modify(
                'admin-sidebar-menu',
                function ($menu) use ($is_admin) {
                    $menu->url(
                        action([\Modules\Crm\Http\Controllers\CrmController::class, 'index']),
                        __('crm::lang.crm'),
                        ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg>', 'active' => request()->segment(1) == 'crm']
                    )
                        ->order(85);
                }
            );
        }
    }
}
