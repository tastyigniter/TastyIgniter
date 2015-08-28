<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Newsletter extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Menus_model'); 														// load the menus model
		$this->load->model('Categories_model'); 														// load the menus model
		$this->lang->load('newsletter/newsletter');
	}

	public function index() {
		if ( ! file_exists(EXTPATH .'newsletter/views/newsletter.php')) { 		//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

//		if (is_numeric($this->input->get('category_id'))) {
//			$data['category_id'] = $this->input->get('category_id');
//		} else {
//			$data['category_id'] = 0;
//		}
//
//		$data['menu_total'] 			= $this->Menus_model->getCount();
//
//		$data['categories'] = array();
//		$results = $this->Categories_model->getCategories(); 										// retrieve all menu categories from getCategories method in Menus model
//        foreach (sort_array($results) as $result) {															// loop through menu categories array
//			$data['categories'][] = array( 														// create array of category data to pass to view
//				'category_id'	=>	$result['category_id'],
//				'category_name'	=>	$result['name'],
//				'href'			=>	site_url('menus?category_id='. $result['category_id'])
//			);
//		}

		// pass array $data and load view files
		return $this->load->view('newsletter/newsletter', array(), TRUE);
	}
}

/* End of file newsletter.php */
/* Location: ./extensions/newsletter/controllers/newsletter.php */