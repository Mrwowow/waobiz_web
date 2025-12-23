<?php

namespace Modules\Crm\Entities;

use Illuminate\Database\Eloquent\Model;

class CrmSource extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crm_sources';

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
        'is_active' => 'boolean',
    ];

    /**
     * Get the leads for this source.
     */
    public function leads()
    {
        return $this->hasMany(CrmLead::class, 'source_id');
    }

    /**
     * Get the user who created this source.
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    /**
     * Scope a query to only include active sources.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by business.
     */
    public function scopeForBusiness($query, $business_id)
    {
        return $query->where('business_id', $business_id);
    }
}
