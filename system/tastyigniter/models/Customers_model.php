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
class Customers_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('first_name', $filter['filter_search']);
			$this->db->or_like('last_name', $filter['filter_search']);
			$this->db->or_like('email', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		if ( ! empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(date_added)', $date[0]);
			$this->db->where('MONTH(date_added)', $date[1]);
		}

		$this->db->from('customers');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('customers');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('first_name', $filter['filter_search']);
				$this->db->or_like('last_name', $filter['filter_search']);
				$this->db->or_like('email', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}

			if ( ! empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getCustomers() {
		$this->db->from('customers');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getCustomer($customer_id) {
		if (is_numeric($customer_id)) {
			$this->db->from('customers');
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getCustomerDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('customers');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getCustomersForMessages($type) {
		$this->db->select('customer_id, email, status');
		$this->db->from('customers');
		$this->db->where('status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row)
				$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];
		}

		return $result;
	}

	public function getCustomerForMessages($type, $customer_id) {
		if ( ! empty($customer_id) AND is_array($customer_id)) {
			$this->db->select('customer_id, email, status');
			$this->db->from('customers');
			$this->db->where('status', '1');
			$this->db->where_in('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
					$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];
			}

			return $result;
		}
	}

	public function getCustomersByGroupIdForMessages($type, $customer_group_id) {
		if (is_numeric($customer_group_id)) {
			$this->db->select('customer_id, email, customer_group_id, status');
			$this->db->from('customers');
			$this->db->where('customer_group_id', $customer_group_id);
			$this->db->where('status', '1');

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
					$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];
			}

			return $result;
		}
	}

	public function getCustomersByNewsletterForMessages($type) {
		$this->db->select('customer_id, email, newsletter, status');
		$this->db->from('customers');
		$this->db->where('newsletter', '1');
		$this->db->where('status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row)
				$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];

			$this->load->model('Extensions_model');
			$newsletter = $this->Extensions_model->getModule('newsletter');
			if ($type === 'email' AND !empty($newsletter['ext_data']['subscribe_list'])) {
				$result = array_merge($result, $newsletter['ext_data']['subscribe_list']);
			}
		}

		return $result;
	}

	public function getCustomerByEmail($email) {

		$this->db->from('customers');
		$this->db->where('email', strtolower($email));

		$query = $this->db->get();

		if ($query->num_rows() === 1) {
			$row = $query->row_array();

			return $row;
		}
	}

	public function resetPassword($customer_id, $reset = array()) {
		if (is_numeric($customer_id) AND ! empty($reset)) {

			$this->db->from('customers');
			$this->db->where('customer_id', $customer_id);
			$this->db->where('email', strtolower($reset['email']));

			if ( ! empty($reset['security_question_id']) AND ! empty($reset['security_answer'])) {
				$this->db->where('security_question_id', $reset['security_question_id']);
				$this->db->where('security_answer', $reset['security_answer']);
			}

			$this->db->where('status', '1');
			$query = $this->db->get();
			if ($query->num_rows() === 1) {
				$row = $query->row_array();

				//Random Password
				$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
				$pass = array();
				for ($i = 0; $i < 8; $i ++) {
					$n = rand(0, strlen($alphabet) - 1);
					$pass[$i] = $alphabet[$n];
				}

				$password = implode('', $pass);

				$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				$this->db->set('password', sha1($salt . sha1($salt . sha1($password))));
				$this->db->where('customer_id', $row['customer_id']);
				$this->db->where('email', $row['email']);

				if ($this->db->update('customers') AND $this->db->affected_rows() > 0) {

					$mail_data['first_name'] = $row['first_name'];
					$mail_data['last_name'] = $row['last_name'];
					$mail_data['created_password'] = $password;
					$mail_data['account_login_link'] = root_url('account/login');

					$this->load->model('Mail_templates_model');
					$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'),
																				  'password_reset');

					$this->sendMail($row['email'], $mail_template, $mail_data);

					return TRUE;
				}
			}
		}

		return FALSE;
	}

	public function getAutoComplete($filter_data = array()) {
		if (is_array($filter_data) && ! empty($filter_data)) {
			$this->db->from('customers');

			if ( ! empty($filter_data['customer_name'])) {
				$this->db->like('CONCAT(first_name, last_name)', $filter_data['customer_name']);
			}

			if ( ! empty($filter_data['customer_id'])) {
				$this->db->where('customer_id', $filter_data['customer_id']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function saveCustomer($customer_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['first_name'])) {
			$this->db->set('first_name', $save['first_name']);
		}

		if (isset($save['last_name'])) {
			$this->db->set('last_name', $save['last_name']);
		}

		if (isset($save['email'])) {
			$this->db->set('email', strtolower($save['email']));
		}

		if (isset($save['password'])) {
			$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
			$this->db->set('password', sha1($salt . sha1($salt . sha1($save['password']))));
		}

		if (isset($save['telephone'])) {
			$this->db->set('telephone', $save['telephone']);
		}

		if (isset($save['security_question_id'])) {
			$this->db->set('security_question_id', $save['security_question_id']);
		}

		if (isset($save['security_answer'])) {
			$this->db->set('security_answer', $save['security_answer']);
		}

		if (isset($save['newsletter']) AND $save['newsletter'] === '1') {
			$this->db->set('newsletter', $save['newsletter']);
		} else {
			$this->db->set('newsletter', '0');
		}

		if (isset($save['customer_group_id'])) {
			$this->db->set('customer_group_id', $save['customer_group_id']);
		}

		if (isset($save['date_added'])) {
			$add['date_added'] = mdate('%Y-%m-%d', time());
			$this->db->set('date_added', $save['date_added']);
		}

		if (isset($save['status']) AND $save['status'] === '1') {
			$this->db->set('status', $save['status']);
		} else {
			$this->db->set('status', '0');
		}

		if (is_numeric($customer_id)) {
			$action = 'updated';
			$this->db->where('customer_id', $customer_id);
			$query = $this->db->update('customers');
		} else {
			$action = 'added';
			$this->db->set('date_added', mdate('%Y-%m-%d', time()));
			$query = $this->db->insert('customers');
			$customer_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($customer_id)) {
			if (isset($save['address'])) {
				$this->saveAddress($customer_id, $save['address']);
			}

			if ($action === 'added') {
				$mail_data['first_name'] = $save['first_name'];
				$mail_data['last_name'] = $save['last_name'];
				$mail_data['account_login_link'] = root_url('account/login');

				$this->load->model('Mail_templates_model');
				$config_registration_email = is_array($this->config->item('registration_email')) ? $this->config->item('registration_email') : array();

				if ($this->config->item('registration_email') === '1' OR in_array('customer', $config_registration_email)) {
					$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'registration');
					$this->sendMail($save['email'], $mail_template, $mail_data);
				}

				if (in_array('admin', $config_registration_email)) {
					$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'registration_alert');
					$this->sendMail($this->config->item('site_email'), $mail_template, $mail_data);
				}

				$this->saveCustomerGuestOrder($customer_id, $save['email']);
			}

			return $customer_id;
		}
	}

	private function saveCustomerGuestOrder($customer_id, $customer_email) {
		$query = FALSE;

		if (is_numeric($customer_id) AND ! empty($customer_email)) {

			$query = $this->db->from('orders')->where('email', $customer_email)->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					if (empty($row['order_id'])) continue;

					$this->db->set('customer_id', $customer_id);
					$this->db->where('order_id', $row['order_id'])->where('email', $customer_email);
					$this->db->update('orders');

					if ($row['order_type'] === '1' AND ! empty($row['address_id'])) {
						$this->db->set('customer_id', $customer_id);
						$this->db->where('address_id', $row['address_id']);
						$this->db->update('addresses');
					}

					if ( ! empty($row['payment'])) {
						$this->db->set('customer_id', $customer_id);
						$this->db->where('order_id', $row['order_id']);
						$this->db->update('pp_payments');
					}

					$this->db->set('customer_id', $customer_id);
					$this->db->where('order_id', $row['order_id']);
					$this->db->update('coupons_history');
				}
			}

			$this->db->set('customer_id', $customer_id);
			$this->db->where('email', $customer_email);
			$this->db->update('reservations');

			$query = TRUE;
		}

		return $query;
	}

	public function saveAddress($customer_id, $addresses = array()) {
		if ( is_numeric($customer_id) AND ! empty($addresses)) {
			$this->db->where('customer_id', $customer_id);
			$this->db->delete('addresses');

			$this->load->model('Addresses_model');

			foreach ($addresses as $key => $address) {
				if (!empty($address['address_1'])) {
					$this->Addresses_model->saveAddress($customer_id, '', $address);
				}
			}
		}
	}

	public function deleteCustomer($customer_id) {
		if (is_numeric($customer_id)) $customer_id = array($customer_id);

		if ( ! empty($customer_id) AND ctype_digit(implode('', $customer_id))) {
			$this->db->where_in('customer_id', $customer_id);
			$this->db->delete('customers');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('customer_id', $customer_id);
				$this->db->delete('addresses');

				return $affected_rows;
			}
		}
	}

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

	public function validateCustomer($customer_id) {
		if (is_numeric($customer_id)) {
			$this->db->from('customers');
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}
}

/* End of file customers_model.php */
/* Location: ./system/tastyigniter/models/customers_model.php */