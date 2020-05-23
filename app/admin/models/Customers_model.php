<?php namespace Admin\Models;

use Carbon\Carbon;
use Exception;
use Igniter\Flame\Auth\Models\User as AuthUserModel;
use Igniter\Flame\Database\Traits\Purgeable;

/**
 * Customers Model Class
 *
 * @package Admin
 */
class Customers_model extends AuthUserModel
{
    use Purgeable;

    const UPDATED_AT = null;

    const CREATED_AT = 'date_added';

    /**
     * @var string The database table name
     */
    protected $table = 'customers';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'customer_id';

    protected $guarded = ['reset_code', 'activation_code', 'remember_token'];

    protected $hidden = ['password'];

    public $timestamps = TRUE;

    public $relation = [
        'hasMany' => [
            'addresses' => ['Admin\Models\Addresses_model', 'delete' => TRUE],
            'orders' => ['Admin\Models\Orders_model'],
            'reservations' => ['Admin\Models\Reservations_model'],
        ],
        'belongsTo' => [
            'group' => ['Admin\Models\Customer_groups_model', 'foreignKey' => 'customer_group_id'],
            'address' => 'Admin\Models\Addresses_model',
        ],
    ];

    protected $purgeable = ['addresses'];

    public $appends = ['full_name'];

    public $casts = [
        'customer_id' => 'integer',
        'address_id' => 'integer',
        'customer_group_id' => 'integer',
        'newsletter' => 'boolean',
        'status' => 'boolean',
        'is_activated' => 'boolean',
        'last_login' => 'datetime',
        'date_activated' => 'datetime',
        'reset_time' => 'datetime',
    ];

    public static function getDropdownOptions()
    {
        return static::isEnabled()->selectRaw('customer_id, concat(first_name, " ", last_name) as name')->dropdown('name');
    }

    //
    // Accessors & Mutators
    //

    public function getFullNameAttribute($value)
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    //
    // Scopes
    //

    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }

    //
    // Events
    //

    public function beforeLogin()
    {
        if (!$this->group OR !$this->group->requiresApproval())
            return;

        if ($this->is_activated OR $this->status)
            return;

        throw new Exception(sprintf(
            'Cannot login user "%s" until activated.', $this->email
        ));
    }

    protected function afterCreate()
    {
        $this->saveCustomerGuestOrder();
    }

    protected function afterSave()
    {
        $this->restorePurgedValues();

        if (!$this->exists)
            return;

        if (array_key_exists('addresses', $this->attributes))
            $this->saveAddresses($this->attributes['addresses']);
    }

    //
    // Helpers
    //

    public function enabled()
    {
        return $this->status;
    }

    public function getCustomerName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function listAddresses()
    {
        return $this->addresses()->get()->groupBy(function ($address) {
            return $address->getKey();
        });
    }

    /**
     * Return all customer registration dates
     *
     * @return array
     */
    public function getCustomerDates()
    {
        return $this->pluckDates('date_added');
    }

    /**
     * Reset a customer password,
     * new password is sent to registered email
     *
     * @return string Reset code
     */
    public function resetPassword()
    {
        if (!$this->enabled())
            return FALSE;

        $this->reset_code = $resetCode = $this->generateResetCode();
        $this->reset_time = Carbon::now();
        $this->save();

        return $resetCode;
    }

    public function saveAddresses($addresses)
    {
        $customerId = $this->getKey();
        if (!is_numeric($customerId))
            return FALSE;

        $idsToKeep = [];
        foreach ($addresses as $address) {
            $customerAddress = $this->addresses()->updateOrCreate(
                array_only($address, ['address_id']),
                array_except($address, ['address_id', 'customer_id'])
            );

            $idsToKeep[] = $customerAddress->getKey();
        }

        $this->addresses()->whereNotIn('address_id', $idsToKeep)->delete();
    }

    /**
     * Update guest orders, address and reservations
     * matching customer email
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public function saveCustomerGuestOrder()
    {
        $query = FALSE;

        if (is_numeric($this->customer_id) AND !empty($this->email)) {
            $customer_id = $this->customer_id;
            $customer_email = $this->email;
            $update = ['customer_id' => $customer_id];

            Orders_model::where('email', $customer_email)->update($update);
            if ($orders = Orders_model::where('email', $customer_email)->get()) {
                foreach ($orders as $row) {
                    if (empty($row['order_id'])) continue;

                    Coupons_history_model::where('order_id', $row['order_id'])->update($update);

                    if ($row['order_type'] == '1' AND !empty($row['address_id'])) {
                        Addresses_model::where('address_id', $row['address_id'])->update($update);
                    }
                }
            }

            Reservations_model::where('email', $customer_email)->update($update);

            $query = TRUE;
        }

        return $query;
    }
}
