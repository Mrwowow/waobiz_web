<?php

namespace Modules\Crm\Utils;

use Illuminate\Support\Facades\DB;

class CrmUtil
{
    /**
     * Get follow ups for given date range
     *
     * @param  \App\User  $user
     * @param  string  $start_date
     * @param  string  $end_date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getFollowUpForGivenDate($user, $start_date = null, $end_date = null)
    {
        $query = \Modules\Crm\Entities\Schedule::with(['customer'])
            ->where('business_id', $user->business_id);

        if (!$user->can('crm.access_all_schedule') && $user->can('crm.access_own_schedule')) {
            $query->where(function ($qry) use ($user) {
                $qry->whereHas('users', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->orWhere('created_by', $user->id);
            });
        }

        if (!empty($start_date)) {
            $query->whereDate('start_datetime', '>=', $start_date);
        }

        if (!empty($end_date)) {
            $query->whereDate('start_datetime', '<=', $end_date);
        }

        return $query;
    }

    /**
     * Add a follow up
     *
     * @param  array  $params
     * @param  \App\User  $user
     * @return \Modules\Crm\Entities\Schedule
     */
    public function addFollowUp($params, $user)
    {
        $schedule = new \Modules\Crm\Entities\Schedule();
        $schedule->business_id = $user->business_id;
        $schedule->created_by = $user->id;
        $schedule->title = $params['title'];
        $schedule->contact_id = $params['contact_id'];
        $schedule->description = $params['description'] ?? null;
        $schedule->schedule_type = $params['schedule_type'];
        $schedule->notify_before = $params['notify_before'] ?? null;
        $schedule->status = $params['status'] ?? null;
        $schedule->start_datetime = $params['start_datetime'];
        $schedule->end_datetime = $params['end_datetime'];
        $schedule->allow_notification = $params['allow_notification'] ?? 1;
        $schedule->notify_via = $params['notify_via'] ?? ['sms' => 0, 'mail' => 1];
        $schedule->notify_type = $params['notify_type'] ?? 'hour';
        $schedule->followup_additional_info = $params['followup_additional_info'] ?? null;
        $schedule->followup_category_id = $params['followup_category_id'] ?? null;
        $schedule->save();

        if (!empty($params['user_id'])) {
            $schedule->users()->sync($params['user_id']);
        }

        return $schedule;
    }

    /**
     * Update a follow up
     *
     * @param  int  $follow_up_id
     * @param  array  $params
     * @param  \App\User  $user
     * @return \Modules\Crm\Entities\Schedule
     */
    public function updateFollowUp($follow_up_id, $params, $user)
    {
        $schedule = \Modules\Crm\Entities\Schedule::where('business_id', $user->business_id)
            ->findOrFail($follow_up_id);

        $schedule->title = $params['title'];
        $schedule->contact_id = $params['contact_id'];
        $schedule->description = $params['description'] ?? $schedule->description;
        $schedule->schedule_type = $params['schedule_type'];
        $schedule->notify_before = $params['notify_before'] ?? $schedule->notify_before;
        $schedule->status = $params['status'] ?? $schedule->status;
        $schedule->start_datetime = $params['start_datetime'];
        $schedule->end_datetime = $params['end_datetime'];
        $schedule->allow_notification = $params['allow_notification'] ?? $schedule->allow_notification;
        $schedule->notify_via = $params['notify_via'] ?? $schedule->notify_via;
        $schedule->notify_type = $params['notify_type'] ?? $schedule->notify_type;
        $schedule->followup_additional_info = $params['followup_additional_info'] ?? $schedule->followup_additional_info;
        $schedule->followup_category_id = $params['followup_category_id'] ?? $schedule->followup_category_id;
        $schedule->save();

        if (!empty($params['user_id'])) {
            $schedule->users()->sync($params['user_id']);
        }

        return $schedule;
    }

    /**
     * Get leads list query
     *
     * @param  int  $business_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getLeadsListQuery($business_id)
    {
        return \App\Contact::with(['source', 'lifeStage', 'leadUsers'])
            ->where('business_id', $business_id)
            ->where('type', 'lead')
            ->select([
                'contacts.contact_id',
                'contacts.name',
                'contacts.supplier_business_name',
                'contacts.email',
                'contacts.mobile',
                'contacts.tax_number',
                'contacts.created_at',
                'contacts.custom_field1',
                'contacts.custom_field2',
                'contacts.custom_field3',
                'contacts.custom_field4',
                'contacts.custom_field5',
                'contacts.custom_field6',
                'contacts.alternate_number',
                'contacts.landline',
                'contacts.dob',
                'contacts.contact_status',
                'contacts.type',
                'contacts.custom_field7',
                'contacts.custom_field8',
                'contacts.custom_field9',
                'contacts.custom_field10',
                'contacts.id',
                'contacts.business_id',
                'contacts.crm_source',
                'contacts.crm_life_stage',
                'contacts.address_line_1',
                'contacts.address_line_2',
                'contacts.city',
                'contacts.state',
                'contacts.country',
                'contacts.zip_code',
            ]);
    }
}
