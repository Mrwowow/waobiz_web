<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmSchedule extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crm_schedules';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'recurrence_end_date' => 'date',
        'send_notification' => 'boolean',
        'is_recurring' => 'boolean',
    ];

    /**
     * Get the lead for this schedule.
     */
    public function lead()
    {
        return $this->belongsTo(CrmLead::class, 'lead_id');
    }

    /**
     * Get the contact for this schedule.
     */
    public function contact()
    {
        return $this->belongsTo(\App\Contact::class, 'contact_id');
    }

    /**
     * Get the user assigned to this schedule.
     */
    public function assignedTo()
    {
        return $this->belongsTo(\App\User::class, 'assigned_to');
    }

    /**
     * Get the user who created this schedule.
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    /**
     * Get the parent schedule for recurring schedules.
     */
    public function parentSchedule()
    {
        return $this->belongsTo(CrmSchedule::class, 'parent_schedule_id');
    }

    /**
     * Get the child schedules for recurring schedules.
     */
    public function childSchedules()
    {
        return $this->hasMany(CrmSchedule::class, 'parent_schedule_id');
    }

    /**
     * Get the contact name based on contact type.
     */
    public function getContactNameAttribute()
    {
        if ($this->contact_type === 'lead' && $this->lead) {
            return $this->lead->name;
        } elseif ($this->contact) {
            return $this->contact->name;
        }
        return null;
    }

    /**
     * Scope a query to filter by business.
     */
    public function scopeForBusiness($query, $business_id)
    {
        return $query->where('business_id', $business_id);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $start_date, $end_date)
    {
        return $query->whereBetween('start_datetime', [$start_date, $end_date]);
    }

    /**
     * Scope a query to get upcoming schedules.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_datetime', '>=', now())
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled');
    }

    /**
     * Scope a query to get overdue schedules.
     */
    public function scopeOverdue($query)
    {
        return $query->where('start_datetime', '<', now())
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled');
    }
}
