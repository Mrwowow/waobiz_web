<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmCampaign extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crm_campaigns';

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
        'recipients' => 'array',
        'attachments' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    /**
     * Get the user who created this campaign.
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    /**
     * Check if campaign is email type.
     */
    public function isEmail()
    {
        return $this->campaign_type === 'email';
    }

    /**
     * Check if campaign is SMS type.
     */
    public function isSms()
    {
        return $this->campaign_type === 'sms';
    }

    /**
     * Check if campaign has been sent.
     */
    public function isSent()
    {
        return $this->status === 'sent';
    }

    /**
     * Scope a query to filter by business.
     */
    public function scopeForBusiness($query, $business_id)
    {
        return $query->where('business_id', $business_id);
    }

    /**
     * Scope a query to filter by campaign type.
     */
    public function scopeType($query, $type)
    {
        return $query->where('campaign_type', $type);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
