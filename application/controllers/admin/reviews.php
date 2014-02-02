<?php
class Reviews extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Reviews_model'); // load the reviews model
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		if ( !file_exists(APPPATH .'/views/admin/reviews.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
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
		
		if ($this->config->item('config_page_limit')) {
			$filter['limit'] = $this->config->item('config_page_limit');
		}
				
		$data['heading'] 			= 'Reviews';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Add new review</a></li>';

		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings;

		$reviews = array();				
		$reviews = $this->Reviews_model->getList($filter);
		foreach ($reviews as $review) {
			
			if (isset($ratings[$review['rating_id']])) {
				$rating_name = $ratings[$review['rating_id']];
			}
			
			$data['reviews'][] = array(
				'review_id' 		=> $review['review_id'],
				'author' 			=> $review['author'],
				'menu_name' 		=> $review['menu_name'],
				'rating_name' 		=> $rating_name,
				'date_added' 		=> mdate('%d-%m-%Y', strtotime($review['date_added'])),
				'review_status' 	=> $review['review_status'],
				'edit' 				=> $this->config->site_url('admin/reviews/edit/' . $review['review_id'])
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

		if ($this->input->post() && $this->_addReview() === TRUE) {
			
			redirect('admin/reviews');
		}

		if ($this->input->post('delete') && $this->_deleteReview() === TRUE) {

			redirect('admin/reviews');  			
		}	
				
		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/reviews', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {

		if ( !file_exists(APPPATH .'/views/admin/reviews_edit.php')) { //check if file exists in views folder
			// Whoops, show 404 error page!
			show_404();
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/reviews')) {
  			redirect('admin/permission');
		}
		
		//check if /category_id is set in uri string
		if (is_numeric($this->uri->segment(4))) {
			$review_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/reviews');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$review_info = $this->Reviews_model->getReview($review_id);

		if ($review_info) {
			$data['heading'] 			= 'Reviews';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/reviews');
		
			$data['review_id'] 		= $review_info['review_id'];
			$data['customer_id'] 	= $review_info['customer_id'];
			$data['author'] 		= $review_info['author'];
			$data['menu_id'] 		= $review_info['menu_id'];
			$data['menu_name'] 		= $review_info['menu_name'];
			$data['rating_id'] 		= $review_info['rating_id'];
			$data['review_text'] 	= $review_info['review_text'];
			$data['date_added'] 	= $review_info['date_added'];
			$data['review_status'] 	= $review_info['review_status'];

			//load ratings data into array
			$data['ratings'] = $this->config->item('ratings');

			if ($this->input->post() && $this->_updateReview($review_id) === TRUE) {
						
				redirect('admin/reviews');
			}
						
			//Remove Menu
			if ($this->input->post('delete') && $this->_deleteReview($review_id) === TRUE) {
					
				redirect('admin/reviews');
			}
		}
		
		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/reviews_edit', $data);
		$this->load->view('admin/footer');
	}

	
	public function _addReview() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/reviews')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
			$date_format = '%Y-%m-%d';															// retrieve date format from config
			$current_date_time = time();														// retrieve current timestamp

			//validate category value
			$this->form_validation->set_rules('author', 'Author', 'trim|required|min_length[2]|max_length[64]');
			$this->form_validation->set_rules('customer_id', 'Customer ID', 'trim|required|integer');
			$this->form_validation->set_rules('menu', 'Menu Name', 'trim|required');
			$this->form_validation->set_rules('menu_id', 'Menu ID', 'trim|required|integer');
			$this->form_validation->set_rules('rating', 'Rating Name', 'trim|required|integer');
			$this->form_validation->set_rules('review_text', 'Rating Text', 'trim|required|min_length[2]|max_length[1028]');
			$this->form_validation->set_rules('review_status', 'Rating Status', 'trim|required|integer');

			if ($this->form_validation->run() === TRUE) {
				$add = array();
				
				$add['author'] 			= $this->input->post('author');
				$add['customer_id'] 	= $this->input->post('customer_id');
				$add['menu_id'] 		= $this->input->post('menu_id');
				$add['rating_id'] 		= $this->input->post('rating');
				$add['review_text'] 	= $this->input->post('review_text');
				$add['review_status'] 	= $this->input->post('review_status');
				$add['date_added'] 		= mdate($date_format, $current_date_time);

	
				if ($this->Reviews_model->addReview($add)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Review Added Sucessfully!</p>');
				
				} else {

					$this->session->set_flashdata('alert', '<p class="warning">Nothing Addr!</p>');

				}
				
				return TRUE;
			}
		}
	}	

	public function _updateReview($review_id) {
									
    	if (!$this->user->hasPermissions('modify', 'admin/reviews')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 

			//validate category value
			$this->form_validation->set_rules('author', 'Author', 'trim|required|min_length[2]|max_length[64]');
			$this->form_validation->set_rules('customer_id', 'Customer ID', 'trim|required|integer');
			$this->form_validation->set_rules('menu', 'Menu Name', 'trim|required');
			$this->form_validation->set_rules('menu_id', 'Menu ID', 'trim|required|integer');
			$this->form_validation->set_rules('rating', 'Rating Name', 'trim|required|integer');
			$this->form_validation->set_rules('review_text', 'Rating Text', 'trim|required|min_length[2]|max_length[1028]');
			$this->form_validation->set_rules('review_status', 'Rating Status', 'trim|required|integer');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
				
				$update['review_id'] 	= $review_id;
				$update['author'] 		= $this->input->post('author');
				$update['customer_id'] 	= $this->input->post('customer_id');
				$update['menu_id'] 		= $this->input->post('menu_id');
				$update['rating_id'] 	= $this->input->post('rating');
				$update['review_text'] 	= $this->input->post('review_text');
				$update['review_status'] = $this->input->post('review_status');
	
				if ($this->Reviews_model->updateReview($update)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Review Updated Sucessfully!</p>');
				
				} else {

					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');

				}
				
				return TRUE;
			}
		}
	}	

	public function _deleteReview($review_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/reviews')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$review_id = $value;
				
					$this->Reviews_model->deleteReview($review_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Review(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}
