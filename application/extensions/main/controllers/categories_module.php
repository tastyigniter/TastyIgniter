<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_module extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Menus_model'); 														// load the menus model
	}

	public function index() {
		$this->lang->load('main/categories_module');  														// loads language file
		
		if ( !file_exists(EXTPATH .'main/views/categories_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->input->get('category')) {
			$data['category_id'] = $this->input->get('category'); 	
		} else {
			$data['category_id'] = 0;			
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_categories');
		$data['text_clear'] 			= $this->lang->line('text_clear');

		// END of retrieving lines from language file to send to view.

		$data['categories'] = array();
		$results = $this->Menus_model->getCategories(); 										// retrieve all menu categories from getCategories method in Menus model
		foreach ($results as $result) {															// loop through menu categories array
			$data['categories'][] = array( 														// create array of category data to pass to view
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['category_name'],
				'href'			=>	$this->config->site_url('menus?category=' . $result['category_id'])
			);
		}
		
		// pass array $data and load view files
		$this->load->view('main/categories_module', $data);
	}		
}