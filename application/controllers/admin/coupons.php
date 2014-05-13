<?php
class Coupons extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Coupons_model');
	}

	public function index() {

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/coupons')) {
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
			$filter['filter_search'] = $this->input->get('filter_search');
			$data['filter_search'] = $filter['filter_search'];
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
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
		
		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $this->input->get('filter_status');
			$data['filter_status'] = $filter['filter_status'];
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = '';
			$data['filter_status'] = '';
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
		
		$data['heading'] 			= 'Coupons';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty'] 		= 'There are no coupons available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'DESC') ? 'ASC' : 'DESC';
		$data['sort_name'] 			= site_url('admin/coupons'.$url.'sort_by=name&order_by='.$order_by);
		$data['sort_code'] 			= site_url('admin/coupons'.$url.'sort_by=code&order_by='.$order_by);
		$data['sort_type'] 			= site_url('admin/coupons'.$url.'sort_by=type&order_by='.$order_by);
		$data['sort_discount'] 		= site_url('admin/coupons'.$url.'sort_by=discount&order_by='.$order_by);

		$data['coupons'] = array();
		$results = $this->Coupons_model->getList($filter);
		foreach ($results as $result) {					
			$data['coupons'][] = array(
				'coupon_id'		=> $result['coupon_id'],
				'name'			=> $result['name'],
				'code'			=> $result['code'],
				'type'			=> ($result['type'] === 'P') ? 'Percentage' : 'Fixed Amount',
				'discount'		=> $result['discount'],
				'min_total'		=> $result['min_total'],
				'description'	=> $result['description'],
				'status'		=> $result['status'],
				'edit' 			=> site_url('admin/coupons/edit?id=' . $result['coupon_id'])
			);
		}

		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/coupons').$url;
		$config['total_rows'] 		= $this->Coupons_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteCoupon() === TRUE) {
			redirect('admin/coupons');  			
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'coupons.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'coupons', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'coupons', $regions, $data);
		}
	}

	public function edit() {

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/coupons')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		//check if /rating_id is set in uri string
		if (is_numeric($this->input->get('id'))) {
			$coupon_id = $this->input->get('id');
			$data['action']	= site_url('admin/coupons/edit?id='. $coupon_id);
		} else {
		    $coupon_id = 0;
			$data['action']	= site_url('admin/coupons/edit');
		}
		
		$result = $this->Coupons_model->getCoupon($coupon_id);
		
		$data['heading'] 			= 'Coupon - '. $result['name'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/coupons');
		$data['text_empty'] 		= 'There is no history available for this coupon.';

		$data['coupon_id'] 			= $result['coupon_id'];
		$data['name'] 				= $result['name'];
		$data['code'] 				= $result['code'];
		$data['type'] 				= $result['type'];
		$data['discount'] 			= $result['discount'];
		$data['min_total'] 			= $result['min_total'];
		$data['redemptions'] 		= $result['redemptions'];
		$data['customer_redemptions'] = $result['customer_redemptions'];
		$data['description'] 		= $result['description'];
		$data['start_date'] 		= (isset($result['start_date']) AND $result['start_date'] !== '0000-00-00') ? mdate('%d-%m-%Y', strtotime($result['start_date'])) : '';
		$data['end_date'] 			= (isset($result['end_date']) AND $result['end_date'] !== '0000-00-00') ? mdate('%d-%m-%Y', strtotime($result['end_date'])) : '';
		$data['date_added'] 		= $result['date_added'];
		$data['status'] 			= $result['status'];

		$data['coupon_histories'] = array();
		$coupon_histories = $this->Coupons_model->getCouponHistories($coupon_id);
		foreach ($coupon_histories as $coupon_history) {
			$data['coupon_histories'][] = array(
				'coupon_history_id'	=> $coupon_history['coupon_history_id'],
				'order_id'			=> $coupon_history['order_id'],
				'customer_name'		=> $coupon_history['first_name'] .' '. $coupon_history['last_name'],
				'code'				=> $coupon_history['code'],
				'amount'			=> $coupon_history['amount'],
				'used'				=> $coupon_history['used'],
				'used_url'			=> site_url('admin/coupons/edit?id='. $coupon_id .'&customer_id='. $coupon_history['customer_id']),
				'date_used'			=> mdate('%d %M %y', strtotime($coupon_history['date_used']))
			);
		}

		if ($this->input->post() && $this->_addCoupon() === TRUE) {
		
			redirect('admin/coupons');  			
		}

		if ($this->input->post() && $this->_updateCoupon() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/coupons');
			}
			
			redirect('admin/coupons/edit?id='. $coupon_id);
		}
				
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'coupons_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'coupons_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'coupons_edit', $regions, $data);
		}
	}

	public function _addCoupon() {
    	if (!$this->user->hasPermissions('modify', 'admin/coupons')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$time_format = '%h:%i';
			$current_date_time = time();
			$add = array();
			
			$add['name'] 			= $this->input->post('name');
			$add['code'] 			= str_replace(' ', '', $this->input->post('code'));
			$add['type'] 			= $this->input->post('type');
			$add['discount'] 		= $this->input->post('discount');
			$add['min_total'] 		= $this->input->post('min_total');
			$add['redemptions'] 	= $this->input->post('redemptions');
			$add['customer_redemptions'] = $this->input->post('customer_redemptions');
			$add['description'] 	= $this->input->post('description');
			$add['start_date'] 		= $this->input->post('start_date');
			$add['end_date'] 		= $this->input->post('end_date');
			$add['date_added'] 		= mdate($time_format, $current_date_time);
			$add['status'] 			= $this->input->post('status');

			if ($this->Coupons_model->addCoupon($add)) {	
				$this->session->set_flashdata('alert', '<p class="success">Coupon Added Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
		
			return TRUE;
		}
	}
	
	public function _updateCoupon() {
    	if (!$this->user->hasPermissions('modify', 'admin/coupons')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['coupon_id'] 		= $this->input->get('id');
			$update['name'] 			= $this->input->post('name');
			$update['code'] 			= str_replace(' ', '', $this->input->post('code'));
			$update['type'] 			= $this->input->post('type');
			$update['discount'] 		= $this->input->post('discount');
			$update['min_total'] 		= $this->input->post('min_total');
			$update['redemptions'] 		= $this->input->post('redemptions');
			$update['customer_redemptions'] = $this->input->post('customer_redemptions');
			$update['description'] 		= $this->input->post('description');
			$update['start_date'] 		= $this->input->post('start_date');
			$update['end_date'] 		= $this->input->post('end_date');
			$update['status'] 			= $this->input->post('status');	

			if ($this->Coupons_model->updateCoupon($update)) {	
				$this->session->set_flashdata('alert', '<p class="success">Coupon Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
		
			return TRUE;
		}		
	}	
	
	public function _deleteCoupon() {
    	if (!$this->user->hasPermissions('modify', 'admin/coupons')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$coupon_id = $value;
					$this->Coupons_model->deleteCoupon($coupon_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Coupon(s) Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('name', 'Coupon Name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('code', 'Coupon Code', 'xss_clean|trim|required|min_length[2]|max_length[15]');
		$this->form_validation->set_rules('type', 'Coupon Type', 'xss_clean|trim|required|exact_length[1]');
		$this->form_validation->set_rules('discount', 'Coupon Discount', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('min_total', 'Minimum Total', 'xss_clean|trim|numeric');
		$this->form_validation->set_rules('redemptions', 'Coupon Redemptions', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('customer_redemptions', 'Coupon Customer Redemptions', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('description', 'Coupon Description', 'xss_clean|trim|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('start_date', 'Start Date', 'xss_clean|trim|valid_date');
		$this->form_validation->set_rules('end_date', 'End Date', 'xss_clean|trim|valid_date');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file coupons.php */
/* Location: ./application/controllers/admin/coupons.php */