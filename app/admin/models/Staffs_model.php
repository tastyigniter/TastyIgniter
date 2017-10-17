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
 * Staffs Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Staffs_model.php
 * @link           http://docs.tastyigniter.com
 */
class Staffs_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('staff_name', $filter['filter_search']);
			$this->db->or_like('location_name', $filter['filter_search']);
			$this->db->or_like('staff_email', $filter['filter_search']);
		}

		if (isset($filter['filter_group']) AND is_numeric($filter['filter_group'])) {
			$this->db->where('staff_group_id', $filter['filter_group']);
		}

		if ( ! empty($filter['filter_location'])) {
			$this->db->where('staffs.staff_location_id', $filter['filter_location']);
		}

		if ( ! empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(date_added)', $date[0]);
			$this->db->where('MONTH(date_added)', $date[1]);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('staff_status', $filter['filter_status']);
		}

		$this->db->from('staffs');
		$this->db->join('locations', 'locations.location_id = staffs.staff_location_id', 'left');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('staffs.staff_id, staff_name, staff_email, staff_group_name, location_name, date_added, staff_status');
			$this->db->from('staffs');
			$this->db->join('users', 'users.staff_id = staffs.staff_id', 'left');
			$this->db->join('staff_groups', 'staff_groups.staff_group_id = staffs.staff_group_id', 'left');
			$this->db->join('locations', 'locations.location_id = staffs.staff_location_id', 'left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('staff_name', $filter['filter_search']);
				$this->db->or_like('location_name', $filter['filter_search']);
				$this->db->or_like('staff_email', $filter['filter_search']);
			}

			if (isset($filter['filter_group']) AND is_numeric($filter['filter_group'])) {
				$this->db->where('staffs.staff_group_id', $filter['filter_group']);
			}

			if ( ! empty($filter['filter_location'])) {
				$this->db->where('staffs.staff_location_id', $filter['filter_location']);
			}

			if ( ! empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('staff_status', $filter['filter_status']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getStaffs() {
		$this->db->from('staffs');
		$this->db->where('staff_status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getStaff($staff_id = FALSE) {
		$this->db->from('staffs');

		$this->db->where('staff_id', $staff_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getStaffUser($staff_id = FALSE) {
		$this->db->from('users');

		$this->db->where('staff_id', $staff_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getStaffDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('staffs');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getStaffsForMessages($type) {
		$this->db->select('staff_id, staff_email, staff_status');
		$this->db->from('staffs');
		$this->db->where('staff_status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row)
				$result[] = ($type === 'email') ? $row['staff_email'] : $row['staff_id'];
		}

		return $result;
	}

	public function getStaffForMessages($type, $staff_id = FALSE) {
		if ( ! empty($staff_id) AND is_array($staff_id)) {
			$this->db->select('staff_id, staff_email, staff_status');
			$this->db->from('staffs');
			$this->db->where_in('staff_id', $staff_id);
			$this->db->where('staff_status', '1');

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
					$result[] = ($type === 'email') ? $row['staff_email'] : $row['staff_id'];
			}

			return $result;
		}
	}

	public function getStaffsByGroupIdForMessages($type, $staff_group_id = FALSE) {
		if (is_numeric($staff_group_id)) {
			$this->db->select('staff_id, staff_email, staff_group_id, staff_status');
			$this->db->from('staffs');
			$this->db->where('staff_group_id', $staff_group_id);
			$this->db->where('staff_status', '1');

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
					$result[] = ($type === 'email') ? $row['staff_email'] : $row['staff_id'];
			}

			return $result;
		}
	}

	public function getAutoComplete($filter = array()) {
		if (is_array($filter) AND ! empty($filter)) {
			$this->db->from('staffs');

			if ( ! empty($filter['staff_name'])) {
				$this->db->like('staff_name', $filter['staff_name']);
			}

			if ( ! empty($filter_data['staff_id'])) {
				$this->db->where('staff_id', $filter_data['staff_id']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function saveStaff($staff_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['staff_name'])) {
			$this->db->set('staff_name', $save['staff_name']);
		}

		if (isset($save['staff_email'])) {
			$this->db->set('staff_email', strtolower($save['staff_email']));
		}

		if (isset($save['staff_group_id'])) {
			$this->db->set('staff_group_id', $save['staff_group_id']);
		}

		if (isset($save['staff_location_id'])) {
			$this->db->set('staff_location_id', $save['staff_location_id']);
		}

		if (isset($save['staff_status']) AND $save['staff_status'] === '1') {
			$this->db->set('staff_status', $save['staff_status']);
		} else {
			$this->db->set('staff_status', '0');
		}

		if (is_numeric($staff_id)) {
			$_action = 'updated';
			$this->db->where('staff_id', $staff_id);
			$query = $this->db->update('staffs');
		} else {
			$_action = 'added';
			$this->db->set('date_added', mdate('%Y-%m-%d', time()));
			$query = $this->db->insert('staffs');
			$staff_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($staff_id)) {
			if ( ! empty($save['password'])) {
				$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				$this->db->set('password', sha1($salt . sha1($salt . sha1($save['password']))));

				if ($_action === 'added' AND ! empty($save['username'])) {
					$this->db->set('username', strtolower($save['username']));
					$this->db->set('staff_id', $staff_id);
					$query = $this->db->insert('users');
				} else {
					$this->db->where('staff_id', $staff_id);
					$query = $this->db->update('users');
				}
			}

			return ($query === TRUE AND is_numeric($staff_id)) ? $staff_id : FALSE;
		}
	}

	public function resetPassword($user_email = NULL) {
		if ( ! empty($user_email)) {
			$this->db->select('staffs.staff_id, staffs.staff_email, staffs.staff_name, users.username');
			$this->db->from('staffs');
			$this->db->join('users', 'users.staff_id = staffs.staff_id', 'left');
			$this->db->where('staffs.staff_email', $user_email);
			$this->db->or_where('users.username', $user_email);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				//Randome Password
				$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
				$pass = array();
				for ($i = 0; $i < 8; $i ++) {
					$n = rand(0, strlen($alphabet) - 1);
					$pass[$i] = $alphabet[$n];
				}

				$password = implode('', $pass);
				$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				$this->db->set('password', sha1($salt . sha1($salt . sha1($password))));
				$this->db->where('staff_id', $row['staff_id']);

				if ($this->db->update('users') AND $this->db->affected_rows() > 0) {
					$mail_data['staff_name'] = $row['staff_name'];
					$mail_data['staff_username'] = $row['username'];
					$mail_data['created_password'] = $password;

					$this->load->model('Mail_templates_model');
					$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'),
					                                                              'password_reset_alert');

					if ($this->sendMail($row['staff_email'], $mail_template, $mail_data)) {
						return TRUE;
					}
				}
			}
		}

		return FALSE;
	}

	public function deleteStaff($staff_id) {
		if (is_numeric($staff_id)) $staff_id = array($staff_id);

		if ( ! empty($staff_id) AND ctype_digit(implode('', $staff_id))) {
			$this->db->where_in('staff_id', $staff_id);
			$this->db->delete('staffs');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('staff_id', $staff_id);
				$this->db->delete('users');

				return $affected_rows;
			}
		}
	}

	public function sendMail($email, $template, $data = array()) {
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

	public function validateStaff($customer_id = NULL) {
		if (!empty($customer_id)) {
			$this->db->from('staffs');

			if (is_numeric($customer_id)) {
				$this->db->where('staff_id', $customer_id);
			} else {
				$this->db->where('staff_email', $customer_id);
			}

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}
}

/* End of file staffs_model.php */
/* Location: ./system/tastyigniter/models/staffs_model.php */