<?php
class Staffs extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Staffs_model');
		$this->load->model('Locations_model'); // load the locations model
		$this->load->model('Staff_groups_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/staffs')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

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
		
    	if ($this->user->staffLocationAccess()) {
  			$filter['filter_location'] = $this->user->getLocationId();
		} else if (is_numeric($this->input->get('filter_location'))) {
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
		$this->template->setButton('+ New', array('class' => 'add_button', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'delete_button', 'onclick' => '$(\'form:not(#filter-form)\').submit();'));

		$data['text_empty'] 		= 'There are no staffs available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('admin/staffs'.$url.'sort_by=staff_name&order_by='.$order_by);
		$data['sort_group']			= site_url('admin/staffs'.$url.'sort_by=staff_group_name&order_by='.$order_by);
		$data['sort_location'] 		= site_url('admin/staffs'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_date'] 			= site_url('admin/staffs'.$url.'sort_by=date_added&order_by='.$order_by);
		$data['sort_id'] 			= site_url('admin/staffs'.$url.'sort_by=staff_id&order_by='.$order_by);
		
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
				'edit' 					=> site_url('admin/staffs/edit?id=' . $result['staff_id'])
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
		
		$config['base_url'] 		= site_url('admin/staffs').$url;
		$config['total_rows'] 		= $this->Staffs_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteStaff() === TRUE) {
			redirect('admin/staffs');  			
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'staffs.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'staffs', $data);
		} else {
			$this->template->render('themes/admin/default/', 'staffs', $data);
		}
	}

	public function edit() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if ($this->input->get('id') !== $this->user->getStaffId() AND !$this->user->hasPermissions('access', 'admin/staffs')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if (is_numeric($this->input->get('id'))) {
			$staff_id = $this->input->get('id');
			$data['action']	= site_url('admin/staffs/edit?id='. $staff_id);
		} else {
		    $staff_id = 0;
			$data['action']	= site_url('admin/staffs/edit');
		}

		$staff_info = $this->Staffs_model->getStaff($staff_id);
		
		$title = (isset($staff_info['staff_name'])) ? 'Edit - '. $staff_info['staff_name'] : 'New';	
		$this->template->setTitle('Staff: '. $title);
		$this->template->setHeading('Staff: '. $title);
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		$this->template->setBackButton('back_button', site_url('admin/staffs'));

    	$data['staff_profile'] = FALSE;
    	if ($this->input->get('id') === $this->user->getStaffId() AND !$this->user->hasPermissions('modify', 'admin/staffs')) {
			$data['staff_profile'] = TRUE;
		} else {
			$this->template->setButton('Save & Close', array('class' => 'save_close_button', 'onclick' => 'saveClose();'));
		}
		
		$data['staff_name'] 		= $staff_info['staff_name'];
		$data['staff_email'] 		= $staff_info['staff_email'];
		$data['staff_group_id'] 	= $staff_info['staff_group_id'];
		$data['staff_location_id'] 	= $staff_info['staff_location_id'];
		$data['staff_status'] 		= $staff_info['staff_status'];
		
		$data['timezone'] 			= '';
		$data['language_id'] 		= '';

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
	
		if ($this->input->post() AND $this->_addStaff() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {	
				redirect('admin/staffs/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('admin/staffs');
			}
		}

		if ($this->input->post() AND $this->_updateStaff($data['staff_email'], $data['username']) === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/staffs');
			}
			
			redirect('admin/staffs/edit?id='. $staff_id);
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'staffs_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'staffs_edit', $data);
		} else {
			$this->template->render('themes/admin/default/', 'staffs_edit', $data);
		}
	}

	public function autocomplete() {
		$json = array();
		
		if ($this->input->get('staff_name')) {
			$filter = array(
				'staff_name' => urldecode($this->input->get('staff_name'))
			);

			$results = $this->Staffs_model->getAutoComplete($filter);
		
			if ($results) {
				foreach ($results as $result) {
					$json[] = array(
						'staff_id' 		=> $result['staff_id'],
						'staff_name' 	=> $result['staff_name']
					);
				}
			}
		}
		
		$this->output->set_output(json_encode($json));
	}
	
	public function _addStaff() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/staffs')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if (! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();

			$add['staff_name']			= $this->input->post('staff_name');
			$add['staff_email']			= $this->input->post('staff_email');
			$add['username']			= $this->input->post('username');
			$add['password']			= $this->input->post('password');
			$add['staff_group_id']		= $this->input->post('staff_group');
			$add['staff_location_id']	= $this->input->post('staff_location_id');
			$add['staff_status']		= $this->input->post('staff_status');
			
			if ($_POST['insert_id'] = $this->Staffs_model->addStaff($add)) {
				$this->session->set_flashdata('alert', '<p class="success">Staff added sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}
	}
	
	public function _updateStaff($staff_email, $username) {
    	if ($this->input->get('id') !== $this->user->getStaffId() AND !$this->user->hasPermissions('modify', 'admin/staffs')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm($staff_email, $username) === TRUE) { 
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
			$update['staff_status']			= $this->input->post('staff_status');
			
			if ($this->Staffs_model->updateStaff($update)) {
				$this->session->set_flashdata('alert', '<p class="success">Staff updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}
	}

	public function _deleteStaff() {
    	if (!$this->user->hasPermissions('modify', 'admin/staffs')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Staffs_model->deleteStaff($value);
			}			
		
			$this->session->set_flashdata('alert', '<p class="success">Staff(s) deleted sucessfully!</p>');
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
		$this->form_validation->set_rules('staff_group', 'Department', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('staff_location_id', 'Location', 'xss_clean|trim|integer');
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
			$timezone_list[$tz['identifier']] = '(UTC ' . $sign . $offset .') '. $tz['identifier'];
		}
 
		return $timezone_list;
	}
}

/* End of file staffs.php */
/* Location: ./application/controllers/admin/staffs.php */