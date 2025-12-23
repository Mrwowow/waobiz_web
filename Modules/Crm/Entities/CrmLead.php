<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmLead extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crm_leads';

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
        'converted_at' => 'datetime',
    ];

    /**
     * Get the source for this lead.
     */
    public function source()
    {
        return $this->belongsTo(CrmSource::class, 'source_id');
    }

    /**
     * Get the life stage for this lead.
     */
    public function lifeStage()
    {
        return $this->belongsTo(CrmLifeStage::class, 'life_stage_id');
    }

    /**
     * Get the user assigned to this lead.
     */
    public function assignedTo()
    {
        return $this->belongsTo(\App\User::class, 'assigned_to');
    }

    /**
     * Get the user who created this lead.
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    /**
     * Get the contact this lead was converted to.
     */
    public function convertedContact()
    {
        return $this->belongsTo(\App\Contact::class, 'converted_contact_id');
    }

    /**
     * Get the user who converted this lead.
     */
    public function convertedBy()
    {
        return $this->belongsTo(\App\User::class, 'converted_by');
    }

    /**
     * Get the schedules for this lead.
     */
    public function schedules()
    {
        return $this->hasMany(CrmSchedule::class, 'lead_id');
    }

    /**
     * Get the proposals for this lead.
     */
    public function proposals()
    {
        return $this->hasMany(CrmProposal::class, 'lead_id');
    }

    /**
     * Check if the lead has been converted.
     */
    public function isConverted()
    {
        return !is_null($this->converted_contact_id);
    }

    /**
     * Scope a query to filter by business.
     */
    public function scopeForBusiness($query, $business_id)
    {
        return $query->where('business_id', $business_id);
    }

    /**
     * Scope a query to only include non-converted leads.
     */
    public function scopeNotConverted($query)
    {
        return $query->whereNull('converted_contact_id');
    }

    /**
     * Scope a query to only include converted leads.
     */
    public function scopeConverted($query)
    {
        return $query->whereNotNull('converted_contact_id');
    }
}
