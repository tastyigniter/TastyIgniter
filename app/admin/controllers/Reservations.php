<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reservations extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Reservations');

        $this->load->model('Reservations_model');
        $this->load->model('Locations_model');
        $this->load->model('Statuses_model');
        $this->load->model('Tables_model');
        $this->load->model('Staffs_model');

        $this->load->library('pagination');
        $this->load->library('calendar');

        $this->lang->load('reservations');
    }

	public function index() {
		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		if (is_numeric($this->input->get('show_calendar'))) {
			$filter['show_calendar'] = $data['show_calendar'] = $this->input->get('show_calendar');
			$url .= 'show_calendar='.$filter['show_calendar'].'&';
		} else {
			$data['show_calendar'] = '';
		}

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}

		if ($data['user_strict_location'] = $this->user->isStrictLocation()) {
			$filter['filter_location'] = $data['filter_location'] = $this->user->getLocationId();
			$url .= 'filter_location='.$filter['filter_location'].'&';
		} else if (is_numeric($this->input->get('filter_location'))) {
			$filter['filter_location'] = $data['filter_location'] = $this->input->get('filter_location');
			$url .= 'filter_location='.$filter['filter_location'].'&';
		} else {
			$filter['filter_location'] = $data['filter_location'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if (is_numeric($this->input->get('filter_year'))) {
			$filter['filter_year'] = $data['filter_year'] = $this->input->get('filter_year');
		} else {
			$filter['filter_year'] = $data['filter_year'] = '';
		}

		if (is_numeric($this->input->get('filter_month'))) {
			$filter['filter_month'] = $data['filter_month'] = $this->input->get('filter_month');
		} else {
			$filter['filter_month'] = $data['filter_month'] = '';
		}

		if (is_numeric($this->input->get('filter_day'))) {
			$filter['filter_day'] = $data['filter_day'] = $this->input->get('filter_day');
		} else {
			$filter['filter_day'] = $data['filter_day'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'reserve_date';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = 'ASC';
		}

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deleteReservation() === TRUE) {
			redirect('reservations');
		}

		if ($this->input->get('show_calendar') === '1') {
			$day = ($filter['filter_day'] === '') ? date('d', time()) : $filter['filter_day'];
			$month = ($filter['filter_month'] === '') ? date('m', time()) : $filter['filter_month'];
			$year = ($filter['filter_year'] === '') ? date('Y', time()) :  $filter['filter_year'];
			$url .= 'filter_year='.$filter['filter_year'].'&filter_month='.$filter['filter_month'].'&filter_day='.$filter['filter_day'].'&';

			$data['days'] = $this->calendar->get_total_days($month, $year);
			$data['months'] = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
			$data['years'] = array('2011', '2012', '2013', '2014', '2015', '2016', '2017');

			$total_tables = $this->Reservations_model->getTotalCapacityByLocation($filter['filter_location']);

			$calendar_data = array();
			for ($i = 1; $i <= $data['days']; $i++) {
				$date = $year . '-' . $month . '-' . $i;
				$reserve_date = mdate('%Y-%m-%d', strtotime($date));
				$total_guests = $this->Reservations_model->getTotalGuestsByLocation($filter['filter_location'], $reserve_date);
				$state  = '';
				if ($total_guests < 1) {
					$state  = 'no_booking';
				} else if ($total_guests > 0 AND $total_guests < $total_tables) {
					$state  = 'half_booked';
				} else if ($total_guests >= $total_tables) {
					$state  = 'booked';
				}

				$fmt_day = (strlen($i) == 1) ? '0'.$i : $i;
				if ($fmt_day == $day) {
					$calendar_data[$i]  = $state.' selected';
				} else {
					$calendar_data[$i]  = $state;
				}
			}

            $calendar_data['url'] = site_url('reservations');
            $calendar_data['url_suffix'] = $url;
			$this->template->setIcon('<a class="btn btn-default" title="'.$this->lang->line('text_switch_to_list').'" href="'.site_url('reservations/') .'"><i class="fa fa-list"></i></a>');
			$data['calendar'] = $this->calendar->generate($year, $month, $calendar_data);
		} else {
			$this->template->setIcon('<a class="btn btn-default" title="'.$this->lang->line('text_switch_to_calendar').'" href="'.site_url('reservations?show_calendar=1') .'"><i class="fa fa-calendar"></i></a>');
			$data['calendar'] = '';
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_id'] 			= site_url('reservations'.$url.'sort_by=reservation_id&order_by='.$order_by);
		$data['sort_location'] 		= site_url('reservations'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_customer'] 		= site_url('reservations'.$url.'sort_by=first_name&order_by='.$order_by);
		$data['sort_guest'] 		= site_url('reservations'.$url.'sort_by=guest_num&order_by='.$order_by);
		$data['sort_table'] 		= site_url('reservations'.$url.'sort_by=table_name&order_by='.$order_by);
		$data['sort_status']		= site_url('reservations'.$url.'sort_by=status_name&order_by='.$order_by);
		$data['sort_staff'] 		= site_url('reservations'.$url.'sort_by=staff_name&order_by='.$order_by);
		$data['sort_date'] 			= site_url('reservations'.$url.'sort_by=reserve_date&order_by='.$order_by);

		$data['reservations'] = array();
		$results = $this->Reservations_model->getList($filter);
		foreach ($results as $result) {
			$data['reservations'][] = array(
				'reservation_id'	=> $result['reservation_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'guest_num'			=> $result['guest_num'],
				'table_name'		=> $result['table_name'],
                'status_name'		=> $result['status_name'],
                'status_color'		=> $result['status_color'],
				'staff_name'		=> $result['staff_name'],
				'reserve_date'		=> day_elapsed($result['reserve_date']),
				'reserve_time'		=> mdate('%H:%i', strtotime($result['reserve_time'])),
				'edit'				=> site_url('reservations/edit?id=' . $result['reservation_id'])
			);
		}

		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$data['statuses'] = array();
		$statuses = $this->Statuses_model->getStatuses('reserve');
		foreach ($statuses as $status) {
			$data['statuses'][] = array(
				'status_id'	=> $status['status_id'],
				'status_name'	=> $status['status_name']
			);
		}

		$data['reserve_dates'] = array();
		$reserve_dates = $this->Reservations_model->getReservationDates();
		foreach ($reserve_dates as $reserve_date) {
			$month_year = $reserve_date['year'].'-'.$reserve_date['month'];
			$data['reserve_dates'][$month_year] = mdate('%F %Y', strtotime($reserve_date['reserve_date']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('reservations'.$url);
		$config['total_rows'] 		= $this->Reservations_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('reservations', $data);
	}

	public function edit() {
		$reservation_info = $this->Reservations_model->getReservation((int) $this->input->get('id'));

		if ($reservation_info) {
			$reservation_id = $reservation_info['reservation_id'];
			$data['_action']	= site_url('reservations/edit?id='. $reservation_id);
		} else {
		    $reservation_id = 0;
			//$data['_action']	= site_url('reservations/edit');
			redirect('reservations');
		}

		$title = (isset($reservation_info['reservation_id'])) ? $reservation_info['reservation_id'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('reservations')));

		if ($this->input->post() AND $this->_updateReservation() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('reservations');
			}

			redirect('reservations/edit?id='. $reservation_id);
		}

		$data['reservation_id'] 	= $reservation_info['reservation_id'];
		$data['location_name'] 		= $reservation_info['location_name'];
		$data['location_address_1'] = $reservation_info['location_address_1'];
		$data['location_address_2'] = $reservation_info['location_address_2'];
		$data['location_city'] 		= $reservation_info['location_city'];
		$data['location_postcode'] 	= $reservation_info['location_postcode'];
		$data['location_country'] 	= $reservation_info['country_name'];
		$data['table_name'] 		= $reservation_info['table_name'];
		$data['min_capacity'] 		= $reservation_info['min_capacity'] .' person(s)';
		$data['max_capacity'] 		= $reservation_info['max_capacity'] .' person(s)';
		$data['guest_num'] 			= $reservation_info['guest_num'] .' person(s)';
		$data['occasion'] 			= $reservation_info['occasion_id'];
		$data['customer_id'] 		= $reservation_info['customer_id'];
		$data['first_name'] 		= $reservation_info['first_name'];
		$data['last_name'] 			= $reservation_info['last_name'];
		$data['email'] 				= $reservation_info['email'];
		$data['telephone'] 			= $reservation_info['telephone'];
		$data['reserve_time'] 		= mdate('%H:%i', strtotime($reservation_info['reserve_time']));
		$data['reserve_date'] 		= mdate('%d %M %y', strtotime($reservation_info['reserve_date']));
		$data['date_added'] 		= mdate('%d %M %y', strtotime($reservation_info['date_added']));
		$data['date_modified'] 		= mdate('%d %M %y', strtotime($reservation_info['date_modified']));
		$data['status_id'] 			= $reservation_info['status'];
		$data['assignee_id'] 		= $reservation_info['assignee_id'];
		$data['comment'] 			= $reservation_info['comment'];
		$data['notify'] 			= $reservation_info['notify'];
		$data['ip_address'] 		= $reservation_info['ip_address'];
		$data['user_agent'] 		= $reservation_info['user_agent'];

		$data['occasions'] = array(
			'0' => 'not applicable',
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party'
		);

		$data['statuses'] = array();
		$statuses = $this->Statuses_model->getStatuses('reserve');
		foreach ($statuses as $status) {
			$data['statuses'][] = array(
				'status_id'	=> $status['status_id'],
				'status_name'	=> $status['status_name']
			);
		}

		$data['status_history'] = array();
		$status_history = $this->Statuses_model->getStatusHistories('reserve', $reservation_id);
		foreach ($status_history as $history) {
			$data['status_history'][] = array(
				'history_id'	=> $history['status_history_id'],
				'date_time'		=> mdate('%d %M %y - %H:%i', strtotime($history['date_added'])),
				'staff_name'	=> $history['staff_name'],
				'assignee_id'	=> $history['assignee_id'],
				'status_name'	=> $history['status_name'],
				'status_color'	=> $history['status_color'],
				'notify'		=> $history['notify'],
				'comment'		=> $history['comment']
			);
		}

		$data['staffs'] = array();
		$staffs = $this->Staffs_model->getStaffs();
		foreach ($staffs as $staff) {
			$data['staffs'][] = array(
				'staff_id'		=> $staff['staff_id'],
				'staff_name'	=> $staff['staff_name']
			);
		}

		$this->template->render('reservations_edit', $data);
	}

	private function _updateReservation() {
    	if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			if ($this->Reservations_model->updateReservation($this->input->get('id'), $this->input->post())) {
                log_activity($this->user->getStaffId(), 'updated', 'reservations', get_activity_message('activity_custom',
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), 'updated', 'reservation', current_url(), $this->input->get('id'))
                ));

                if ($this->input->post('old_assignee_id') !== $this->input->post('assignee_id') OR $this->input->post('old_status_id') !== $this->input->post('status_id')) {
	                $staff = $this->Staffs_model->getStaff($this->input->post('assignee_id'));
	                $staff_assignee = site_url('staffs/edit?id='.$staff['staff_id']);

	                log_activity($this->user->getStaffId(), 'assigned', 'reservations', get_activity_message('activity_assigned',
                        array('{staff}', '{action}', '{context}', '{link}', '{item}', '{assignee}'),
                        array($this->user->getStaffName(), 'assigned', 'reservation', current_url(), $this->input->get('id'), "<a href=\"{$staff_assignee}\">{$staff['staff_name']}</a>")
                    ));
                }

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Reservation updated'));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
			}

			return TRUE;
		}
	}

	private function _deleteReservation() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Reservations_model->deleteReservation($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Reservations': 'Reservation';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('assignee_id', 'lang:label_assign_staff', 'xss_clean|trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file reservations.php */
/* Location: ./admin/controllers/reservations.php */