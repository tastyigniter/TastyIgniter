<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Pages_module extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Pages_model'); 														// load the menus model
		$this->load->library('language');
		$this->lang->load('pages_module/pages_module', $this->language->folder());
	}

	public function index() {
		if ( ! file_exists(EXTPATH .'modules/pages_module/views/main/pages_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if (is_numeric($this->input->get('page_id'))) {
			$data['page_id'] = $this->input->get('page_id'); 	
		} else {
			$data['page_id'] = 0;			
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		// END of retrieving lines from language file to send to view.

		$data['pages'] = array();
		$results = $this->Pages_model->getPages(); 										// retrieve all menu categories from getCategories method in Menus model
		foreach ($results as $result) {															// loop through menu categories array
			$data['pages'][] = array( 														// create array of category data to pass to view
				'page_id'		=>	$result['page_id'],
				'name'			=>	$result['name'],
				'menu_location'	=>	$result['menu_location'],
				'href'			=>	site_url('main/pages?page_id='. $result['page_id'])
			);
		}
		
		// pass array $data and load view files
		$this->load->view('pages_module/main/pages_module', $data);
	}		
}

/* End of file pages_module.php */
/* Location: ./application/extensions/modules/pages_module/controllers/main/pages_module.php */