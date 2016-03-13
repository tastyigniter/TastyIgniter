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
class Reservations_model extends TI_Model {

	public function getCount($filter = array()) {
		if (APPDIR === ADMINDIR) {
			if ( ! empty($filter['filter_search'])) {
				$this->db->like('reservation_id', $filter['filter_search']);
				$this->db->or_like('LCASE(location_name)', strtolower($filter['filter_search']));
				$this->db->or_like('LCASE(first_name)', strtolower($filter['filter_search']));
				$this->db->or_like('LCASE(last_name)', strtolower($filter['filter_search']));
				$this->db->or_like('LCASE(table_name)', strtolower($filter['filter_search']));
				$this->db->or_like('LCASE(staff_name)', strtolower($filter['filter_search']));
			}

			if ( ! empty($filter['filter_status'])) {
				$this->db->where('reservations.status', $filter['filter_status']);
			}

			if ( ! empty($filter['filter_location'])) {
				$this->db->where('reservations.location_id', $filter['filter_location']);
			}

			if ( ! empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(reserve_date)', $date[0]);
				$this->db->where('MONTH(reserve_date)', $date[1]);

				if (isset($date[2])) {
					$this->db->where('DAY(reserve_date)', $date[2]);
				}
			} else if ( ! empty($filter['filter_year']) AND ! empty($filter['filter_month']) AND ! empty($filter['filter_day'])) {
				$this->db->where('YEAR(reserve_date)', $filter['filter_year']);
				$this->db->where('MONTH(reserve_date)', $filter['filter_month']);
				$this->db->where('DAY(reserve_date)', $filter['filter_day']);
			} else if ( ! empty($filter['filter_year']) AND ! empty($filter['filter_month'])) {
				$this->db->where('YEAR(reserve_date)', $filter['filter_year']);
				$this->db->where('MONTH(reserve_date)', $filter['filter_month']);
			}

			$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
			$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
			$this->db->join('staffs', 'staffs.staff_id = reservations.assignee_id', 'left');
		} else if ( ! empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			$this->db->where('customer_id', $filter['customer_id']);
		}

		$this->db->from('reservations');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('reservations');
			$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
			$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
			$this->db->join('statuses', 'statuses.status_id = reservations.status', 'left');

			if (APPDIR === ADMINDIR) {
				$this->db->join('staffs', 'staffs.staff_id = reservations.assignee_id', 'left');

				if ( ! empty($filter['filter_search'])) {
					$this->db->like('reservation_id', $filter['filter_search']);
					$this->db->or_like('LCASE(location_name)', strtolower($filter['filter_search']));
					$this->db->or_like('LCASE(first_name)', strtolower($filter['filter_search']));
					$this->db->or_like('LCASE(last_name)', strtolower($filter['filter_search']));
					$this->db->or_like('LCASE(table_name)', strtolower($filter['filter_search']));
					$this->db->or_like('LCASE(staff_name)', strtolower($filter['filter_search']));
				}

				if ( ! empty($filter['filter_status'])) {
					$this->db->where('reservations.status', $filter['filter_status']);
				}

				if ( ! empty($filter['filter_location'])) {
					$this->db->where('reservations.location_id', $filter['filter_location']);
				}

				if ( ! empty($filter['filter_date'])) {
					$date = explode('-', $filter['filter_date']);
					$this->db->where('YEAR(reserve_date)', $date[0]);
					$this->db->where('MONTH(reserve_date)', $date[1]);

					if (isset($date[2])) {
						$this->db->where('DAY(reserve_date)', (int) $date[2]);
					}
				} else if ( ! empty($filter['filter_year']) AND ! empty($filter['filter_month']) AND ! empty($filter['filter_day'])) {
					$this->db->where('YEAR(reserve_date)', $filter['filter_year']);
					$this->db->where('MONTH(reserve_date)', $filter['filter_month']);
					$this->db->where('DAY(reserve_date)', $filter['filter_day']);
				} else if ( ! empty($filter['filter_year']) AND ! empty($filter['filter_month'])) {
					$this->db->where('YEAR(reserve_date)', $filter['filter_year']);
					$this->db->where('MONTH(reserve_date)', $filter['filter_month']);
				}
			} else if ( ! empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
				$this->db->where('customer_id', $filter['customer_id']);
			}

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getReservations() {
		$this->db->from('reservations');
		$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
		$this->db->join('statuses', 'statuses.status_id = reservations.status', 'left');
		$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
		$this->db->join('countries', 'countries.country_id = locations.location_country_id', 'left');
		$this->db->order_by('reservation_id', 'ASC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getReservation($reservation_id = FALSE, $customer_id = FALSE) {
		if ($reservation_id !== FALSE) {
			if (APPDIR === ADMINDIR) {
				$this->db->select('*, reservations.date_added, reservations.date_modified, reservations.status, tables.table_id, staffs.staff_id, locations.location_id');
				$this->db->join('staffs', 'staffs.staff_id = reservations.assignee_id', 'left');
			} else {
				$this->db->select('reservation_id, table_name, reservations.location_id, location_name, location_address_1, location_address_2, location_city, location_postcode, location_country_id, table_name, min_capacity, max_capacity, guest_num, occasion_id, customer_id, first_name, last_name, telephone, email, reserve_time, reserve_date, status_name, reservations.date_added, reservations.date_modified, reservations.status, comment, notify, ip_address, user_agent');
			}

			$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
			$this->db->join('statuses', 'statuses.status_id = reservations.status', 'left');
			$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
			$this->db->join('countries', 'countries.country_id = locations.location_country_id', 'left');

			$this->db->from('reservations');
			$this->db->where('reservation_id', $reservation_id);

			if (APPDIR === MAINDIR) {
				if ($customer_id !== FALSE) {
					$this->db->where('customer_id', $customer_id);
				}
			}

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getReservationDates() {
		$this->db->select('reserve_date, MONTH(reserve_date) as month, YEAR(reserve_date) as year');
		$this->db->from('reservations');
		$this->db->group_by('MONTH(reserve_date)');
		$this->db->group_by('YEAR(reserve_date)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getTotalCapacityByLocation($location_id = FALSE) {
		$result = 0;

		$this->db->select_sum('tables.max_capacity', 'total_seats');

		if ( ! empty($location_id)) {
			$this->db->where('location_id', $location_id);
		}

		$this->db->from('location_tables');
		$this->db->join('tables', 'tables.table_id = location_tables.table_id', 'left');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$result = $row['total_seats'];
		}

		return $result;
	}

	public function getTotalGuestsByLocation($location_id = FALSE, $date = FALSE) {
		$result = 0;

		$this->db->select_sum('reservations.guest_num', 'total_guest');
		//$this->db->where('status', (int)$this->config->item('default_reservation_status'));

		if ( ! empty($location_id)) {
			$this->db->where('location_id', $location_id);
		}

		if ( ! empty($date)) {
			$this->db->where('DATE(reserve_date)', $date);
		}

		$this->db->group_by('DAY(reserve_date)');
		$this->db->from('reservations');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$result = $row['total_guest'];
		}

		return $result;
	}

	public function getLocationTablesByMinCapacity($location_id, $guest_num) {

		$tables = array();

		if (isset($location_id, $guest_num)) {
			$this->db->from('location_tables');
			$this->db->join('tables', 'tables.table_id = location_tables.table_id', 'left');

			$this->db->where('location_id', $location_id);
			$this->db->where('table_status', '1');

			$this->db->group_start();
			$this->db->where('min_capacity <=', $guest_num);
			$this->db->where('max_capacity >=', $guest_num);
			$this->db->group_end();

			$this->db->order_by('min_capacity', 'ASC');

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$tables[$row['table_id']] = $row;
				}
			}
		}

		return $tables;
	}

	public function findATable($find = array()) {

		if ( ! isset($find['location']) OR ! isset($find['guest_num']) OR empty($find['reserve_date']) OR empty($find['reserve_time']) OR empty($find['time_interval'])) {
			return 'NO_ARGUMENTS';
		}

		if ( ! ($available_tables = $this->getLocationTablesByMinCapacity($find['location'], $find['guest_num']))) {
			return 'NO_TABLE';
		}

		$find['reserve_date_time'] = strtotime($find['reserve_date'] . ' ' . $find['reserve_time']);
		$find['unix_start_time'] = strtotime('-' . ($find['time_interval'] * 2) . ' mins', $find['reserve_date_time']);
		$find['unix_end_time'] = strtotime('+' . ($find['time_interval'] * 2) . ' mins', $find['reserve_date_time']);

		$time_slots = time_range(mdate('%H:%i', $find['unix_start_time']), mdate('%H:%i', $find['unix_end_time']),
		                         $find['time_interval'], '%H:%i');
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

	public function getReservedTableByDate($find = array(), $table_id, $group = FALSE) {
		if ( ! isset($find['location']) OR ! is_numeric($find['location']) OR empty($find['reserve_date']) OR empty($table_id)) {
			return FALSE;
		}

		is_array($table_id) OR $table_id = array($table_id);

		$this->db->from('reservations');
		$this->db->where('location_id', $find['location']);

		if ( ! empty($table_id)) {
			$this->db->where_in('table_id', $table_id);
		}

		$this->db->group_start();
		$this->db->where('ADDTIME(reserve_date, reserve_time) >=',
		                 mdate('%Y-%m-%d %H:%i:%s', $find['unix_start_time']));
		$this->db->where('ADDTIME(reserve_date, reserve_time) <=', mdate('%Y-%m-%d %H:%i:%s', $find['unix_end_time']));
		$this->db->group_end();

		$query = $this->db->get();

		$results = array();
		if ($query->num_rows() > 0) {
			if ($group) {
				foreach ($query->result_array() as $row) {
					$results[$row['table_id']][] = $row;
				}
			} else {
				$results = $query->result_array();
			}
		}

		return $results;
	}

	public function getTotalSeats($location_id) {
		$this->db->select_sum('tables.max_capacity', 'total_seats');
		$this->db->where('location_id', $location_id);
		$this->db->from('location_tables');
		$this->db->join('tables', 'tables.table_id = location_tables.table_id', 'left');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();

			return $row['total_seats'];
		}
	}

	public function updateReservation($reservation_id, $update = array()) {
		if (empty($update)) return FALSE;

		if (isset($update['status'])) {
			$this->db->set('status', $update['status']);
		}

		if (isset($update['assignee_id'])) {
			$this->db->set('assignee_id', $update['assignee_id']);
		}

		if (isset($update['date_modified'])) {
			$this->db->set('date_modified', mdate('%Y-%m-%d', time()));
		}

		if (is_numeric($reservation_id)) {
			$this->db->where('reservation_id', $reservation_id);
			$query = $this->db->update('reservations');

			$status = $this->Statuses_model->getStatus($update['status']);

			if (isset($update['notify']) AND $update['notify'] === '1') {
				$mail_data = $this->getMailData($reservation_id);

				$mail_data['status_name'] = $status['status_name'];
				$mail_data['status_comment'] = !empty($update['status_comment']) ? $update['status_comment'] : $this->lang->line('text_no_comment');

				$this->load->model('Mail_templates_model');
				$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'reservation_update');
				$update['notify'] = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
			}

			if ($query === TRUE AND (int) $update['old_status_id'] !== (int) $update['status']) {
				$update['object_id'] = $reservation_id;
				$update['staff_id'] = $this->user->getStaffId();
				$update['status_id'] = (int) $update['status'];
				$update['comment'] = $update['status_comment'];
				$update['date_added'] = mdate('%Y-%m-%d %H:%i:%s', time());

				$this->Statuses_model->addStatusHistory('reserve', $update);
			}
		}

		return $query;
	}

