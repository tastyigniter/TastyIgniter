<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Specials extends CI_Controller {

	private $error = array();

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Specials_model');
		//$this->load->library('upload');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		//setting upload preference
		$config['upload_path'] = './assets/img/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '300';
		$config['max_width'] = '6024';
		$config['max_height'] = '4468';
		$config['overwrite'] = 'TRUE';
		$config['remove_spaces'] = 'TRUE';

		//loading upload library
		$this->load->library('upload', $config);
	}

	public function index() {
		$this->load->library('currency');

		//check if file exists in views
		if ( !file_exists('application/views/admin/specials.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}
		
		$data['title'] = 'Specials Management';
		$data['text_no_deals'] = 'There are no specials.';
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}
											
		$data['deals'] = array();
		$results = $this->Specials_model->getDeals();
		foreach ($results as $result) {
			
			if ($result['deal_photo']) {
				$deal_photo_src = $this->config->base_url('assets/img/' . $result['deal_photo']);
			} else {
				$deal_photo_src = $this->config->base_url('assets/img/no_deal_photo.png');
			}
													
			$data['deals'][] = array(
				'deal_id'			=>	$result['deal_id'],
				'deal_name'			=>	$result['deal_name'],
				'deal_description'	=>	$result['deal_description'],
				'deal_price'		=>	$this->currency->symbol() . $result['deal_price'],
				'start_date'		=>	$result['start_date'],
				'end_date'			=>	$result['end_date'],
				'deal_photo'		=>	$deal_photo_src,
				'edit' 				=> $this->config->site_url('admin/specials/edit/' . $result['deal_id'])
			);
		}	

		// check if POST add_deal, validate fields and add Deal to model
		if (($this->input->post('submit') === 'Add') && ($this->_addDeal() === TRUE)) {
		
			$this->session->set_flashdata('alert', 'Deal Added Sucessfully!');
			redirect('/admin/specials');
		}

		//check if POST update_deal then remove deal_id
		if (($this->input->post('submit') === 'Delete') && $this->input->post('delete')) {
			
			//sorting the post[remove_deal] array to rowid and qty.
			foreach ($this->input->post('delete') as $key => $value) {
            	$deal_id = $key;
            	
				$this->Specials_model->deleteDeal($deal_id);
			}			
			
			$this->session->set_flashdata('alert', 'Deal(s) Deleted Sucessfully!');

			redirect('admin/specials');  			
		}	

		$this->load->view('admin/header', $data);
		$this->load->view('admin/specials', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {
		//check if file exists in views
		if ( !file_exists('application/views/admin/specials_edit.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

		//check if /food_id is set in uri string
		if (is_numeric($this->uri->segment(4))) {
			$deal_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/specials');
		}

		$data['title'] = 'Specials Management';
		$data['action'] = $this->config->site_url('admin/specials/edit/' . $deal_id);

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		

		$deal_info = $this->Specials_model->getDeal($deal_id);
		$data['deal_id']			=	$deal_info['deal_id'];
		$data['deal_name']			=	$deal_info['deal_name'];
		$data['deal_description']	=	$deal_info['deal_description'];
		$data['deal_price']			=	$deal_info['deal_price'];
		$data['start_date']			=	$deal_info['start_date'];
		$data['end_date']			=	$deal_info['end_date'];

		// check if POST add_food, validate fields and add Food to model
		if (($this->input->post('submit') === 'Update') && ( ! $this->input->post('delete')) && ($this->_updateDeal($deal_id) === TRUE)) {
		
			$this->session->set_flashdata('alert', 'Deal Updated Sucessfully!');
				
			redirect('admin/specials');
		}
		
						
		//Remove Food
		if ($this->input->post('delete')) {
					
			$this->Specials_model->deleteDeal($deal_id);
					
			$this->session->set_flashdata('alert', 'Deal Removed Sucessfully!');

			redirect('admin/specials');
		}
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/specials_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addDeal() {
									
		//form validation
		$this->form_validation->set_rules('deal_name', 'Deal Name', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('deal_description', 'Deal Description', 'trim|required|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('deal_price', 'Deal Price', 'trim|required|numeric');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|callback_handle_date');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required|callback_handle_date');
		$this->form_validation->set_rules('deal_photo', 'Deal Photo', 'callback_handle_upload');

		//if validation is true
  		if ($this->form_validation->run() === TRUE) {

	     	$this->load->helper('date');
 			$date_time_format = "%Y-%m-%d %h:%i:%s";
  		    	 		    	
 		    //Sanitizing the POST values
			$deal_name 			= $this->input->post('deal_name');
			$deal_description 	= $this->input->post('deal_description');
			$deal_price 		= $this->input->post('deal_price');
			$start_date 		= $this->input->post('start_date');
			$end_date 			= $this->input->post('end_date');
			$deal_photo 		= $this->input->post('deal_photo');			
				
			$this->Specials_model->addDeal($deal_name, $deal_description, $deal_price, $start_date, $end_date, $deal_photo);
			return TRUE;
		}	
	}
	
	public function _updateDeal($deal_id) {
						
		$this->form_validation->set_rules('deal_name', 'Deal Name', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('deal_description', 'Deal Description', 'trim|required|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('deal_price', 'Deal Price', 'trim|required|numeric');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|callback_handle_date');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required|callback_handle_date');
		$this->form_validation->set_rules('deal_photo', 'Deal Photo', 'callback_handle_upload');

	  	if ($this->form_validation->run() === TRUE) {
				
	     	$this->load->helper('date');
 			$date_time_format = "%Y-%m-%d %h:%i:%s";
  		    	 		    	
 		    //Sanitizing the POST values
			$deal_name 			= $this->input->post('deal_name');
			$deal_description 	= $this->input->post('deal_description');
			$deal_price 		= $this->input->post('deal_price');
			$start_date 		= $this->input->post('start_date');
			$end_date 			= $this->input->post('end_date');
			$deal_photo 		= $this->input->post('deal_photo');			
					
			$this->Specials_model->updateDeal($deal_id, $deal_name, $deal_description, $deal_price, $start_date, $end_date, $deal_photo);
			
			return TRUE;
		}
	}

 	public function handle_upload() {
		if (isset($_FILES['deal_photo']) && !empty($_FILES['deal_photo']['name'])) {
      		
      		if ($this->upload->do_upload('deal_photo')) {

        		// set a $_POST value for 'food_photo' that we can use later
        		$upload_data    = $this->upload->data();
        		if ($upload_data) {
        			$_POST['deal_photo'] = $upload_data['file_name'];
        		}
        		return TRUE;        
      		} else {
        		
        		// possibly do some clean up ... then throw an error
        		$this->form_validation->set_message('handle_upload', $this->upload->display_errors());
        		return FALSE;
     		}
    	} else {
      	
        	$this->form_validation->set_message('handle_upload', 'The %s field is required.');
        	// set an empty $_POST value for 'food_photo' to be used on database queries
        	$_POST['deal_photo'] = '';
      		return TRUE;
      	}
    }

 	public function handle_date($date) {
      		
     	$this->load->helper('date');
     	$human_to_unix = human_to_unix($date);
		if ( ! isset($human_to_unix)) {
        	$this->form_validation->set_message('handle_date', 'The %s field is not a valid date/time.');
      		return FALSE;
    	} else {
        	return TRUE;        
      	}
    }
}