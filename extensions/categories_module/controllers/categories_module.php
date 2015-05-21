<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Categories_module extends Ext_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Menus_model'); 														// load the menus model
		$this->load->model('Categories_model'); 														// load the menus model
		$this->lang->load('categories_module/categories_module');
	}

	public function index() {
		if ( ! file_exists(EXTPATH .'categories_module/views/categories_module.php')) { 		//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if (is_numeric($this->input->get('category_id'))) {
			$data['category_id'] = $this->input->get('category_id');
		} else {
			$data['category_id'] = 0;
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_categories');
		$data['text_clear'] 			= $this->lang->line('text_clear');
		$data['menu_total'] 			= $this->Menus_model->getCount();

		// END of retrieving lines from language file to send to view.

		$data['categories'] = array();
		$results = $this->Categories_model->getCategories(); 										// retrieve all menu categories from getCategories method in Menus model
		foreach ($results as $result) {															// loop through menu categories array
			$data['categories'][] = array( 														// create array of category data to pass to view
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['name'],
				'href'			=>	site_url('menus?category_id='. $result['category_id'])
			);
		}

		// pass array $data and load view files
		return $this->load->view('categories_module/categories_module', $data, TRUE);
	}
}

/* End of file categories_module.php */
/* Location: ./extensions/categories_module/controllers/categories_module.php */