	public function addReservation($add = array()) {
		if (empty($add)) return FALSE;

		if (isset($add['location_id'])) {
			$this->db->set('location_id', $add['location_id']);
		}

		if (isset($add['table_id'])) {
			$this->db->set('table_id', $add['table_id']);
		}

		if (isset($add['customer_id'])) {
			$this->db->set('customer_id', $add['customer_id']);
		}

		if (isset($add['guest_num'])) {
			$this->db->set('guest_num', $add['guest_num']);
		}

		if (isset($add['reserve_date'])) {
			$this->db->set('reserve_date', mdate('%Y-%m-%d', strtotime($add['reserve_date'])));
		}

		if (isset($add['reserve_time'])) {
			$this->db->set('reserve_time', $add['reserve_time']);
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
			$this->db->set('date_modified', mdate('%Y-%m-%d', time()));
		}

		if (isset($add['occasion_id'])) {
			$this->db->set('occasion_id', $add['occasion_id']);
		}

		if (isset($add['customer_id'])) {
			$this->db->set('customer_id', $add['customer_id']);
		}

		if (isset($add['first_name'])) {
			$this->db->set('first_name', $add['first_name']);
		}

		if (isset($add['last_name'])) {
			$this->db->set('last_name', $add['last_name']);
		}

		if (isset($add['email'])) {
			$this->db->set('email', $add['email']);
		}

		if (isset($add['telephone'])) {
			$this->db->set('telephone', $add['telephone']);
		}

		if (isset($add['comment'])) {
			$this->db->set('comment', $add['comment']);
		}

		if (isset($add['user_agent'])) {
			$this->db->set('user_agent', $add['user_agent']);
		}

		if (isset($add['ip_address'])) {
			$this->db->set('ip_address', $add['ip_address']);
		}

		if ( ! empty($add)) {
			if ($this->db->insert('reservations')) {
				$reservation_id = $this->db->insert_id();

				if (APPDIR === MAINDIR) {
					log_activity($add['customer_id'], 'reserved', 'reservations',
					             get_activity_message('activity_reserved_table',
					                                  array('{customer}', '{link}', '{reservation_id}'),
					                                  array($add['first_name'] . ' ' . $add['last_name'], admin_url('reservations/edit?id=' . $reservation_id), $reservation_id)
					             ));
				}

				$this->load->model('Mail_templates_model');
				$mail_data = $this->getMailData($reservation_id);
				$config_reservation_email = is_array($this->config->item('reservation_email')) ? $this->config->item('reservation_email') : array();

				$notify = '0';
				if ($this->config->item('customer_reserve_email') === '1' OR in_array('customer', $config_reservation_email)) {
					$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'reservation');
					$notify = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
				}

				if ($this->location->getEmail() AND ($this->config->item('location_reserve_email') === '1' OR in_array('location', $config_reservation_email))) {
					$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'reservation_alert');
					$this->sendMail($this->location->getEmail(), $mail_template, $mail_data);
				}

				if (in_array('admin', $config_reservation_email)) {
					$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'reservation_alert');
					$this->sendMail($this->config->item('site_email'), $mail_template, $mail_data);
				}

