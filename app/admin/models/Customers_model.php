<?php

namespace Admin\Models;

use Carbon\Carbon;
use Exception;
use Igniter\Flame\Auth\Models\User as AuthUserModel;
use Igniter\Flame\Database\Traits\Purgeable;
use System\Traits\SendsMailTemplate;

/**
 * Customers Model Class
 */
class Customers_model extends AuthUserModel
{
    use Purgeable;
    use SendsMailTemplate;

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

    public $timestamps = true;

    public $relation = [
        'hasMany' => [
            'addresses' => ['Admin\Models\Addresses_model', 'delete' => true],
            'orders' => ['Admin\Models\Orders_model'],
            'reservations' => ['Admin\Models\Reservations_model'],
        ],
        'belongsTo' => [
            'group' => ['Admin\Models\Customer_groups_model', 'foreignKey' => 'customer_group_id'],
            'address' => 'Admin\Models\Addresses_model',
        ],
    ];

    protected $purgeable = ['addresses', 'send_invite'];

    public $appends = ['full_name'];

    protected $casts = [
        'customer_id' => 'integer',
        'address_id' => 'integer',
        'customer_group_id' => 'integer',
        'newsletter' => 'boolean',
        'status' => 'boolean',
        'is_activated' => 'boolean',
        'last_login' => 'datetime',
        'date_invited' => 'datetime',
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
        if (!$this->group || !$this->group->requiresApproval())
            return;

        if ($this->is_activated && $this->status)
            return;

        throw new Exception(sprintf(
            lang('admin::lang.customers.alert_customer_not_active'), $this->email
        ));
    }

    protected function afterCreate()
    {
        $this->saveCustomerGuestOrder();

        $this->restorePurgedValues();

        if ($this->send_invite) {
            $this->sendInvite();
        }
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
        return $this->pluckDates('created_at');
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
            return false;

        $this->reset_code = $resetCode = $this->generateResetCode();
        $this->reset_time = Carbon::now();
        $this->save();

        return $resetCode;
    }

    public function saveAddresses($addresses)
    {
        $customerId = $this->getKey();
        if (!is_numeric($customerId))
            return false;

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
        $query = false;

        if (is_numeric($this->customer_id) && !empty($this->email)) {
            $customer_id = $this->customer_id;
            $customer_email = $this->email;
            $update = ['customer_id' => $customer_id];

            Orders_model::where('email', $customer_email)->update($update);
            if ($orders = Orders_model::where('email', $customer_email)->get()) {
                foreach ($orders as $row) {
                    if (empty($row['order_id'])) continue;

                    if ($row['order_type'] == '1' && !empty($row['address_id'])) {
                        Addresses_model::where('address_id', $row['address_id'])->update($update);
                    }
                }
            }

            Reservations_model::where('email', $customer_email)->update($update);

            $query = true;
        }

        return $query;
    }

    protected function sendInvite()
    {
        $this->bindEventOnce('model.mailGetData', function ($view, $recipientType) {
            if ($view === 'admin::_mail.invite_customer') {
                $this->reset_code = $inviteCode = $this->generateResetCode();
                $this->reset_time = now();
                $this->save();

                return ['invite_code' => $inviteCode];
            }
        });

        $this->mailSend('admin::_mail.invite_customer');
    }

    public function mailGetRecipients($type)
    {
        return [
            [$this->email, $this->full_name],
        ];
    }

    public function mailGetData()
    {
        $model = $this->fresh();

        return array_merge($model->toArray(), [
            'customer' => $model,
            'full_name' => $model->full_name,
            'email' => $model->email,
        ]);
    }
}
