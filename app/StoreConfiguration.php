<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreConfiguration extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_configurations';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'social_media' => 'array',
        'payment_methods' => 'array',
        'delivery_options' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // custom_css is now public for storefront styling
    ];

    /**
     * Get the business that owns the store configuration.
     */
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    /**
     * Scope a query to only include active stores.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get store by store name.
     *
     * @param  string  $storeName
     * @return \App\StoreConfiguration|null
     */
    public static function findByStoreName($storeName)
    {
        return self::where('store_name', $storeName)->first();
    }
}
