<?php
class Customers_activity extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Activity_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/customers_activity')) {
  			redirect('admin/permission');
		}
		
		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		} else {
			$filter['limit'] = '';
		}
				
		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $this->input->get('filter_search');
			$data['filter_search'] = $filter['filter_search'];
		} else {
			$filter['filter_search'] = '';
			$data['filter_search'] = '';
		}
		
		if ($this->input->get('filter_type')) {
			$filter['filter_type'] = $this->input->get('filter_type');
			$data['filter_type'] = $filter['filter_type'];
			$url .= 'filter_type='.$filter['filter_type'].'&';
		} else {
			$filter['filter_type'] = '';
			$data['filter_type'] = '';
		}
		
		if ($this->input->get('filter_access')) {
			$filter['filter_access'] = $this->input->get('filter_access');
			$data['filter_access'] = $filter['filter_access'];
			$url .= 'filter_access='.$filter['filter_access'].'&';
		} else {
			$filter['filter_access'] = '';
			$data['filter_access'] = '';
		}
		
		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $this->input->get('filter_date');
			$data['filter_date'] = $filter['filter_date'];
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = '';
			$data['filter_date'] = '';
		}
		
		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $this->input->get('sort_by');
			$data['sort_by'] = $filter['sort_by'];
		} else {
			$filter['sort_by'] = '';
			$data['sort_by'] = '';
		}
		
		if ($this->input->get('order_by')) {
			$filter['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = strtolower($this->input->get('order_by')) .' active';
			$data['order_by'] = strtolower($this->input->get('order_by'));
		} else {
			$filter['order_by'] = '';
			$data['order_by_active'] = '';
			$data['order_by'] = 'desc';
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Activities';
		$data['text_empty'] 		= 'There are no customer activity available.';
		
		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'DESC') ? 'ASC' : 'DESC';
		$data['sort_date'] 			= site_url('admin/customers_activity'.$url.'sort_by=date_added&order_by='.$order_by);

		$activities = $this->Activity_model->getList($filter);
		
		$data['activities'] = array();
		foreach ($activities as $activity) {
			$data['activities'][] = array(
				'ip_address' 		=> $activity['ip_address'],
				'customer_name'		=> ($activity['customer_id']) ? $activity['first_name'] .' '. $activity['last_name'] : 'Guest',
				'access_type'		=> ucwords($activity['access_type']),
				'browser'			=> $activity['browser'],
				'request_uri'		=> (!empty($activity['request_uri'])) ? $activity['request_uri'] : '--',
				'referrer_uri'		=> (!empty($activity['referrer_uri'])) ? $activity['referrer_uri'] : '--',
				'date_added'		=> mdate('%d %M %y - %H:%i', strtotime($activity['date_added'])),
				'blacklist' 		=> site_url('admin/customers_activity/blacklist?ip=' . $activity['ip_address'])
			);
		}
			
		$data['activity_dates'] = array();
		$activity_dates = $this->Activity_model->getActivityDates($filter);
		foreach ($activity_dates as $date) {
			$month_year = '';
			$month_year = mdate('%Y-%m', strtotime($date['year'].'-'.$date['month']));
			$data['activity_dates'][$month_year] = mdate('%F %Y', strtotime($date['date_added']));
		}

		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/customers_activity'. $url);
		$config['total_rows'] 		= $this->Activity_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);
				
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);
			
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'customers_activity.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'customers_activity', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'customers_activity', $regions, $data);
		}
	}
	
	public function blacklist() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/customers_activity')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
    	} else if ($this->input->get('extension')) { 
    		$extension = $this->input->get('extension');
    		$split = explode('_', $extension);
    		
    		//$this->Extensions_model->uninstall($split[1], $split[0]);
			//$this->Settings_model->deleteSettings($split[0]);
			
			$this->session->set_flashdata('alert', '<p class="success">Extension Uninstalled Sucessfully!</p>');				
		}
		
		redirect('admin/customers_activity');
	}	
}

/* End of file customers_activity.php */
/* Location: ./application/controllers/admin/customers_activity.php */