<?php

namespace Admin\Models;

use Igniter\Flame\Database\Model;

class Payment_profiles_model extends Model
{
    public $timestamps = TRUE;

    public $table = 'payment_profiles';

    protected $primaryKey = 'payment_profile_id';

    public $casts = [
        'customer_id' => 'integer',
        'payment_id' => 'integer',
        'profile_data' => 'array',
        'is_primary' => 'boolean',
    ];

    public function afterCreate()
    {
        if ($this->is_primary) {
            $this->makePrimary();
        }
    }

    public function beforeUpdate()
    {
        if ($this->isDirty('is_primary')) {
            $this->makePrimary();
        }
    }

    public function setProfileData($profileData)
    {
        $this->profile_data = $profileData;
        $this->save();
    }

    public function hasProfileData()
    {
        return array_has((array)$this->profile_data, ['card_id', 'customer_id']);
    }

    /**
     * Makes this model the default
     * @return void
     */
    public function makePrimary()
    {
        $this->timestamps = FALSE;

        $this->newQuery()
            ->where('is_primary', '!=', FALSE)
            ->where('customer_id', $this->customer_id)
            ->update(['is_primary' => FALSE]);

        $this->newQuery()
            ->where('payment_profile_id', $this->payment_profile_id)
            ->where('customer_id', $this->customer_id)
            ->update(['is_primary' => TRUE]);

        $this->timestamps = TRUE;
    }

    public static function getPrimary($customer)
    {
        $profiles = self::applyCustomer($customer)->get();

        foreach ($profiles as $profile) {
            if ($profile->is_primary) {
                return $profile;
            }
        }

        return $profiles->first();
    }

    public static function customerHasProfile($customer)
    {
        return self::applyCustomer($customer)->count() > 0;
    }

    //
    // Scopes
    //

    public function scopeApplyCustomer($query, $customer)
    {
        if ($customer instanceof \Illuminate\Database\Eloquent\Model) {
            $customer = $customer->getKey();
        }

        return $query->where('customer_id', $customer);
    }
}