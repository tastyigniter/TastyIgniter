<?php namespace Admin\Models;

use Admin\Notifications\CustomerRegistered;
use DB;
use Hash;
use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Igniter\Flame\Auth\Models\User as AuthUserModel;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Notifications\Notifiable;
use Model;

/**
 * Customers Model Class
 *
 * @package Admin
 */
class Customers_model extends AuthUserModel
{
    use LogsActivity;
    use Purgeable;
    use Notifiable;

    protected static $logAttributes = ['name'];

//    protected static $mailables = [
//        'Igniter\Mail\CustomerRegistration' => ['registration', 'registration_alert'],
//    ];

    const CREATED_AT = 'date_added';

    /**
     * @var string The database table name
     */
    protected $table = 'customers';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'customer_id';

    protected $fillable = ['first_name', 'last_name', 'email', 'telephone', 'newsletter'];

    protected $hidden = ['password'];

    public $timestamps = TRUE;

    public $relation = [
        'hasMany'       => [
            'addresses'    => ['Admin\Models\Addresses_model', 'delete' => TRUE],
            'orders'       => ['Admin\Models\Orders_model', 'delete' => TRUE],
            'reservations' => ['Admin\Models\Reservations_model', 'delete' => TRUE],
        ],
        'belongsTo'     => [
            'group'             => 'Admin\Models\Customer_groups_model',
            'address'           => 'Admin\Models\Addresses_model',
            'security_question' => 'Admin\Models\Security_questions_model',
        ],
        'belongsToMany' => [
            'security_question' => 'Admin\Models\Security_questions_model',
        ],
        'morphMany'     => [
            'messages' => ['System\Models\Message_meta_model', 'name' => 'messageable'],
        ],
    ];

    public $purgeable = ['addresses'];

    public static function getDropdownOptions()
    {
        return static::isEnabled()->selectRaw('concat(first_name, " ", last_name) as fullname')->dropdown('fullname');
    }

    //
    // Accessors & Mutators
    //

    public function getCustomerNameAttribute($value)
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    public function getDateAddedAttribute($value)
    {
        return day_elapsed($value);
    }

    //
    // Scopes
    //

