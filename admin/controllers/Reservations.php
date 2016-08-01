<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Reservations extends Admin_Controller
{

	public $list_filters = array(
		'show_calendar'   => '',
		'filter_search'   => '',
		'filter_location' => '',
		'filter_date'     => '',
		'filter_year'     => '',
		'filter_month'    => '',
		'filter_day'      => '',
		'filter_status'   => '',
		'sort_by'         => 'reserve_date',
		'order_by'        => 'ASC',
	);

	public $sort_columns = array('reservation_id', 'location_name', 'first_name', 'guest_num',
		'table_name', 'status_name', 'staff_name', 'reserve_date');

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Reservations');

		$this->load->model('Reservations_model');
		$this->load->model('Locations_model');
		$this->load->model('Statuses_model');
		$this->load->model('Tables_model');
		$this->load->model('Staffs_model');

		$this->load->library('calendar');

		$this->lang->load('reservations');
	}

	public function index() {
		if ($this->input->post('delete') AND $this->_deleteReservation() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('reservations', $data);
	}

	public function edit() {
		if ($this->input->post() AND $reservation_id = $this->_updateReservation()) {
			$this->redirect($reservation_id);
		}

		$reservation_info = $this->Reservations_model->getReservation((int)$this->input->get('id'));

		$title = (isset($reservation_info['reservation_id'])) ? $reservation_info['reservation_id'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('reservations')));

		$data = $this->getForm($reservation_info);

		$this->template->render('reservations_edit', $data);
	}

	protected function getList() {
		$data = $this->getCalendar();
		if ($data['user_strict_location'] = $this->user->isStrictLocation()) {
			$this->list_filters['filter_location'] = $this->user->getLocationId();
		}

		$data = array_merge($this->list_filters, $this->sort_columns, $data);
		$data['order_by_active'] = $this->list_filters['order_by'] . ' active';

		$data['reservations'] = array();
		$results = $this->Reservations_model->paginate($this->list_filters, $this->index_url);
		foreach ($results->list as $result) {
			$data['reservations'][] = array_merge($result, array(
				'reserve_date' => day_elapsed($result['reserve_date']),
				'reserve_time' => mdate('%H:%i', strtotime($result['reserve_time'])),
				'edit'         => $this->pageUrl($this->edit_url, array('id' => $result['reservation_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		$data['locations'] = $this->Locations_model->isEnabled()->dropdown('location_name');

		$data['statuses'] = $this->Statuses_model->isForReservation()->dropdown('status_name');

		$data['reserve_dates'] = array();
		$reserve_dates = $this->Reservations_model->getReservationDates();
		foreach ($reserve_dates as $reserve_date) {
			$month_year = $reserve_date['year'] . '-' . $reserve_date['month'];
			$data['reserve_dates'][$month_year] = mdate('%F %Y', strtotime($reserve_date['reserve_date']));
		}

		return $data;
	}

	protected function getForm($reservation_info = array()) {
		$data = $reservation_info;

		if (!empty($reservation_info['reservation_id'])) {
			$reservation_id = $reservation_info['reservation_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $reservation_id));
		} else {
			$reservation_id = 0;
			//$data['_action']	= $this->pageUrl($this->create_url);
			$this->redirect();
		}

		$data['reservation_id'] = $reservation_info['reservation_id'];
		$data['location_name'] = $reservation_info['location_name'];
		$data['location_address_1'] = $reservation_info['location_address_1'];
		$data['location_address_2'] = $reservation_info['location_address_2'];
		$data['location_city'] = $reservation_info['location_city'];
		$data['location_postcode'] = $reservation_info['location_postcode'];
		$data['location_country'] = $reservation_info['country_name'];
		$data['table_name'] = $reservation_info['table_name'];
		$data['min_capacity'] = $reservation_info['min_capacity'] . ' person(s)';
		$data['max_capacity'] = $reservation_info['max_capacity'] . ' person(s)';
		$data['guest_num'] = $reservation_info['guest_num'] . ' person(s)';
		$data['occasion'] = $reservation_info['occasion_id'];
		$data['customer_id'] = $reservation_info['customer_id'];
		$data['first_name'] = $reservation_info['first_name'];
		$data['last_name'] = $reservation_info['last_name'];
		$data['email'] = $reservation_info['email'];
		$data['telephone'] = $reservation_info['telephone'];
		$data['reserve_time'] = mdate('%H:%i', strtotime($reservation_info['reserve_time']));
		$data['reserve_date'] = mdate('%d %M %y', strtotime($reservation_info['reserve_date']));
		$data['date_added'] = mdate('%d %M %y', strtotime($reservation_info['date_added']));
		$data['date_modified'] = mdate('%d %M %y', strtotime($reservation_info['date_modified']));
		$data['status_id'] = $reservation_info['status'];
		$data['assignee_id'] = $reservation_info['assignee_id'];
		$data['comment'] = $reservation_info['comment'];
		$data['notify'] = $reservation_info['notify'];
		$data['ip_address'] = $reservation_info['ip_address'];
		$data['user_agent'] = $reservation_info['user_agent'];

		$data['occasions'] = array(
			'0' => 'not applicable',
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party',
		);

		$data['staffs'] = $this->Staffs_model->isEnabled()->dropdown('staff_name');

		$data['statuses'] = $this->Statuses_model->isForReservation()->dropdown('status_name');

		$data['status_history'] = array();
		$status_history = $this->Statuses_model->getStatusHistories('reserve', $reservation_id);
		foreach ($status_history as $history) {
			$data['status_history'][] = array_merge($history, array(
				'history_id' => $history['status_history_id'],
				'date_time'  => mdate('%d %M %y - %H:%i', strtotime($history['date_added'])),
			));
		}

		return $data;
	}

	protected function getCalendar() {
		$data['calendar'] = '';

		if ($this->input->get('show_calendar') === '1') {
			$day = ($this->list_filters['filter_day'] === '') ? date('d', time()) : $this->list_filters['filter_day'];
			$month = ($this->list_filters['filter_month'] === '') ? date('m', time()) : $this->list_filters['filter_month'];
			$year = ($this->list_filters['filter_year'] === '') ? date('Y', time()) : $this->list_filters['filter_year'];

			$data['days'] = $this->calendar->get_total_days($month, $year);
			$data['months'] = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
			$data['years'] = array('2011', '2012', '2013', '2014', '2015', '2016', '2017');

			$calendar_data = $this->getCalendarData($data['days'], $month, $year, $day);

			$this->template->setIcon('<a class="btn btn-default" title="' . $this->lang->line('text_switch_to_list') . '" href="' . site_url('reservations/') . '"><i class="fa fa-list"></i></a>');
			$data['calendar'] = $this->calendar->generate($year, $month, $calendar_data);
		} else {
			$this->template->setIcon('<a class="btn btn-default" title="' . $this->lang->line('text_switch_to_calendar') . '" href="' . site_url('reservations?show_calendar=1') . '"><i class="fa fa-calendar"></i></a>');
		}

		return $data;
	}

	protected function getCalendarData($days, $month, $year, $day) {
		$total_tables = $this->Reservations_model->getTotalCapacityByLocation($this->list_filters['filter_location']);

		$reserve_dates = array();
		for ($i = 1; $i <= $days; $i++) {
			$reserve_dates[] = mdate('%Y-%m-%d', strtotime($year . '-' . $month . '-' . $i));
		}

		$calendar_data = array();
		$total_guests = $this->Reservations_model->getTotalGuestsByLocation($this->list_filters['filter_location'], $reserve_dates);
		foreach ($reserve_dates as $date) {
			$state = '';
			if (isset($total_guests[$date]) AND $total_guest = $total_guests[$date]) {
				if ($total_guest < 1) {
					$state = 'no_booking';
				} else if ($total_guest > 0 AND $total_guest < $total_tables) {
					$state = 'half_booked';
				} else if ($total_guest >= $total_tables) {
					$state = 'booked';
				}
			}

			$fmt_day = mdate('%d', strtotime($date));
			if ($fmt_day == $day) {
				$state .= ' selected';
			}

			$calendar_data[$fmt_day] = $state;
		}

		$url = array_diff_key(array_filter($this->input->get()), array_flip(array('filter_day', 'filter_month', 'filter_year')));
		$calendar_data['url'] = $this->pageUrl();
		$calendar_data['url_suffix'] = '?' . http_build_query($url) . '&';

		return $calendar_data;
	}

	protected function _updateReservation() {
		if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			if ($reservation_id = $this->Reservations_model->updateReservation($this->input->get('id'), $this->input->post())) {
				log_activity($this->user->getStaffId(), 'updated', 'reservations', get_activity_message('activity_custom',
					array('{staff}', '{action}', '{context}', '{link}', '{item}'),
					array($this->user->getStaffName(), 'updated', 'reservation', current_url(), $this->input->get('id'))
				));

				if ($this->input->post('old_assignee_id') !== $this->input->post('assignee_id') OR $this->input->post('old_status_id') !== $this->input->post('status_id')) {
					$staff = $this->Staffs_model->getStaff($this->input->post('assignee_id'));
					$staff_assignee = $this->pageUrl('staffs/edit?id=' . $staff['staff_id']);

					log_activity($this->user->getStaffId(), 'assigned', 'reservations', get_activity_message('activity_assigned',
						array('{staff}', '{action}', '{context}', '{link}', '{item}', '{assignee}'),
						array($this->user->getStaffName(), 'assigned', 'reservation', current_url(), $this->input->get('id'), "<a href=\"{$staff_assignee}\">{$staff['staff_name']}</a>")
					));
				}

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Reservation updated'));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
			}

			return $reservation_id;
		}
	}

	protected function _deleteReservation() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Reservations_model->deleteReservation($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Reservations' : 'Reservation';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules[] = array('status', 'lang:label_status', 'xss_clean|trim|required|integer|callback__status_exists');
		$rules[] = array('assignee_id', 'lang:label_assign_staff', 'xss_clean|trim|integer');

		return $this->Reservations_model->set_rules($rules)->validate();
	}

	public function _status_exists($str) {
		$reserve_status_exists = $this->Statuses_model->statusExists('reserve', $this->input->get('id'), $str);
		if ($reserve_status_exists) {
			$this->form_validation->set_message('_status_exists', $this->lang->line('error_status_exists'));
			return FALSE;
		} else {
			return TRUE;
		}

	}
}

/* End of file Reservations.php */
/* Location: ./admin/controllers/Reservations.php */