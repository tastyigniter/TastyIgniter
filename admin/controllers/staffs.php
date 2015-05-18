<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Staffs extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Staffs_model');
		$this->load->model('Locations_model'); // load the locations model
		$this->load->model('Staff_groups_model');
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

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}

		if ($this->input->get('filter_group')) {
			$filter['filter_group'] = $data['filter_group'] = $this->input->get('filter_group');
			$url .= 'filter_group='.$filter['filter_group'].'&';
		} else {
			$filter['filter_group'] = $data['filter_group'] = '';
		}

    	if (is_numeric($this->input->get('filter_location'))) {
			$filter['filter_location'] = $data['filter_location'] = $this->input->get('filter_location');
			$url .= 'filter_location='.$filter['filter_location'].'&';
		} else {
			$filter['filter_location'] = $data['filter_location'] = '';
		}

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'staffs.date_added';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}

		$this->template->setTitle('Staffs');
		$this->template->setHeading('Staffs');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no staffs available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('staffs'.$url.'sort_by=staff_name&order_by='.$order_by);
		$data['sort_group']			= site_url('staffs'.$url.'sort_by=staff_group_name&order_by='.$order_by);
		$data['sort_location'] 		= site_url('staffs'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_date'] 			= site_url('staffs'.$url.'sort_by=date_added&order_by='.$order_by);
		$data['sort_id'] 			= site_url('staffs'.$url.'sort_by=staff_id&order_by='.$order_by);

		$data['staffs'] = array();
		$results = $this->Staffs_model->getList($filter);
		foreach ($results as $result) {

			$data['staffs'][] = array(
				'staff_id' 				=> $result['staff_id'],
				'staff_name' 			=> $result['staff_name'],
				'staff_email' 			=> $result['staff_email'],
				'staff_group_name' 		=> $result['staff_group_name'],
				'location_name' 		=> $result['location_name'],
				'date_added' 			=> mdate('%d %M %y', strtotime($result['date_added'])),
				'staff_status' 			=> ($result['staff_status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 					=> site_url('staffs/edit?id=' . $result['staff_id'])
			);
		}

		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->getStaffGroups();
		foreach ($results as $result) {
			$data['staff_groups'][] = array(
				'staff_group_id'	=>	$result['staff_group_id'],
				'staff_group_name'	=>	$result['staff_group_name']
			);
		}

		$this->load->model('Locations_model');
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$data['staff_dates'] = array();
		$staff_dates = $this->Staffs_model->getStaffDates();
		foreach ($staff_dates as $staff_date) {
			$month_year = '';
			$month_year = $staff_date['year'].'-'.$staff_date['month'];
			$data['staff_dates'][$month_year] = mdate('%F %Y', strtotime($staff_date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('staffs').$url;
		$config['total_rows'] 		= $this->Staffs_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteStaff() === TRUE) {
			redirect('staffs');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('staffs', $data);
	}

	public function edit() {
		$staff_info = $this->Staffs_model->getStaff((int) $this->input->get('id'));

		if ($staff_info) {
			$staff_id = $staff_info['staff_id'];
			$data['action']	= site_url('staffs/edit?id='. $staff_id);
		} else {
		    $staff_id = 0;
			$data['action']	= site_url('staffs/edit');
		}

		$title = (isset($staff_info['staff_name'])) ? $staff_info['staff_name'] : 'New';
		$this->template->setTitle('Staff: '. $title);
		$this->template->setHeading('Staff: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setBackButton('btn btn-back', site_url('staffs'));

        if ($this->user->hasPermissions('modify', 'staffs', TRUE) AND $staff_id !== $this->user->getStaffId()) {
            $this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        }

        $data['display_staff_group'] = TRUE;
        if ($this->user->hasPermissions('modify', 'staffs', TRUE) AND $staff_id === $this->user->getStaffId()) {
            $data['display_staff_group'] = FALSE;
        }


        $data['staff_name'] 		= $staff_info['staff_name'];
		$data['staff_email'] 		= $staff_info['staff_email'];
		$data['staff_group_id'] 	= $staff_info['staff_group_id'];
		$data['staff_location_id'] 	= $staff_info['staff_location_id'];
		$data['timezone'] 			= $staff_info['timezone'];
		$data['language_id'] 		= $staff_info['language_id'];
		$data['staff_status'] 		= $staff_info['staff_status'];

		$result = $this->Staffs_model->getStaffUser($staff_id);
		$data['username'] 			= $result['username'];
		//$data['staff_group'] 		= $result['staff_group'];

		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->getStaffGroups();
		foreach ($results as $result) {
			$data['staff_groups'][] = array(
				'staff_group_id'	=>	$result['staff_group_id'],
				'staff_group_name'	=>	$result['staff_group_name']
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

		$data['timezones'] = array();
		$timezones = $this->getTimezones();
		foreach ($timezones as $key => $value) {
			$data['timezones'][$key] = $value;
		}

		$this->load->model('Languages_model');
		$data['languages'] = array();
		$results = $this->Languages_model->getLanguages();
		foreach ($results as $result) {
			$data['languages'][] = array(
				'language_id'	=>	$result['language_id'],
				'name'			=>	$result['name'],
			);
		}

		if ($this->input->post() AND !$this->input->get('id') AND $this->_addStaff() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {
				redirect('staffs/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('staffs');
			}
		}

		if ($this->input->post() AND $this->input->get('id') AND $this->_updateStaff($data['staff_email'], $data['username']) === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('staffs');
			}

			redirect('staffs/edit?id='. $staff_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('staffs_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term')) {
			$filter['staff_name'] = $this->input->get('term');
			$filter['staff_id'] = $this->input->get('staff_id');

			$results = $this->Staffs_model->getAutoComplete($filter);
			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 		=> $result['staff_id'],
						'text' 		=> utf8_encode($result['staff_name'])
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => 'No Matches Found');
			}
		}

		$this->output->set_output(json_encode($json));
	}

	public function _addStaff() {
    	if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$add = array();

			$add['staff_name']			= $this->input->post('staff_name');
			$add['staff_email']			= $this->input->post('staff_email');
			$add['username']			= $this->input->post('username');
			$add['password']			= $this->input->post('password');
			$add['staff_group_id']		= $this->input->post('staff_group');
			$add['staff_location_id']	= $this->input->post('staff_location_id');
			$add['timezone']			= $this->input->post('timezone');
			$add['language_id']			= $this->input->post('language_id');
			$add['staff_status']		= $this->input->post('staff_status');

			if ($_POST['insert_id'] = $this->Staffs_model->addStaff($add)) {
				$this->alert->set('success', 'Staff added successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing added.');
			}

			return TRUE;
		}
	}

	public function _updateStaff($staff_email, $username) {
        if (is_numeric($this->input->get('id')) AND $this->validateForm($staff_email, $username) === TRUE) {
			$update = array();

			$update['staff_id']		= $this->input->get('id');
			$update['staff_name']	= $this->input->post('staff_name');

			if ($staff_email !== $this->input->post('staff_email')) {
				$update['staff_email']	= $this->input->post('staff_email');
			} else {
				$update['staff_email']	= $staff_email;
			}

			$update['password']				= $this->input->post('password');
			$update['staff_group_id']		= $this->input->post('staff_group');
			$update['staff_location_id']	= $this->input->post('staff_location_id');
			$update['timezone']				= $this->input->post('timezone');
			$update['language_id']			= $this->input->post('language_id');
			$update['staff_status']			= $this->input->post('staff_status');

			if ($this->Staffs_model->updateStaff($update)) {
				$this->alert->set('success', 'Staff updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

	public function _deleteStaff() {
    	if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Staffs_model->deleteStaff($value);
			}

			$this->alert->set('success', 'Staff(s) deleted successfully!');
		}

		return TRUE;
	}

	public function validateForm($staff_email = FALSE, $username = FALSE) {
		$this->form_validation->set_rules('staff_name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[128]');

		if ($staff_email !== $this->input->post('staff_email')) {
			$this->form_validation->set_rules('staff_email', 'Email', 'xss_clean|trim|required|valid_email|is_unique[staffs.staff_email]|max_length[96]');
		}

		if ($username !== $this->input->post('username')) {
			$this->form_validation->set_rules('username', 'Username', 'xss_clean|trim|required|is_unique[users.username]|min_length[2]|max_length[32]');
		}

		$this->form_validation->set_rules('password', 'Password', 'xss_clean|trim|min_length[6]|max_length[32]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'xss_clean|trim');

		if (!$this->input->get('id')) {
			$this->form_validation->set_rules('password', 'Password', 'xss_clean|trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'xss_clean|trim|required');
		}

		if ($this->user->hasPermissions('modify', 'staffs', FALSE)) {
			$this->form_validation->set_rules('staff_group', 'Department', 'xss_clean|trim|required|integer');
			$this->form_validation->set_rules('staff_location_id', 'Location', 'xss_clean|trim|integer');
		}

		$this->form_validation->set_rules('timezone', 'Timezone', 'xss_clean|trim');
		$this->form_validation->set_rules('language_id', 'Language', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('staff_status', 'Status', 'xss_clean|trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function getTimezones() {
		$timezone_identifiers = DateTimeZone::listIdentifiers();
		$utc_time = new DateTime('now', new DateTimeZone('UTC'));

		$temp_timezones = array();
		foreach ($timezone_identifiers as $timezone_identifier) {
			$current_timezone = new DateTimeZone($timezone_identifier);

			$temp_timezones[] = array(
				'offset' => (int)$current_timezone->getOffset($utc_time),
				'identifier' => $timezone_identifier
			);
		}

		usort($temp_timezones, function($a, $b) {
			return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
		});

		$timezoneList = array();
		foreach ($temp_timezones as $tz) {
			$sign = ($tz['offset'] > 0) ? '+' : '-';
			$offset = gmdate('H:i', abs($tz['offset']));
            $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset .') '. $tz['identifier'];
		}

		return $timezoneList;
	}
}

/* End of file staffs.php */
/* Location: ./admin/controllers/staffs.php */