    /**
     * Filter database records
     *
     * @param $query
     * @param array $filter an associative array of field/value pairs
     *
     * @return $this
     */
    public function scopeFilter($query, $filter = [])
    {
        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['first_name', 'last_name', 'email']);
        }

        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('status', $filter['filter_status']);
        }

        if (!empty($filter['filter_date'])) {
            $date = explode('-', $filter['filter_date']);
            $query->whereYear('date_added', $date[0]);
            $query->whereMonth('date_added', $date[1]);
        }

        return $query;
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }

    //
    // Events
    //

    public function beforeSave()
    {
        if (!empty($this->attributes['password']))
            $this->password = Hash::make($this->attributes['password']);
    }

    public function afterCreate()
    {
        $this->saveCustomerGuestOrder();
        $this->sendRegistrationEmail();
    }

    public function afterSave()
    {
        $this->restorePurgedValues();

        if (!$this->exists)
            return;

        if (array_key_exists('addresses', $this->attributes))
            $this->saveAddress($this->getKey(), $this->attributes['addresses']);
    }

    //
    // Helpers
    //

    public function getCustomerName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function listAddresses()
    {
        return $this->addresses()->with(['country'])->get()->groupBy(function ($address) {
            return $address->getKey();
        });
    }

    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * List all customers matching the filter,
     * to fill select auto-complete options
     *
     * @param array $filter
     *
     * @return array
     */
    public static function getAutoComplete($filter = [])
    {
        if (is_array($filter) AND !empty($filter)) {
            $query = self::query()->select('customer_id', 'first_name', 'last_name')
                         ->selectRaw('concat(first_name, " ", last_name) AS customer_name');

            if (!empty($filter['customer_name'])) {
                $query->like('CONCAT(first_name, last_name)', $filter['customer_name']);
            }

            if (!empty($filter['customer_id'])) {
                $query->where('customer_id', $filter['customer_id']);
            }

            $limit = isset($filter['limit']) ? $filter['limit'] : 20;
            if ($results = $query->take($limit)->get()) {
                foreach ($results as $result) {
                    $return['results'][] = [
                        'id'   => $result['customer_id'],
                        'text' => utf8_encode($result['customer_name']),
                    ];
                }
            }
            else {
                $return['results'] = ['id' => '0', 'text' => lang('text_no_match')];
            }

            return $return;
        }
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
     * Sets the reset password columns to NULL
     *
     * @param string $code
     *
     * @return bool
     */
    public function clearResetPasswordCode($code)
    {
        if (is_null($code))
            return FALSE;

        $query = $this->where('reset_code', $code);

        if ($row = $query->isEnabled()->first()) {
            $query->update([
                'reset_code' => null,
                'reset_time' => null,
            ]);

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Reset a customer password,
     * new password is sent to registered email
     *
     * @param string $email
     *
     * @return bool
     */
    public function resetPassword($email)
    {
        if (!is_string($email))
            return FALSE;

        $query = $this->newQuery()->where('email', $email);
        if (!$customerModel = $query->isEnabled()->first())
            return FALSE;

        $update = [
            'reset_code' => $this->createResetCode($customerModel),
            'reset_time' => mdate('%Y-%m-%d %H:%i:%a', time()),
        ];

        $updated = $this->newQuery()->where('email', $email)->update($update);
        if ($updated < 1)
            return FALSE;

        $mail_data['first_name'] = $customerModel->first_name;
        $mail_data['last_name'] = $customerModel->last_name;
        $mail_data['reset_link'] = root_url('account/reset?code='.$update['reset_code']);
        $mail_data['account_login_link'] = root_url('account/login');

        $this->sendMail($email, 'password_reset_request', $mail_data);

        return TRUE;
    }

    /**
     * Sets the new password on customer requested reset
     *
     * @param $identity
     * @param $credentials
     *
     * @return bool
     */
    public function completeResetPassword($identity, $credentials)
    {
        $code = $credentials['reset_code'];
        $password = $credentials['password'];

        $customerModel = $this->newQuery()
                              ->where($this->getAuthIdentifierName(), $identity)
                              ->where('reset_code', $code)->first();

        if (is_null($customerModel))
            return FALSE;

        $customerModel->password = $this->getHasher()->make($password);
        $customerModel->reset_code = null;
        $customerModel->save();

        $mail_data['first_name'] = $customerModel->first_name;
        $mail_data['last_name'] = $customerModel->last_name;
        $mail_data['created_password'] = str_repeat('*', strlen($password));
        $mail_data['account_login_link'] = root_url('account/login');

        $this->sendMail($this->getReminderEmail(), 'password_reset', $mail_data);

        return TRUE;
    }

    /**
     * Update the customer password
     */
    public function updatePassword($identity, array $credentials)
    {
        $password = $credentials['password'];

        $model = $this->newQuery()
                      ->where($this->getAuthIdentifierName(), $identity)->first();

        if (is_null($model))
            return FALSE;

        $model->password = $this->getHasher()->make($password);
    }

    /**
     * Send email to customer
     *
     * @param string $email
     * @param array
     * @param array $data
     *
     * @return bool
     */
//    public function sendMail($email, $template = [], $data = [])
//    {
//        if (!$template OR !strlen($email) OR !$data)
//            return FALSE;
//
////        if (!is_array($template)) {
////            $this->load->model('Mail_templates_model');
////            $template = $this->Mail_templates_model->getDefaultTemplateData($template);
////        }
//
//        if (!isset($template['subject'], $template['body']))
//            return FALSE;
//
//        $this->ci()->load->library('email');
//        $this->ci()->email->initialize();
//        $this->ci()->email->set_template($template, $data);
//        $this->ci()->email->from($this->ci()->config->item('site_email'), $this->ci()->config->item('site_name'));
//        $this->ci()->email->to(strtolower($email));
//
//        if ($this->ci()->email->send()) {
//            return TRUE;
//        } else {
//            log_message('debug', $this->ci()->email->print_debugger(['headers']));
//        }
//    }

    /**
     * Send the registration confirmation email
     *
     * @return bool FALSE on failure
     */
    public function sendRegistrationEmail()
    {
        if (empty($this->email))
            return FALSE;

//        $mail_data['first_name'] = $this->first_name;
//        $mail_data['last_name'] = $this->last_name;
//        $mail_data['email'] = $this->email;
//        $mail_data['account_login_link'] = root_url('account/login');

        $this->notify(new CustomerRegistered($this));

//        $config = setting('registration_email', ['customer', 'admin']);
//        if (in_array('customer', $config))
//            $this->sendMail($mail_data['email'], 'registration', $mail_data);

//        if (in_array('admin', $config))
//            $this->sendMail('registration_alert');
//            $this->sendMail($this->config->item('site_email'), 'registration_alert', $mail_data);
    }

    public function routeNotificationForMail()
    {
        $emails = [];
        $config = setting('registration_email', ['customer', 'admin']);
        if (in_array('customer', $config)) {
            $emails[] = $this->email;
        }
        else {
            $emails[] = setting('site_email');
        }

        return $emails;
    }
}