<?php
class Reviews extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Reviews_model'); // load the reviews model
	}

	public function index() {
						
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/reviews')) {
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
		
		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $this->input->get('filter_date');
			$data['filter_date'] = $filter['filter_date'];
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = '';
			$data['filter_date'] = '';
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
		
		$data['heading'] 			= 'Reviews';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty']			= 'There are no reviews available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'DESC') ? 'ASC' : 'DESC';
		$data['sort_location'] 		= site_url('admin/reviews'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_author'] 		= site_url('admin/reviews'.$url.'sort_by=author&order_by='.$order_by);
		$data['sort_id'] 			= site_url('admin/reviews'.$url.'sort_by=order_id&order_by='.$order_by);
		$data['sort_status']		= site_url('admin/reviews'.$url.'sort_by=review_status&order_by='.$order_by);
		$data['sort_date'] 			= site_url('admin/reviews'.$url.'sort_by=date_added&order_by='.$order_by);
		
		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings;

		$reviews = array();				
		$reviews = $this->Reviews_model->getList($filter);
		$data['reviews'] = array();
		foreach ($reviews as $review) {
			$data['reviews'][] = array(
				'review_id' 		=> $review['review_id'],
				'location_name' 	=> $review['location_name'],
				'author' 			=> $review['author'],
				'quality' 			=> $review['quality'],
				'delivery' 			=> $review['delivery'],
				'service' 			=> $review['service'],
				'order_id' 			=> $review['order_id'],
				'date_added' 		=> mdate('%d %M %y', strtotime($review['date_added'])),
				'review_status' 	=> $review['review_status'],
				'edit' 				=> site_url('admin/reviews/edit?id=' . $review['review_id'])
			);
		}
		
		$data['review_dates'] = array();
		$review_dates = $this->Reviews_model->getReviewDates();
		foreach ($review_dates as $review_date) {
			$month_year = '';
			$month_year = $review_date['year'].'-'.$review_date['month'];
			$data['review_dates'][$month_year] = mdate('%F %Y', strtotime($review_date['date_added']));
		}

		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/reviews').$url;
		$config['total_rows'] 		= $this->Reviews_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteReview() === TRUE) {

			redirect('admin/reviews');  			
		}	
				
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'reviews.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'reviews', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'reviews', $regions, $data);
		}
	}

	public function edit() {

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/reviews')) {
  			redirect('admin/permission');
		}
		
		//check if /category_id is set in uri string
		if (is_numeric($this->input->get('id'))) {
			$review_id = $this->input->get('id');
			$data['action']	= site_url('admin/reviews/edit?id='. $review_id);
		} else {
		    $review_id = $this->input->get('id');
			$data['action']	= site_url('admin/reviews/edit');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$review_info = $this->Reviews_model->getReview($review_id);

		$data['heading'] 			= 'Reviews - '. $review_info['location_name'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/reviews');
	
		$data['review_id'] 			= $review_info['review_id'];
		$data['location_id'] 		= $review_info['location_id'];
		$data['order_id'] 			= $review_info['order_id'];
		$data['customer_id'] 		= $review_info['customer_id'];
		$data['author'] 			= $review_info['author'];
		$data['quality'] 			= $review_info['quality'];
		$data['delivery'] 			= $review_info['delivery'];
		$data['service'] 			= $review_info['service'];
		$data['review_text'] 		= $review_info['review_text'];
		$data['date_added'] 		= $review_info['date_added'];
		$data['review_status'] 		= $review_info['review_status'];

		//load ratings data into array
		$data['ratings'] = $this->config->item('ratings');

		$this->load->model('Locations_model');
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}
	
		if ($this->input->post() && $this->_addReview() === TRUE) {
			redirect('admin/reviews');
		}

		if ($this->input->post() && $this->_updateReview() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/reviews');
			}
			
			redirect('admin/reviews/edit?id='. $review_id);
		}
		
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'reviews_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'reviews_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'reviews_edit', $regions, $data);
		}
	}
	
	public function _addReview() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/reviews')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add or change!</p>');
  			return TRUE;
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['order_id'] 			= $this->input->post('order_id');
			$add['location_id'] 		= $this->input->post('location_id');
			$add['customer_id'] 		= $this->input->post('customer_id');
			$add['author'] 				= $this->input->post('author');
			$add['quality'] 			= $this->input->post('quality');
			$add['delivery'] 			= $this->input->post('delivery');
			$add['service'] 			= $this->input->post('service');
			$add['review_text'] 		= $this->input->post('review_text');
			$add['review_status'] 		= $this->input->post('review_status');

			if ($this->Reviews_model->addReview($add)) {	
				$this->session->set_flashdata('alert', '<p class="success">Review Added Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Addr!</p>');
			}
			
			return TRUE;
		}
	}	

	public function _updateReview() {
    	if (!$this->user->hasPermissions('modify', 'admin/reviews')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['review_id'] 		= $this->input->get('id');
			$update['order_id'] 		= $this->input->post('order_id');
			$update['location_id'] 		= $this->input->post('location_id');
			$update['customer_id'] 		= $this->input->post('customer_id');
			$update['author'] 			= $this->input->post('author');
			$update['quality'] 			= $this->input->post('quality');
			$update['delivery'] 		= $this->input->post('delivery');
			$update['service'] 			= $this->input->post('service');
			$update['review_text'] 		= $this->input->post('review_text');
			$update['review_status'] 	= $this->input->post('review_status');

			if ($this->Reviews_model->updateReview($update)) {	
				$this->session->set_flashdata('alert', '<p class="success">Review Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
			}
			
			return TRUE;
		}
	}	

	public function _deleteReview($review_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/reviews')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$review_id = $value;
					$this->Reviews_model->deleteReview($review_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Review(s) Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}
	
	public function validateForm() {
		$this->form_validation->set_rules('order_id', 'Order ID', 'xss_clean|trim|required|integer|callback_check_order');
		$this->form_validation->set_rules('location_id', 'Location', 'xss_clean|trim|required|integer|callback_check_location');
		$this->form_validation->set_rules('customer_id', 'Customer', 'xss_clean|trim|required|integer|callback_check_customer');
		$this->form_validation->set_rules('author', 'Author', 'xss_clean|trim|required|min_length[2]|max_length[64]');
		$this->form_validation->set_rules('quality', 'Quality Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('delivery', 'Delivery Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('service', 'Service Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('review_text', 'Rating Text', 'xss_clean|trim|required|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('review_status', 'Rating Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function check_order($order_id) {
		$this->load->model('Orders_model');
		if ( ! $this->Orders_model->validateOrder($order_id)) {
        	$this->form_validation->set_message('check_order', 'The %s entered can not be found');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function check_location($location_id) {
		$this->load->model('Locations_model');
		if ( ! $this->Locations_model->validateLocation($location_id)) {
        	$this->form_validation->set_message('check_location', 'The %s entered can not be found');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function check_customer($customer_id) {
		$this->load->model('Customers_model');
		if ( ! $this->Customers_model->validateCustomer($customer_id)) {
        	$this->form_validation->set_message('check_customer', 'The %s entered can not be found');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
}

/* End of file reviews.php */
/* Location: ./application/controllers/admin/reviews.php */