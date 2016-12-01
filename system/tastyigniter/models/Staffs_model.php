<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

/**
 * Staffs Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Staffs_model.php
 * @link           http://docs.tastyigniter.com
 */
class Staffs_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'staffs';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'staff_id';

	protected $fillable = ['staff_id', 'staff_name', 'staff_email', 'staff_group_id', 'staff_location_id', 'timezone',
		'language_id', 'date_added', 'staff_status',];

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	public $timestamps = TRUE;

	const CREATED_AT = 'date_added';

	public $belongsTo = [
		'locations'    => ['Locations_model', 'staff_location_id'],
		'users'        => ['Users_model', 'staff_id', 'staff_id'],
		'staff_groups' => 'Staff_groups_model',
	];

	public function scopeJoinTables($query)
	{
		$query->join('users', 'users.staff_id', '=', 'staffs.staff_id', 'left');
		$query->join('staff_groups', 'staff_groups.staff_group_id', '=', 'staffs.staff_group_id', 'left');
		$query->join('locations', 'locations.location_id', '=', 'staffs.staff_location_id', 'left');

		return $query;
	}

	public function scopeJoinUserTable($query)
	{
		$query->join('users', 'users.staff_id', '=', 'staffs.staff_id', 'left');

		return $query;
	}

	/**
	 * Scope a query to only include enabled staff
	 *
	 * @return $this
	 */
	public function scopeIsEnabled($query)
	{
		return $query->where('staff_status', '1');
	}

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
		$query->selectRaw($this->tablePrefix('staffs') . '.staff_id, staff_name, staff_email, staff_group_name, location_name, date_added, staff_status');

		$query->joinTables();

		if (!empty($filter['filter_search'])) {
			$query->like('staff_name', $filter['filter_search']);
			$query->orLike('location_name', $filter['filter_search']);
			$query->orLike('staff_email', $filter['filter_search']);
		}

		if (isset($filter['filter_group']) AND is_numeric($filter['filter_group'])) {
			$query->where('staffs.staff_group_id', $filter['filter_group']);
		}

		if (!empty($filter['filter_location'])) {
			$query->where('staffs.staff_location_id', $filter['filter_location']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$query->whereRaw('YEAR(date_added)', $date[0]);
			$query->whereRaw('MONTH(date_added)', $date[1]);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$query->where('staff_status', $filter['filter_status']);
		}

		return $query;
	}

	/**
	 * Return all enabled staff
	 *
	 * @return array
	 */
	public function getStaffs()
	{
		return $this->where('staff_status', '1')->getAsArray();
	}

	/**
	 * Find a single staff by staff_id
	 *
	 * @param int $staff_id
	 *
	 * @return mixed
	 */
	public function getStaff($staff_id = null)
	{
		return $this->findOrNew($staff_id)->toArray();
	}

	/**
	 * Find a staff user by staff_id
	 *
	 * @param int $staff_id
	 *
	 * @return mixed
	 */
	public function getStaffUser($staff_id = null)
	{
		$this->load->model('Users_model');

		return $this->Users_model->findOrNew(['staff_id' => $staff_id])->toArray();
	}

	/**
	 * Return the dates of all staff
	 *
	 * @return array
	 */
	public function getStaffDates()
	{
		return $this->pluckDates('date_added');
	}

	/**
	 * Return all staff email or id,
	 * to use when sending messages to staff
	 *
	 * @param $type
	 *
	 * @return array
	 */
	public function getStaffsForMessages($type)
	{
		$result = $this->selectRaw('staff_id, staff_email, staff_status')->where('staff_status', '1')->getAsArray();

		return $this->getEmailOrIdFromResult($result, $type);
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
	public function getStaffForMessages($type, $staff_id = FALSE)
	{
		if (!empty($staff_id) AND is_array($staff_id)) {
			$result = $this->selectRaw('staff_id, staff_email, staff_status')
						   ->whereIn('staff_id', $staff_id)->getAsArray();

			return $this->getEmailOrIdFromResult($result, $type);
		}
	}

	/**
	 * @param      $type
	 * @param bool $staff_group_id
	 *
	 * @return array
	 */
	public function getStaffsByGroupIdForMessages($type, $staff_group_id = FALSE)
	{
		if (is_numeric($staff_group_id)) {
			$result = $this->selectRaw('staff_id, staff_email, staff_status')
						   ->where('staff_group_id', $staff_group_id)->getAsArray();

			return $this->getEmailOrIdFromResult($result, $type);
		}
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
				$result[] = ($type == 'email') ? $row['staff_email'] : $row['staff_id'];
			}
		}

		return $result;
	}

	/**
	 * List all staff matching the filter,
	 * to fill select auto-complete options
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getAutoComplete($filter = [])
	{
		if (is_array($filter) AND !empty($filter)) {
			$queryBuilder = $this->query();

			if (!empty($filter['staff_name'])) {
				$queryBuilder->like('staff_name', $filter['staff_name']);
			}

			if (!empty($filter['staff_id'])) {
				$queryBuilder->where('staff_id', $filter['staff_id']);
			}

			return $queryBuilder->getAsArray();
		}
	}

	/**
	 * Create a new or update existing staff
	 *
	 * @param int $staff_id
	 * @param array $save
	 *
	 * @return bool|int The $staff_id of the affected row, or FALSE on failure
	 */
	public function saveStaff($staff_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$_action = is_numeric($staff_id) ? 'updated' : 'added';

		if (is_single_location()) {
			$save['staff_location_id'] = $this->config->item('default_location_id');
		}

		$staffModel = $this->findOrNew($staff_id);
		$save['timezone'] = isset($save['timezone']) ? $save['timezone'] : '';
		$save['language_id'] = isset($save['language_id']) ? $save['language_id'] : '';

		if ($saved = $staffModel->fill($save)->save()) {
			$staff_id = $staffModel->getKey();

			$this->load->model('Users_model');
			if (!empty($save['password'])) {
				$user['salt'] = $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9);
				$user['password'] = sha1($salt . sha1($salt . sha1($save['password'])));

				if ($_action === 'added' AND !empty($save['username'])) {
					$user['username'] = strtolower($save['username']);
					$user['staff_id'] = $staff_id;
					$this->Users_model->insertGetId($user);
				} else {
					$this->Users_model->where('staff_id', $staff_id)->update($user);
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
	public function resetPassword($user_email = '')
	{
		if (!empty($user_email)) {
			$query = $this->selectRaw('staffs.staff_id, staffs.staff_email, staffs.staff_name, users.username')
						  ->whereRaw('staffs.staff_email', $user_email)->orWhereRaw('users.username', $user_email);

			$query->joinUserTable();

			if ($row = $query->first()) {
				$row = $row->toArray();

				//Randome Password
				$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
				$pass = [];
				for ($i = 0; $i < 8; $i++) {
					$n = rand(0, strlen($alphabet) - 1);
					$pass[$i] = $alphabet[$n];
				}

				$password = implode('', $pass);
				$this->load->model('Users_model');
				$affectedRows = $this->Users_model->where(['staff_id', $row['staff_id']])->update([
					'salt'     => $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9),
					'password' => sha1($salt . sha1($salt . sha1($password))),
				]);

				if ($affectedRows > 0) {
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
	public function deleteStaff($staff_id)
	{
		if (is_numeric($staff_id)) $staff_id = [$staff_id];

		if (!empty($staff_id) AND ctype_digit(implode('', $staff_id))) {
			$affected_rows = $this->whereIn('staff_id', $staff_id)->delete();

			if ($affected_rows > 0) {
				$this->load->model('Users_model');
				$this->Users_model->whereIn('staff_id', $staff_id)->delete();

				return $affected_rows;
			}
		}
	}

	/**
	 * Send email to staff
	 *
	 * @param string $email
	 * @param array $template
	 * @param array $data
	 *
	 * @return bool
	 */
	public function sendMail($email, $template, $data = [])
	{
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
	 * Check if a staff id already exists in database
	 *
	 * @param int $staff_id
	 *
	 * @return bool
	 */
	public function validateStaff($staff_id = null)
	{
		$query = $this->query();

		if (is_numeric($staff_id)) {
			$query->where('staff_id', $staff_id);
		} else {
			$query->where('staff_email', $staff_id);
		}

		return $query->first() ? TRUE : FALSE;
	}
}

/* End of file Staffs_model.php */
/* Location: ./system/tastyigniter/models/Staffs_model.php */