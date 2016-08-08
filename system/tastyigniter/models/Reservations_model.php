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
 * Reservations Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Reservations_model.php
 * @link           http://docs.tastyigniter.com
 */
class Reservations_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'reservations';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'reservation_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	protected $timestamps = array('created' => 'date_added', 'updated' => 'date_modified');

	protected $belongs_to = array(
		'tables' => 'Tables_model',
		'locations' => 'Locations_model',
		'statuses' => array('Statuses_model', 'status'),
		'staffs' => array('Staffs_model', 'assignee_id'),
	);

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		$with = array('tables', 'locations', 'statuses');
		if (APPDIR === ADMINDIR) {
			$with[] = 'staffs';
		}
		$this->with($with);

		return parent::getCount($filter);
	}

	/**
	 * List all reservations matching the filter
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getList($filter = array()) {
		$with = array('tables', 'locations', 'statuses');
		if (APPDIR === ADMINDIR) {
			$with[] = 'staffs';
		}
		$this->with($with);

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
		if (APPDIR === ADMINDIR) {
			if (!empty($filter['filter_search'])) {
				$this->like('reservation_id', $filter['filter_search']);
				$this->or_like('LCASE(location_name)', strtolower($filter['filter_search']));
				$this->or_like('LCASE(first_name)', strtolower($filter['filter_search']));
				$this->or_like('LCASE(last_name)', strtolower($filter['filter_search']));
				$this->or_like('LCASE(table_name)', strtolower($filter['filter_search']));
				$this->or_like('LCASE(staff_name)', strtolower($filter['filter_search']));
			}

			if (!empty($filter['filter_status'])) {
				$this->where('reservations.status', $filter['filter_status']);
			}

			if (!empty($filter['filter_location'])) {
				$this->where('reservations.location_id', $filter['filter_location']);
			}

			if (!empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->where('YEAR(reserve_date)', $date[0]);
				$this->where('MONTH(reserve_date)', $date[1]);

				if (isset($date[2])) {
					$this->where('DAY(reserve_date)', (int)$date[2]);
				}
			} else if (!empty($filter['filter_year']) AND !empty($filter['filter_month']) AND !empty($filter['filter_day'])) {
				$this->where('YEAR(reserve_date)', $filter['filter_year']);
				$this->where('MONTH(reserve_date)', $filter['filter_month']);
				$this->where('DAY(reserve_date)', $filter['filter_day']);
			} else if (!empty($filter['filter_year']) AND !empty($filter['filter_month'])) {
				$this->where('YEAR(reserve_date)', $filter['filter_year']);
				$this->where('MONTH(reserve_date)', $filter['filter_month']);
			}
		} else if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			$this->where('customer_id', $filter['customer_id']);
		}

		return $this;
	}

	/**
	 * Return all reservations
	 *
	 * @return array|bool
	 */
	public function getReservations() {
		return $this->order_by('reservation_id')->with('tables', 'statuses', 'locations', 'countries')->find_all();
	}

	/**
	 * Find a single reservation by reservation_id
	 *
	 * @param int $reservation_id
	 * @param int $customer_id
	 *
	 * @return array
	 */
	public function getReservation($reservation_id = NULL, $customer_id = NULL) {
		if ($reservation_id !== FALSE) {
			$with = array('tables', 'statuses', 'locations', 'countries');
			if (APPDIR === ADMINDIR) {
				$with[] = 'staffs';
				$this->select('*, reservations.date_added, reservations.date_modified, reservations.status, tables.table_id, staffs.staff_id, locations.location_id');
			} else {
				$this->select('reservation_id, table_name, reservations.location_id, location_name, location_address_1, location_address_2, location_city, location_postcode, location_country_id, table_name, min_capacity, max_capacity, guest_num, occasion_id, customer_id, first_name, last_name, telephone, email, reserve_time, reserve_date, status_name, reservations.date_added, reservations.date_modified, reservations.status, comment, notify, ip_address, user_agent');
			}

			if (APPDIR === MAINDIR AND $customer_id !== FALSE) {
				$this->where('customer_id', $customer_id);
			}

			return $this->with($with)->find($reservation_id);
		}
	}

	/**
	 * Return the dates of all reservations
	 *
	 * @return array
	 */
	public function getReservationDates() {
		$this->select('reserve_date, MONTH(reserve_date) as month, YEAR(reserve_date) as year');
		$this->group_by('MONTH(reserve_date)');
		$this->group_by('YEAR(reserve_date)');

		return $this->find_all();
	}

	/**
	 * Return maximum table capacity by location_id
	 *
	 * @param int $location_id
	 *
	 * @return int
	 */
	public function getTotalCapacityByLocation($location_id = NULL) {
		$result = 0;

		$this->load->model('Location_tables_model');
		$this->Location_tables_model->select_sum('tables.max_capacity', 'total_seats');

		if (!empty($location_id)) {
			$this->Location_tables_model->where('location_id', $location_id);
		}

		if ($row = $this->Location_tables_model->with('tables')->find()) {
			$result = $row['total_seats'];
		}

		return $result;
	}

	/**
	 * Return total reserved guest by location_id
	 *
	 * @param int    $location_id
	 * @param string|array $dates
	 *
	 * @return int
	 */
	public function getTotalGuestsByLocation($location_id = NULL, $dates = NULL) {
		$result = array();

		$this->select('reserve_date')->select_sum('reservations.guest_num', 'total_guest');
		//$this->where('status', (int)$this->config->item('default_reservation_status'));

		if (!empty($location_id)) {
			$this->where('location_id', $location_id);
		}

		if (!empty($dates)) {
			$dates = !is_array($dates) ? array($dates) : $dates;
			$this->where_in('DATE(reserve_date)', $dates);
		}

		$this->group_by('DAY(reserve_date)');

		if ($rows = $this->find_all()) {
			foreach ($rows as $row) {
				$result[$row['reserve_date']] = $row['total_guest'];
			}
		}

		return $result;
	}

	/**
	 * Return all location tables by location_id and,
	 * group by minimum table capacity
	 *
	 * @param int $location_id
	 * @param int $guest_num
	 *
	 * @return array
	 */
	public function getLocationTablesByMinCapacity($location_id, $guest_num) {
		$tables = array();

		if (isset($location_id, $guest_num)) {
			$this->load->model('Location_tables_model');

			$this->Location_tables_model->where('location_id', $location_id);
			$this->Location_tables_model->where('table_status', '1');
			$this->Location_tables_model->group_start();
			$this->Location_tables_model->where('min_capacity <=', $guest_num);
			$this->Location_tables_model->where('max_capacity >=', $guest_num);
			$this->Location_tables_model->group_end();

			$this->Location_tables_model->order_by('min_capacity');

			if ($rows = $this->Location_tables_model->with('tables')->find_all()) {
				foreach ($rows as $row) {
					$tables[$row['table_id']] = $row;
				}
			}
		}

		return $tables;
	}

	/**
	 * Find a single table available for reservation
	 *
	 * @param array $find
	 *
	 * @return array|string
	 */
	public function findATable($find = array()) {

		if (!isset($find['location']) OR !isset($find['guest_num']) OR empty($find['reserve_date']) OR empty($find['reserve_time']) OR empty($find['time_interval'])) {
			return 'NO_ARGUMENTS';
		}

		if (!($available_tables = $this->getLocationTablesByMinCapacity($find['location'], $find['guest_num']))) {
			return 'NO_TABLE';
		}

		$find['reserve_date_time'] = strtotime($find['reserve_date'] . ' ' . $find['reserve_time']);
		$find['unix_start_time'] = strtotime('-' . ($find['time_interval'] * 2) . ' mins', $find['reserve_date_time']);
		$find['unix_end_time'] = strtotime('+' . ($find['time_interval'] * 2) . ' mins', $find['reserve_date_time']);

		$time_slots = time_range(mdate('%H:%i', $find['unix_start_time']), mdate('%H:%i', $find['unix_end_time']), $find['time_interval'], '%H:%i');
		$reserve_time_slot = array_flip($time_slots);

		$reserved_tables = $this->getReservedTableByDate($find, array_keys($available_tables));

		foreach ($reserved_tables as $reserved) {
			// remove available table if already reserved
			if (isset($available_tables[$reserved['table_id']])) {
				unset($available_tables[$reserved['table_id']]);
			}

			// remove reserve time slot if already reserved
			$reserve_time = mdate('%H:%i', strtotime($reserved['reserve_date'] . ' ' . $reserved['reserve_time']));
			if (isset($reserve_time_slot[$reserve_time])) {
				unset($reserve_time_slot[$reserve_time]);
			}
		}

		if (empty($available_tables) OR empty($reserve_time_slot)) {
			return 'FULLY_BOOKED';
		}

		return array('table_found' => $available_tables, 'time_slots' => array_flip($reserve_time_slot));
	}

	/**
	 * Return all reserved tables by specified date
	 *
	 * @param array $find
	 * @param int   $table_id
	 * @param bool  $group
	 *
	 * @return array|bool
	 */
	public function getReservedTableByDate($find = array(), $table_id, $group = FALSE) {
		if (!isset($find['location']) OR !is_numeric($find['location']) OR empty($find['reserve_date']) OR empty($table_id)) {
			return FALSE;
		}

		$this->where('location_id', $find['location']);

		is_array($table_id) OR $table_id = array($table_id);
		if (!empty($table_id)) {
			$this->where_in('table_id', $table_id);
		}

		$this->group_start();
		$this->where('ADDTIME(reserve_date, reserve_time) >=', mdate('%Y-%m-%d %H:%i:%s', $find['unix_start_time']));
		$this->where('ADDTIME(reserve_date, reserve_time) <=', mdate('%Y-%m-%d %H:%i:%s', $find['unix_end_time']));
		$this->group_end();

		$results = array();
		if ($rows = $this->find_all()) {
			if ($group) {
				foreach ($rows as $row) {
					$results[$row['table_id']][] = $row;
				}
			} else {
				$results = $rows;
			}
		}

		return $results;
	}

	/**
	 * Return the total number of seats available by location_id
	 *
	 * @param int $location_id
	 *
	 * @return array
	 */
	public function getTotalSeats($location_id) {
		$this->load->model('Location_tables_model');
		$this->Location_tables_model->select_sum('tables.max_capacity', 'total_seats');
		$this->Location_tables_model->where('location_id', $location_id);

		if ($row = $this->Location_tables_model->with('tables')->find()) {
			return $row['total_seats'];
		}
	}

	/**
	 * Update an existing reservation
	 *
	 * @param int   $reservation_id
	 * @param array $update
	 *
	 * @return bool
	 */
	public function updateReservation($reservation_id, $update = array()) {
		if (empty($update)) return FALSE;

		if (is_numeric($reservation_id)) {
			$query = $this->update($reservation_id, $update);

			$status = $this->Statuses_model->getStatus($update['status']);

			if (isset($update['notify']) AND $update['notify'] === '1') {
				$mail_data = $this->getMailData($reservation_id);

				$mail_data['status_name'] = $status['status_name'];
				$mail_data['status_comment'] = !empty($update['status_comment']) ? $update['status_comment'] : $this->lang->line('text_no_comment');

				$this->load->model('Mail_templates_model');
				$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'reservation_update');
				$update['notify'] = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
			}

			if ($query === TRUE AND (int)$update['old_status_id'] !== (int)$update['status']) {
				$update['object_id'] = $reservation_id;
				$update['staff_id'] = $this->user->getStaffId();
				$update['status_id'] = (int)$update['status'];
				$update['comment'] = $update['status_comment'];
				$update['date_added'] = mdate('%Y-%m-%d %H:%i:%s', time());

				$this->Statuses_model->addStatusHistory('reserve', $update);
			}

			return TRUE;
		}
	}

	/**
	 * Create a new reservation
	 *
	 * @param array $add
	 *
	 * @return bool
	 */
	public function addReservation($add = array()) {
		if (empty($add)) return FALSE;

		if (isset($add['reserve_date'])) {
			$add['reserve_date'] = mdate('%Y-%m-%d', strtotime($add['reserve_date']));
		}

		if ($reservation_id = $this->insert($add)) {

			if (APPDIR === MAINDIR) {
				log_activity($add['customer_id'], 'reserved', 'reservations', get_activity_message('activity_reserved_table', array('{customer}', '{link}', '{reservation_id}'), array($add['first_name'] . ' ' . $add['last_name'], admin_url('reservations/edit?id=' . $reservation_id), $reservation_id)));
			}

			$notify = $this->sendConfirmationMail($reservation_id);

			$update = array(
				'notify' => $notify,
				'status' => $this->config->item('default_reservation_status'),
			);

			if ($this->update($reservation_id, $update)) {
				$this->load->model('Statuses_model');
				$status = $this->Statuses_model->getStatus($this->config->item('default_reservation_status'));
				$reserve_history = array(
					'object_id'  => $reservation_id,
					'status_id'  => $status['status_id'],
					'notify'     => $notify,
					'comment'    => $status['status_comment'],
					'date_added' => mdate('%Y-%m-%d %H:%i:%s', time()),
				);

				$this->Statuses_model->addStatusHistory('reserve', $reserve_history);
			}
		}

		return $reservation_id;
	}

	/**
	 * Send the reservation confirmation email
	 *
	 * @param int $reservation_id
	 *
	 * @return string 0 on failure, or 1 on success
	 */
	protected function sendConfirmationMail($reservation_id) {
		$this->load->model('Mail_templates_model');
		$mail_data = $this->getMailData($reservation_id);
		$config_reservation_email = is_array($this->config->item('reservation_email')) ? $this->config->item('reservation_email') : array();

		$notify = '0';
		if ($this->config->item('customer_reserve_email') === '1' OR in_array('customer', $config_reservation_email)) {
			$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'reservation');
			$notify = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
		}

		if (!empty($mail_data['location_email']) AND ($this->config->item('location_reserve_email') === '1' OR in_array('location', $config_reservation_email))) {
			$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'reservation_alert');
			$this->sendMail($mail_data['location_email'], $mail_template, $mail_data);
		}

		if (in_array('admin', $config_reservation_email)) {
			$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'reservation_alert');
			$this->sendMail($this->config->item('site_email'), $mail_template, $mail_data);
		}

		return $notify;
	}

	/**
	 * Return the reservation data to build mail template
	 *
	 * @param int $reservation_id
	 *
	 * @return array
	 */
	public function getMailData($reservation_id) {
		$data = array();

		if ($result = $this->getReservation($reservation_id)) {
			$this->load->library('country');

			$data['reservation_number'] = $result['reservation_id'];
			$data['reservation_view_url'] = root_url('main/reservations?id=' . $result['reservation_id']);
			$data['reservation_time'] = mdate('%H:%i', strtotime($result['reserve_time']));
			$data['reservation_date'] = mdate('%l, %F %j, %Y', strtotime($result['reserve_date']));
			$data['reservation_guest_no'] = $result['guest_num'];
			$data['first_name'] = $result['first_name'];
			$data['last_name'] = $result['last_name'];
			$data['email'] = $result['email'];
			$data['telephone'] = $result['telephone'];
			$data['location_name'] = $result['location_name'];
			$data['location_email'] = $result['location_email'];
			$data['reservation_comment'] = $result['comment'];
		}

		return $data;
	}

	/**
	 * Send an email
	 *
	 * @param string $email
	 * @param array  $mail_template
	 * @param array  $mail_data
	 *
	 * @return bool|string
	 */
	public function sendMail($email, $mail_template = array(), $mail_data = array()) {
		if (empty($mail_template) OR !isset($mail_template['subject'], $mail_template['body']) OR empty($mail_data)) {
			return FALSE;
		}

		$this->load->library('email');

		$this->email->initialize();

		if (!empty($mail_data['status_comment'])) {
			$mail_data['status_comment'] = $this->email->parse_template($mail_data['status_comment'], $mail_data);
		}

		$this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
		$this->email->to(strtolower($email));
		$this->email->subject($mail_template['subject'], $mail_data);
		$this->email->message($mail_template['body'], $mail_data);

		if (!$this->email->send()) {
			log_message('debug', $this->email->print_debugger(array('headers')));
			$notify = '0';
		} else {
			$notify = '1';
		}

		return $notify;
	}

	/**
	 * Check if an reservation id already exists in database
	 *
	 * @param int $reservation_id
	 *
	 * @return bool
	 */
	public function validateReservation($reservation_id) {
		return (is_numeric($reservation_id) AND $this->find($reservation_id)) ? TRUE : FALSE;
	}

	/**
	 * Delete a single or multiple reservation by reservation_id
	 *
	 * @param string|array $reservation_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteReservation($reservation_id) {
		if (is_numeric($reservation_id)) $reservation_id = array($reservation_id);

		if (!empty($reservation_id) AND ctype_digit(implode('', $reservation_id))) {
			return $this->delete('reservation_id', $reservation_id);
		}
	}
}

/* End of file Reservations_model.php */
/* Location: ./system/tastyigniter/models/Reservations_model.php */