				$this->db->set('notify', $notify);

				$this->db->set('status', $this->config->item('default_reservation_status'));
				$this->db->where('reservation_id', $reservation_id);

				if ($this->db->update('reservations')) {
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

				$query = $reservation_id;
			}
		}

		return $query;
	}

	public function getMailData($reservation_id) {
		$data = array();

		$result = $this->getReservation($reservation_id);
		if ($result) {
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
			$data['reservation_comment'] = $result['comment'];
		}

		return $data;
	}

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

		if ( ! $this->email->send()) {
			log_message('debug', $this->email->print_debugger(array('headers')));
			$notify = '0';
		} else {
			$notify = '1';
		}

		return $notify;
	}

	public function validateReservation($reservation_id) {
		if ( ! empty($reservation_id)) {
			$this->db->from('reservations');
			$this->db->where('reservation_id', $reservation_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}

	public function deleteReservation($reservation_id) {
		if (is_numeric($reservation_id)) $reservation_id = array($reservation_id);

		if ( ! empty($reservation_id) AND ctype_digit(implode('', $reservation_id))) {
			$this->db->where_in('reservation_id', $reservation_id);
			$this->db->delete('reservations');

			return $this->db->affected_rows();
		}
	}
}

/* End of file reservations_model.php */
/* Location: ./system/tastyigniter/models/reservations_model.php */