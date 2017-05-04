<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use Igniter\Database\Model;

/**
 * Customers Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Customers_model.php
 * @link           http://docs.tastyigniter.com
 */
class Customers_model extends Model
{
    use \Igniter\Traits\UserTrait;

    /**
     * @var string The database table name
     */
    protected $table = 'customers';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'customer_id';

    protected $fillable = ['customer_id', 'first_name', 'last_name', 'email', 'password', 'salt', 'telephone', 'address_id',
        'security_question_id', 'security_answer', 'newsletter', 'customer_group_id', 'ip_address', 'date_added', 'status', 'cart'];

    public $timestamps = TRUE;

    const CREATED_AT = 'date_added';

    public $belongsTo = [
        'security_question' => 'Security_questions_model',
    ];

    public function security_question()
    {
        return $this->belongsTo('Security_questions_model');
    }

    /**
     * @var string[] The names of callback methods which
     * will be called after the insert method.
     */
//	protected $afterCreate = array('sendRegistrationEmail', 'saveCustomerGuestOrder');

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
        if (!empty($filter['filter_search'])) {
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

    public function getCustomerName()
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

    /**
     * Return all customers
     *
     * @return array
     */
    public function getCustomers()
    {
        return $this->getAsArray();
    }

    /**
     * Find a single customer by customer_id
     *
     * @param $customer_id
     *
     * @return array
     */
    public function getCustomer($customer_id)
    {
        if (is_numeric($customer_id)) {
            return $this->findOrNew($customer_id)->toArray();
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
     * Return all customers email or id,
     * to use when sending messages to customers
     *
     * @param $type
     *
     * @return array
     */
    public function getCustomersForMessages($type)
    {
        $result = $this->select('customer_id, email, status')->isEnabled()->getAsArray();

        return $this->getEmailOrIdFromResult($result, $type);
    }

    /**
     * Return specified customer email or id by customer_id,
     * to use when sending messages to customers
     *
     * @param $type
     * @param $customer_id
     *
     * @return array
     */
    public function getCustomerForMessages($type, $customer_id)
    {
        if (!empty($customer_id) AND is_array($customer_id)) {
            $result = $this->select('customer_id, email, status')
                           ->whereIn('customer_id', $customer_id)->isEnabled()->getAsArray();

            $result = $this->getEmailOrIdFromResult($result, $type);

            return $result;
        }
    }

    /**
     * Return all customers email or id by customer_group_id,
     * to use when sending messages to customers
     *
     * @param $type
     * @param $customer_group_id
     *
     * @return array
     */
    public function getCustomersByGroupIdForMessages($type, $customer_group_id)
    {
        if (is_numeric($customer_group_id)) {
            $result = $this->selectRaw('customer_id, email, customer_group_id, status')
                           ->where('customer_group_id', $customer_group_id)->isEnabled()->getAsArray();

            return $this->getEmailOrIdFromResult($result, $type);
        }
    }

    /**
     * Return all subscribed customers email or id,
     * to use when sending messages to customers
     *
     * @param $type
     *
     * @return array
     */
    public function getCustomersByNewsletterForMessages($type)
    {
        $result = $this->selectRaw('customer_id, email, newsletter, status')
                       ->where('newsletter', '1')->isEnabled()->getAsArray();

        $result = $this->getEmailOrIdFromResult($result, $type);

        $this->load->model('Extensions_model');
        $newsletter = $this->Extensions_model->getExtension('newsletter');
        if ($type === 'email' AND !empty($newsletter['ext_data']['subscribe_list'])) {
            $result = array_merge($result, $newsletter['ext_data']['subscribe_list']);
        }

        return $result;
    }

    /**
     * @param $query
     *
     * @param $type
     * @param array $result
     *
     * @return array
     */
    protected function getEmailOrIdFromResult($result, $type)
    {
        if (!empty($result)) {
            foreach ($result as $row) {
                $result[] = ($type == 'email') ? $row['email'] : $row['customer_id'];
            }
        }

        return $result;
    }

    /**
     * Find a single customer by email
     *
     * @param string $email
     *
     * @return array
     */
    public function getCustomerByEmail($email)
    {
        return $this->where('email', strtolower($email))->firstAsArray();
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

        $queryBuilder = $this->where('reset_code', $code);

        if ($row = $queryBuilder->isEnabled()->firstAsArray()) {
            $queryBuilder->update([
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
     * @param int $customer_id
     * @param array $reset
     *
     * @return bool
     */
    public function resetPassword($customer_id, $reset = [])
    {
        if (!is_numeric($customer_id) OR !isset($reset['email']))
            return FALSE;

        $email = strtolower($reset['email']);
        $query = $this->where('customer_id', $customer_id);
        $query->where('email', $email);

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
        $mail_data['reset_link'] = root_url('account/login'.$update['reset_code']);
        $mail_data['account_login_link'] = root_url('account/login');

        $this->load->model('Mail_templates_model');
        $mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'password_reset_request');
        $this->sendMail($email, $mail_template, $mail_data);

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

        $this->load->model('Mail_templates_model');
        $mail_template = $this->Mail_templates_model->getDefaultTemplateData('password_reset');
        $this->sendMail($this->getReminderEmail(), $mail_template, $mail_data);

        return TRUE;
    }

    /**
     * Update the customer password
     */
    public function updatePassword()
    {
    }

    /**
     * List all customers matching the filter,
     * to fill select auto-complete options
     *
     * @param array $filter
     *
     * @return array
     */
    public function getAutoComplete($filter = [])
    {
        if (is_array($filter) AND !empty($filter)) {
            $queryBuilder = $this->select('customer_id', 'first_name', 'last_name');

            if (!empty($filter['customer_name'])) {
                $queryBuilder->like('CONCAT(first_name, last_name)', $filter['customer_name']);
            }

            if (!empty($filter['customer_id'])) {
                $queryBuilder->where('customer_id', $filter['customer_id']);
            }

            return $queryBuilder->getAsArray();
        }
    }

    /**
     * Create a new or update existing customer
     *
     * @param int $customer_id
     * @param array $save
     *
     * @return bool|int The $customer_id of the affected row, or FALSE on failure
     */
    public function saveCustomer($customer_id, $save = [])
    {
        if (empty($save)) return FALSE;

        $save['address_id'] = isset($save['address_id']) ? $save['address_id'] : '';

        if (isset($save['password'])) {
            $save['password'] = $this->getHasher()->make($save['password']);
        }

        $customerModel = $this->findOrNew($customer_id);

        if ($saved = $customerModel->fill($save)->save()) {
            if (isset($save['address'])) {
                $this->saveAddress($customer_id, $save['address']);
            }
        }

        return $saved ? $customerModel->getKey() : $saved;
    }

    /**
     * Update guest orders, address and reservations
     * matching customer email
     *
     * @param array $save
     * @param int $customer_id
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public function saveCustomerGuestOrder($save = [], $customer_id)
    {
        $query = FALSE;

        if (is_numeric($customer_id) AND !empty($save['email'])) {
            $customer_email = $save['email'];
            $this->load->model('Addresses_model');
            $this->load->model('Coupons_model');
            $this->load->model('Coupons_history_model');
            $this->load->model('Orders_model');
            $this->load->model('Reservations_model');

            $update = ['customer_id' => $customer_id];

            if ($orders = $this->Orders_model->where('email', $customer_email)->getAsArray()) {
                foreach ($orders as $row) {
                    if (empty($row['order_id'])) continue;

                    $this->Orders_model->where('email', $customer_email)
                                       ->where('order_id', $row['order_id'])->update($update);

                    if ($row['order_type'] == '1' AND !empty($row['address_id'])) {
                        $this->Addresses_model->where('address_id', $row['address_id'])->update($update);
                    }

                    if (!empty($row['payment'])) {
                        $this->queryBuilder()->table('pp_payments')->where('order_id', $row['order_id'])
                             ->update(['customer_id' => $customer_id]);
                    }

                    $this->Coupons_history_model->where('order_id', $row['order_id'])->update($update);
                }
            }

            if ($reservation = $this->Reservations_model->where('email', $customer_email)->first()) {
                $this->Reservations_model->where('email', $customer_email)->update($update);
            }

            $query = TRUE;
        }

        return $query;
    }

    /**
     * Create a new or update existing customer address
     *
     * @param int $customer_id
     * @param array $addresses an array of one or multiple address array
     */
    public function saveAddress($customer_id, $addresses = [])
    {
        if (is_numeric($customer_id) AND !empty($addresses)) {
            $this->load->model('Addresses_model');
            $this->Addresses_model->find($customer_id)->delete();

            foreach ($addresses as $key => $address) {
                if (!empty($address['address_1'])) {
                    $this->Addresses_model->saveAddress($customer_id, $address);
                }
            }
        }
    }

    /**
     * Delete a single or multiple customer by customer_id
     *
     * @param string|array $customer_id
     *
     * @return int  The number of deleted rows
     */
    public function deleteCustomer($customer_id)
    {
        if (is_numeric($customer_id)) $customer_id = [$customer_id];

        if (!empty($customer_id) AND ctype_digit(implode('', $customer_id))) {
            if ($affected_rows = $this->whereIn('customer_id', $customer_id)->delete()) {
                $this->load->model('Addresses_model');
                $this->Addresses_model->whereIn('customer_id', $customer_id)->delete();

                return $affected_rows;
            }
        }
    }

    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Send email to customer
     *
     * @param string $email
     * @param array $template
     * @param array $data
     *
     * @return bool
     */
    public function sendMail($email, $template = [], $data = [])
    {
        if (empty($template) OR empty($email) OR !isset($template['subject'], $template['body']) OR empty($data)) {
            return FALSE;
        }

        $this->load->library('email');
        $this->email->initialize();
        $this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
        $this->email->to(strtolower($email));
        $this->email->subject($template['subject'], $data);
        $this->email->message($template['body'], $data);

        if ($this->email->send()) {
            return TRUE;
        } else {
            log_message('debug', $this->email->print_debugger(['headers']));
        }
    }

    /**
     * Send the registration confirmation email
     *
     * @param array $save
     * @param int $customer_id
     *
     * @return bool FALSE on failure
     */
    public function sendRegistrationEmail($save = [], $customer_id)
    {
        if (!is_numeric($customer_id) OR empty($save)) return FALSE;

        if (!is_array($this->config->item('registration_email'))) return FALSE;

        $config_registration_email = $this->config->item('registration_email');

        $mail_data['first_name'] = $save['first_name'];
        $mail_data['last_name'] = $save['last_name'];
        $mail_data['email'] = $save['email'];
        $mail_data['account_login_link'] = root_url('account/login');

        $this->load->model('Mail_templates_model');

        if (in_array('customer', $config_registration_email)) {
            $mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'registration');
            $this->sendMail($mail_data['email'], $mail_template, $mail_data);
        }

        if (in_array('admin', $config_registration_email)) {
            $mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'registration_alert');
            $this->sendMail($this->config->item('site_email'), $mail_template, $mail_data);
        }
    }

    /**
     * Check if a customer id already exists in database
     *
     * @param int $customer_id
     *
     * @return bool
     */
    public function validateCustomer($customer_id)
    {
        return (is_numeric($customer_id) AND $this->find($customer_id)) ? TRUE : FALSE;
    }

    /**
     * Generate random password
     *
     * @return string
     */
    protected function getRandomString()
    {
        //Random Password
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = [];
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, strlen($alphabet) - 1);
            $pass[$i] = $alphabet[$n];
        }

        return implode('', $pass);
    }
}

/* End of file Customers_model.php */
/* Location: ./system/tastyigniter/models/Customers_model.php */