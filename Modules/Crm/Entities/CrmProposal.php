<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmProposal extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crm_proposals';

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
        'attachments' => 'array',
        'sent_at' => 'datetime',
        'viewed_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    /**
     * Get the lead for this proposal.
     */
    public function lead()
    {
        return $this->belongsTo(CrmLead::class, 'lead_id');
    }

    /**
     * Get the template used for this proposal.
     */
    public function template()
    {
        return $this->belongsTo(CrmProposalTemplate::class, 'template_id');
    }

    /**
     * Get the user who created this proposal.
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    /**
     * Check if the proposal has been sent.
     */
    public function isSent()
    {
        return in_array($this->status, ['sent', 'viewed', 'accepted', 'rejected']);
    }

    /**
     * Check if the proposal has been viewed.
     */
    public function isViewed()
    {
        return in_array($this->status, ['viewed', 'accepted', 'rejected']);
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
}
