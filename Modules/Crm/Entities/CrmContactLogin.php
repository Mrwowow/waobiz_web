<?php

namespace Modules\Crm\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmContactLogin extends Authenticatable
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crm_contact_logins';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Get the contact for this login.
     */
    public function contact()
    {
        return $this->belongsTo(\App\Contact::class, 'contact_id');
    }

    /**
     * Get the user who created this login.
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    /**
     * Check if the login is a customer.
     */
    public function isCustomer()
    {
        return $this->contact && $this->contact->type === 'customer';
    }

    /**
     * Check if the login is a supplier.
     */
    public function isSupplier()
    {
        return $this->contact && $this->contact->type === 'supplier';
    }

    /**
     * Scope a query to filter by business.
     */
    public function scopeForBusiness($query, $business_id)
    {
        return $query->where('business_id', $business_id);
    }

    /**
     * Scope a query to only include active logins.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
