<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Customers Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Customers_model.php
 * @link           http://docs.tastyigniter.com
 */
class Customers_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'customers';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'customer_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	protected $timestamps = array('created');

	/**
	 * @var string[] The names of callback methods which
	 * will be called after the insert method.
	 */
	protected $after_create = array('sendRegistrationEmail', 'saveCustomerGuestOrder');

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->like('first_name', $filter['filter_search']);
			$this->or_like('last_name', $filter['filter_search']);
			$this->or_like('email', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->where('status', $filter['filter_status']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->where('YEAR(date_added)', $date[0]);
			$this->where('MONTH(date_added)', $date[1]);
		}

		return $this;
	}

	/**
	 * Return all customers
	 *
	 * @return array
	 */
	public function getCustomers() {
		return $this->find_all();
	}

	/**
	 * Find a single customer by customer_id
	 *
	 * @param $customer_id
	 *
	 * @return array
	 */
	public function getCustomer($customer_id) {
		if (is_numeric($customer_id)) {
			return $this->find($customer_id);
		}
	}

	/**
	 * Return all customer registration dates
	 *
	 * @return array
	 */
	public function getCustomerDates() {
		$this->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->group_by('MONTH(date_added)');
		$this->group_by('YEAR(date_added)');

		return $this->find_all();
	}

	/**
	 * Return all customers email or id,
	 * to use when sending messages to customers
	 *
	 * @param $type
	 *
	 * @return array
	 */
	public function getCustomersForMessages($type) {
		$result = array();

		$this->select('customer_id, email, status');
		foreach ($this->find_all('status', '1') as $row) {
			$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];
		}

		return $result;
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
	public function getCustomerForMessages($type, $customer_id) {
		if (!empty($customer_id) AND is_array($customer_id)) {
			$result = array();

			$this->select('customer_id, email, status');
			$this->where_in('customer_id', $customer_id);
			foreach ($this->find_all('status', '1') as $row) {
				$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];
			}

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
	public function getCustomersByGroupIdForMessages($type, $customer_group_id) {
		if (is_numeric($customer_group_id)) {
			$result = array();

			$this->select('customer_id, email, customer_group_id, status');
			$this->where('customer_group_id', $customer_group_id);
			foreach ($this->find_all('status', '1') as $row) {
				$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];
			}

			return $result;
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
	public function getCustomersByNewsletterForMessages($type) {
		$result = array();

		$this->select('customer_id, email, newsletter, status');
		$this->where('newsletter', '1');
		foreach ($this->find_all('status', '1') as $row) {
			$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];
		}

		$this->load->model('Extensions_model');
		$newsletter = $this->Extensions_model->getModule('newsletter');
		if ($type === 'email' AND !empty($newsletter['ext_data']['subscribe_list'])) {
			$result = array_merge($result, $newsletter['ext_data']['subscribe_list']);
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
	public function getCustomerByEmail($email) {
		return $this->find('email', strtolower($email));
	}

	/**
	 * Reset a customer password,
	 * new password is sent to registered email
	 *
	 * @param int   $customer_id
	 * @param array $reset
	 *
	 * @return bool
	 */
	public function resetPassword($customer_id, $reset = array()) {
		if (is_numeric($customer_id) AND !empty($reset)) {
			$this->where('customer_id', $customer_id);
			$this->where('email', strtolower($reset['email']));
			if (!empty($reset['security_question_id']) AND !empty($reset['security_answer'])) {
				$this->where('security_question_id', $reset['security_question_id']);
				$this->where('security_answer', $reset['security_answer']);
			}

			if ($row = $this->find('status', '1')) {
				$password = $this->getRandomString();
				$data['salt'] = $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9);
				$data['password'] = sha1($salt . sha1($salt . sha1($password)));

				$this->where('email', $row['email']);
				if ($this->update($row['customer_id'], $data, TRUE) AND $this->affected_rows() > 0) {
					$mail_data['first_name'] = $row['first_name'];
					$mail_data['last_name'] = $row['last_name'];
					$mail_data['created_password'] = $password;
					$mail_data['account_login_link'] = root_url('account/login');

					$this->load->model('Mail_templates_model');
					$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'password_reset');

					$this->sendMail($row['email'], $mail_template, $mail_data);

					return TRUE;
				}
			}
		}

		return FALSE;
	}

	/**
	 * List all customers matching the filter,
	 * to fill select auto-complete options
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getAutoComplete($filter = array()) {
		if (is_array($filter) AND !empty($filter)) {
			$this->select('customer_id, first_name, last_name');

			if (!empty($filter['customer_name'])) {
				$this->like('CONCAT(first_name, last_name)', $filter['customer_name']);
			}

			if (!empty($filter['customer_id'])) {
				$this->where('customer_id', $filter['customer_id']);
			}

			return $this->find_all();
		}
	}

	/**
	 * Create a new or update existing customer
	 *
	 * @param int   $customer_id
	 * @param array $save
	 *
	 * @return bool|int The $customer_id of the affected row, or FALSE on failure
	 */
	public function saveCustomer($customer_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['email'])) {
			$save['email'] = strtolower($save['email']);
		}

		if (isset($save['password'])) {
			$save['salt'] = $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9);
			$save['password'] = sha1($salt . sha1($salt . sha1($save['password'])));
		}

		if ($customer_id = $this->skip_validation(TRUE)->save($save, $customer_id)) {
			if (isset($save['address'])) {
				$this->saveAddress($customer_id, $save['address']);
			}
		}

		return $customer_id;
	}

	/**
	 * Send the registration confirmation email
	 *
	 * @param array $save
	 * @param int   $customer_id
	 *
	 * @return bool FALSE on failure
	 */
	public function sendRegistrationEmail($save = array(), $customer_id) {
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
	 * Update guest orders, address and reservations
	 * matching customer email
	 *
	 * @param array $save
	 * @param int   $customer_id
	 *
	 * @return bool TRUE on success, or FALSE on failure
	 */
	public function saveCustomerGuestOrder($save = array(), $customer_id) {
		$query = FALSE;

		if (is_numeric($customer_id) AND !empty($save['email'])) {
			$customer_email = $save['email'];
			$this->load->model('Orders_model');
			$this->load->model('Addresses_model');
			$this->load->model('Coupons_model');
			$this->load->model('Coupons_history_model');
			$this->load->model('Reservations_model');

			if ($orders = $this->Orders_model->find_all('email', $customer_email)) {
				foreach ($orders as $row) {
					if (empty($row['order_id'])) continue;

					$this->where('email', $customer_email);
					$this->Orders_model->update($row['order_id'],
						array('customer_id' => $customer_id)
					);

					if ($row['order_type'] === '1' AND !empty($row['address_id'])) {
						$this->Addresses_model->update($row['address_id'],
							array('customer_id' => $customer_id)
						);
					}

					if (!empty($row['payment'])) {
						$this->update_into('pp_payments',
							array('order_id' => $row['order_id']),
							array('customer_id' => $customer_id)
						);
					}

					$this->Coupons_history_model->update(
						array('order_id' => $row['order_id']),
						array('customer_id' => $customer_id)
					);
				}
			}

			if ($reservation = $this->Reservations_model->find('email', $customer_email)) {
				$this->Reservations_model->update(
					array('email' => $customer_email),
					array('customer_id' => $customer_id), TRUE
				);
			}

			$query = TRUE;
		}

		return $query;
	}

	/**
	 * Create a new or update existing customer address
	 *
	 * @param int   $customer_id
	 * @param array $addresses an array of one or multiple address array
	 */
	public function saveAddress($customer_id, $addresses = array()) {
		if (is_numeric($customer_id) AND !empty($addresses)) {
			$this->load->model('Addresses_model');
			$this->Addresses_model->delete($customer_id);

			foreach ($addresses as $key => $address) {
				if (!empty($address['address_1'])) {
					$this->Addresses_model->save($address, array('customer_id' => $customer_id));
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
	public function deleteCustomer($customer_id) {
		if (is_numeric($customer_id)) $customer_id = array($customer_id);

		if (!empty($customer_id) AND ctype_digit(implode('', $customer_id))) {
			if ($affected_rows = $this->delete('customer_id', $customer_id)) {
				$this->load->model('Addresses_model');
				$this->Addresses_model->delete('customer_id', $customer_id);

				return $affected_rows;
			}
		}
	}

	/**
	 * Send email to customer
	 *
	 * @param string $email
	 * @param array  $template
	 * @param array  $data
	 *
	 * @return bool
	 */
	public function sendMail($email, $template = array(), $data = array()) {
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
			log_message('debug', $this->email->print_debugger(array('headers')));
		}
	}

	/**
	 * Check if a customer id already exists in database
	 *
	 * @param int $customer_id
	 *
	 * @return bool
	 */
	public function validateCustomer($customer_id) {
		return (is_numeric($customer_id) AND $this->find($customer_id)) ? TRUE : FALSE;
	}

	/**
	 * Generate random password
	 *
	 * @return string
	 */
	protected function getRandomString() {
		//Random Password
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array();
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, strlen($alphabet) - 1);
			$pass[$i] = $alphabet[$n];
		}

		return implode('', $pass);
	}
}

/* End of file Customers_model.php */
/* Location: ./system/tastyigniter/models/Customers_model.php */