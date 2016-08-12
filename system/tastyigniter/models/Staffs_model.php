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
class Staffs_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'staffs';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'staff_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	protected $timestamps = array('created');

	protected $belongs_to = array(
		'locations'    => array('Locations_model', 'staff_location_id'),
		'users'        => array('Users_model', 'staff_id', 'staff_id'),
		'staff_groups' => 'Staff_groups_model',
	);

	/**
	 * Scope a query to only include enabled staff
	 *
	 * @return $this
	 */
	public function isEnabled() {
		return $this->where('staff_status', '1');
	}

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		$this->with('users', 'staff_groups', 'locations');

		return parent::getCount($filter);
	}

	/**
	 * List all staff matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		$this->select('staffs.staff_id, staff_name, staff_email, staff_group_name, location_name, date_added, staff_status');
		$this->with('users', 'staff_groups', 'locations');

		return parent::getList($filter);
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->like('staff_name', $filter['filter_search']);
			$this->or_like('location_name', $filter['filter_search']);
			$this->or_like('staff_email', $filter['filter_search']);
		}

		if (isset($filter['filter_group']) AND is_numeric($filter['filter_group'])) {
			$this->where('staff_group_id', $filter['filter_group']);
		}

		if (!empty($filter['filter_location'])) {
			$this->where('staffs.staff_location_id', $filter['filter_location']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->where('YEAR(date_added)', $date[0]);
			$this->where('MONTH(date_added)', $date[1]);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->where('staff_status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Return all enabled staff
	 *
	 * @return array
	 */
	public function getStaffs() {
		$this->where('staff_status', '1');

		return $this->find_all();
	}

	/**
	 * Find a single staff by staff_id
	 *
	 * @param int $staff_id
	 *
	 * @return mixed
	 */
	public function getStaff($staff_id = NULL) {
		return $this->find($staff_id);
	}

	/**
	 * Find a staff user by staff_id
	 *
	 * @param int $staff_id
	 *
	 * @return mixed
	 */
	public function getStaffUser($staff_id = NULL) {
		$this->load->model('Users_model');
		$this->Users_model->where('staff_id', $staff_id);

		return $this->Users_model->find();
	}

	/**
	 * Return the dates of all staff
	 *
	 * @return array
	 */
	public function getStaffDates() {
		$this->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->group_by('MONTH(date_added)');
		$this->group_by('YEAR(date_added)');

		return $this->find_all();
	}

	/**
	 * Return all staff email or id,
	 * to use when sending messages to staff
	 *
	 * @param $type
	 *
	 * @return array
	 */
	public function getStaffsForMessages($type) {
		$this->select('staff_id, staff_email, staff_status');

		$result = array();
		foreach ($this->find_all('staff_status', '1') as $row) {
			$result[] = ($type === 'email') ? $row['staff_email'] : $row['staff_id'];
		}

		return $result;
	}

	/**
	 * Return single staff email or id,
	 * to use when sending messages to staff
	 *
	 * @param      $type
	 * @param bool $staff_id
	 *
	 * @return array
	 */
	public function getStaffForMessages($type, $staff_id = FALSE) {
		if (!empty($staff_id) AND is_array($staff_id)) {
			$this->select('staff_id, staff_email, staff_status');
			$this->where_in('staff_id', $staff_id);

			$result = array();
			foreach ($this->find_all('staff_status', '1') as $row) {
				$result[] = ($type === 'email') ? $row['staff_email'] : $row['staff_id'];
			}

			return $result;
		}
	}

	/**
	 * @param      $type
	 * @param bool $staff_group_id
	 *
	 * @return array
	 */
	public function getStaffsByGroupIdForMessages($type, $staff_group_id = FALSE) {
		if (is_numeric($staff_group_id)) {
			$this->select('staff_id, staff_email, staff_group_id, staff_status');
			$this->where('staff_group_id', $staff_group_id);

			$result = array();
			foreach ($this->find_all('staff_status', '1') as $row) {
				$result[] = ($type === 'email') ? $row['staff_email'] : $row['staff_id'];
			}

			return $result;
		}
	}

	/**
	 * List all staff matching the filter,
	 * to fill select auto-complete options
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getAutoComplete($filter = array()) {
		if (is_array($filter) AND !empty($filter)) {
			if (!empty($filter['staff_name'])) {
				$this->like('staff_name', $filter['staff_name']);
			}

			if (!empty($filter['staff_id'])) {
				$this->where('staff_id', $filter['staff_id']);
			}

			return $this->find_all();
		}
	}

	/**
	 * Create a new or update existing staff
	 *
	 * @param int   $staff_id
	 * @param array $save
	 *
	 * @return bool|int The $staff_id of the affected row, or FALSE on failure
	 */
	public function saveStaff($staff_id, $save = array()) {
		if (empty($save)) return FALSE;

		$_action = is_numeric($staff_id) ? 'updated' : 'added';

		if (is_single_location()) {
			$save['staff_location_id'] = $this->config->item('default_location_id');
		}

		if ($staff_id = $this->skip_validation(TRUE)->save($save, $staff_id)) {
			$this->load->model('Users_model');
			if (!empty($save['password'])) {
				$user['salt'] = $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9);
				$user['password'] = sha1($salt . sha1($salt . sha1($save['password'])));

				if ($_action === 'added' AND !empty($save['username'])) {
					$user['username'] = strtolower($save['username']);
					$user['staff_id'] = $staff_id;
					$this->Users_model->insert($user);
				} else {
					$this->Users_model->update(array('staff_id' => $staff_id), $user);
				}
			}

			return $staff_id;
		}
	}

	/**
	 * Reset a staff password,
	 * new password is sent to staff email
	 *
	 * @param string $user_email
	 *
	 * @return bool
	 */
	public function resetPassword($user_email = '') {
		if (!empty($user_email)) {
			$this->select('staffs.staff_id, staffs.staff_email, staffs.staff_name, users.username');
			$this->where('staffs.staff_email', $user_email);
			$this->or_where('users.username', $user_email);

			if ($row = $this->with('users')->find()) {
				//Randome Password
				$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
				$pass = array();
				for ($i = 0; $i < 8; $i++) {
					$n = rand(0, strlen($alphabet) - 1);
					$pass[$i] = $alphabet[$n];
				}

				$password = implode('', $pass);
				$this->load->model('Users_model');
				$this->Users_model->update(array('staff_id' => $row['staff_id']), array(
					'salt'     => $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9),
					'password' => sha1($salt . sha1($salt . sha1($password))),
				));

				if ($this->Users_model->affected_rows() > 0) {
					$mail_data['staff_name'] = $row['staff_name'];
					$mail_data['staff_username'] = $row['username'];
					$mail_data['created_password'] = $password;

					$this->load->model('Mail_templates_model');
					$mail_template = $this->Mail_templates_model->getTemplateData(
						$this->config->item('mail_template_id'),
						'password_reset_alert');

					if ($this->sendMail($row['staff_email'], $mail_template, $mail_data)) {
						return TRUE;
					}
				}
			}
		}

		return FALSE;
	}

	/**
	 * Delete a single or multiple staff by staff_id
	 *
	 * @param string|array $staff_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteStaff($staff_id) {
		if (is_numeric($staff_id)) $staff_id = array($staff_id);

		if (!empty($staff_id) AND ctype_digit(implode('', $staff_id))) {
			$affected_rows = $this->delete('staff_id', $staff_id);

			if ($affected_rows > 0) {
				$this->load->model('Users_model');
				$this->Users_model->delete('staff_id', $staff_id);

				return $affected_rows;
			}
		}
	}

	/**
	 * Send email to staff
	 *
	 * @param string $email
	 * @param array  $template
	 * @param array  $data
	 *
	 * @return bool
	 */
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

	/**
	 * Check if a staff id already exists in database
	 *
	 * @param int $staff_id
	 *
	 * @return bool
	 */
	public function validateStaff($staff_id = NULL) {
		if (is_numeric($staff_id)) {
			$this->where('staff_id', $staff_id);
		} else {
			$this->where('staff_email', $staff_id);
		}

		return $this->find() ? TRUE : FALSE;
	}
}

/* End of file Staffs_model.php */
/* Location: ./system/tastyigniter/models/Staffs_model.php */