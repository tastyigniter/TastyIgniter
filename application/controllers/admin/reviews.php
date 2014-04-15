<?php
class Reviews extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Reviews_model'); // load the reviews model
	}

	public function index() {
			
		if (!file_exists(APPPATH .'views/admin/reviews.php')) {
			show_404();
		}
			
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

		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
				
		$data['heading'] 			= 'Reviews';
		$data['sub_menu_add'] 		= 'Add new review';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['text_empty']			= 'There are no reviews available.';

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
				'edit' 				=> $this->config->site_url('admin/reviews/edit?id=' . $review['review_id'])
			);
		}
		
		$config['base_url'] 		= $this->config->site_url('admin/reviews');
		$config['total_rows'] 		= $this->Reviews_model->record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteReview() === TRUE) {

			redirect('admin/reviews');  			
		}	
				
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/reviews', $data);
	}

	public function edit() {

		if (!file_exists(APPPATH .'views/admin/reviews_edit.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/reviews')) {
  			redirect('admin/permission');
		}
		
		//check if /category_id is set in uri string
		if (is_numeric($this->input->get('id'))) {
			$review_id = $this->input->get('id');
			$data['action']	= $this->config->site_url('admin/reviews/edit?id='. $review_id);
		} else {
		    $review_id = $this->input->get('id');
			$data['action']	= $this->config->site_url('admin/reviews/edit');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$review_info = $this->Reviews_model->getReview($review_id);

		$data['heading'] 			= 'Reviews - '. $review_info['location_name'];
		$data['sub_menu_save'] 		= 'Save';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/reviews');
	
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
					
			redirect('admin/reviews');
		}
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/reviews_edit', $data);
	}

	
	public function _addReview() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/reviews')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
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
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
  			return TRUE;
    	
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['review_id'] 	= $this->input->get('id');
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
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
    	
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

		//validate category value
		$this->form_validation->set_rules('order_id', 'Order ID', 'trim|required|integer');
		$this->form_validation->set_rules('location_id', 'Location', 'trim|required|integer');
		$this->form_validation->set_rules('customer_id', 'Customer', 'trim|required|integer');
		$this->form_validation->set_rules('author', 'Author', 'trim|required|min_length[2]|max_length[64]');
		$this->form_validation->set_rules('quality', 'Quality Rating', 'trim|required|integer');
		$this->form_validation->set_rules('delivery', 'Delivery Rating', 'trim|required|integer');
		$this->form_validation->set_rules('service', 'Service Rating', 'trim|required|integer');
		$this->form_validation->set_rules('review_text', 'Rating Text', 'trim|required|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('review_status', 'Rating Status', 'trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
