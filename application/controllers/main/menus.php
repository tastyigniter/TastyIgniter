<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menus extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Menus_model'); 														// load the menus model
		$this->load->model('Specials_model'); 													// load the reviews model
	}

	public function index() {
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
		$this->load->model('Locations_model'); 													// load the locations model
		$this->load->model('Reviews_model'); 													// load the reviews model

		$this->lang->load('main/menus');  														// loads language file

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$filter = array();
		if ($this->uri->segment(2) === 'category') {
			$filter['category_id'] = $this->uri->segment(3, FALSE); 									// retrieve 3rd uri segment else set FALSE if unavailable.
			$data['category_id'] = $filter['category_id'];	
		} else {
			$data['category_id'] = 0;			
		}

		if ($this->uri->segment(2) === 'specials') {
			$filter['special'] = 1; 									// retrieve 3rd uri segment else set FALSE if unavailable.
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['text_category'] 			= $this->lang->line('text_category');
		$data['text_specials'] 			= $this->lang->line('text_specials');
		$data['text_filter'] 			= $this->lang->line('text_filter');
		$data['text_reviews'] 			= $this->lang->line('text_reviews');
		$data['button_checkout'] 		= $this->lang->line('button_checkout');
		$data['button_add'] 			= $this->lang->line('button_add');
		$data['button_review'] 			= $this->lang->line('button_review');
		$data['column_id']				= $this->lang->line('column_id');
		$data['column_photo']	 		= $this->lang->line('column_photo');
		$data['column_menu'] 			= $this->lang->line('column_menu');
		$data['column_price'] 			= $this->lang->line('column_price');
		$data['column_action'] 			= $this->lang->line('column_action');
		// END of retrieving lines from language file to send to view.
				
		$data['quantities'] = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
		
		$data['menu_reviews'] = $this->Reviews_model->getTotalReviews(); 						// retrieve total reviews of each menus.

		$data['menus'] = array();		
		$data['specials'] = array();		
		$results = $this->Menus_model->getMainMenus($filter);	 								// retrieve menus array based on category_id if available
		foreach ($results as $result) {															// loop through menus array
		
			if (!empty($result['menu_photo'])) {
				$menu_photo_src = $this->config->base_url('assets/img/' . $result['menu_photo']);	// create menu photo full path based on config base_url
			} else {
				$menu_photo_src = $this->config->base_url('assets/img/no_menu_photo.png');		// create no photo full path based on config base_url
			}
			
			if ($result['is_special'] === '1') {

				$price = $result['special_price'];
				$daydiff = floor((strtotime($result['end_date']) - strtotime($this->location->currentTime())) / 86400 );
			
				$data['specials'][] = array( 														// create array of menu data to be sent to view
					'menu_id'		=> $result['menu_id'],
					'start_date'	=> $result['start_date'],
					'end_date'		=> $result['end_date'],
					'end_days'		=> ($daydiff < 0) ? sprintf($this->lang->line('text_end_today')) : sprintf($this->lang->line('text_end_days'), $daydiff)
				);
			
			} else {
				$price = $result['menu_price'];							
			}
			
			$data['menus'][] = array( 															// create array of menu data to be sent to view
				'menu_id'			=>	$result['menu_id'],
				'menu_name'			=>	$result['menu_name'],
				'menu_description'	=>	$result['menu_description'],
				'category_name'		=>	$result['category_name'],
				'is_special'		=>	$result['is_special'],
				'menu_price'		=>	$this->currency->format($price), 		//add currency symbol and format price to two decimal places
				'menu_photo'		=>	$menu_photo_src
			);
		}	

		$data['has_options'] = $this->Menus_model->hasMenuOptions(); 							// retrieve array of menu options id of available menus from hasMenuOptions method in Menus model
		
		$data['menu_options'] = array();
		$results = $this->Menus_model->getMenuOptions(); 										// retrieve menu options array from getMenuOptions method in Menus model
		foreach ($results as $result) {															// loop through menu options array
			$data['menu_options'][] = array( 													// create array of menu options data to pass to view
				'option_id' 	=> $result['option_id'],
				'option_name' 	=> $result['option_name'],
				'option_price' 	=> $this->currency->format($result['option_price']) 			// add currency symbol and format price to two decimal places
			);
		}

		$data['button_right'] 		= '<a class="button" href='. $this->config->site_url("checkout") .'>'. $this->lang->line('button_continue') .'</a>';

		$regions = array(
			'main/header',
			'main/content_left',
			'main/content_right',
			'main/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('main/menus', $data);
	}

	public function review() {
		$this->load->library('location'); 														// load the location library
		$this->load->model('Reviews_model'); 													// load the reviews model
		$this->lang->load('main/menus');  														// loads language file

		$json = array();
		
		if (!$json && $this->input->is_ajax_request()) {

			$customer_id = $this->customer->getId();											// retriveve customer id from customer library
			$customer_name = $this->customer->getFirstName() .' '. $this->customer->getLastName();	// retrieve customer's first and last name from customer library
			$menu_id = (int)$this->input->post('menu_id');										// check if $_POST menu_id value is set and store in variable
			$rating_id = (int)$this->input->post('rating_id');									// check if $_POST rating_id value is set and store in variable
			$review_text = $this->input->post('review_text');									// check if $_POST review_text value is set and store in variable
								
			$date_added = $this->location->currentDate();										// retrieve current date from location library

			if ( ! $this->customer->islogged()) {  
				
				$json['error'] = $this->lang->line('text_pls_login');
				
			} else if ( ! $this->input->post('review_text')) {

				$json['error'] = $this->lang->line('text_pls_write');
							
				
			} else if ($this->Reviews_model->reviewMenu($customer_id, $customer_name, $menu_id, $rating_id, $review_text, $date_added)) {
				
				$json['success'] = $this->lang->line('text_rate_success');
				
			} else {
				
				$json['error'] = $this->lang->line('text_error');
			
			}
		}

		$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
	}	

	public function write_review() {
		$this->lang->load('main/menus');  														// loads language file
	
		if ( !file_exists(APPPATH .'/views/main/write_review.php')) { 						//check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_review_heading');
		$data['text_write_review'] 		= $this->lang->line('text_write_review');
		$data['entry_menu_name'] 		= $this->lang->line('entry_menu_name');
		$data['entry_customer_name'] 	= $this->lang->line('entry_customer_name');
		$data['entry_rating'] 			= $this->lang->line('entry_rating');
		$data['entry_rating_text'] 		= $this->lang->line('entry_rating_text');
		$data['button_add_review'] 		= $this->lang->line('button_add_review');
		// END of retrieving lines from language file to send to view.

		if ($this->customer->islogged()) {														// if customer is not logged in
			$data['customer_id'] = $this->customer->getId();									// retriveve customer id from customer library
			$data['customer_name'] = $this->customer->getFirstName() .' '. $this->customer->getLastName(); // retrieve and concatenate customer's first and last name from customer library
		} else {																				// else display error
			$data['error'] = $this->lang->line('text_pls_login');
		}

		if ($this->input->get('menu_id')) {														// check if $_GET menu_id value is set
			$data['menu_id'] = $this->input->get('menu_id');									// retrieve the $_GET menu_id value
		} else {																				// else display error
			$data['error'] = $this->lang->line('text_no_menu_selected');
		}
				
		$this->load->model('Cart_model'); // load the menus model
		$menu_data = $this->Cart_model->getMenu($data['menu_id']);							// get menu data from getCartItem method in Menus model based on menu_id
		
		if ($menu_data) {																		// check if menu data exists
			$data['menu_name'] = $menu_data['menu_name'];										// retrieve menu name from menu data array
		} else {																				// else display error
			$data['error'] = $this->lang->line('text_no_menu_selected');
		}
		
		//create array of ratings data to pass to view
		$data['ratings'] = $this->config->item('ratings');
		
		//load view files and pass $data array
		$this->load->view('main/write_review', $data);
	}
}