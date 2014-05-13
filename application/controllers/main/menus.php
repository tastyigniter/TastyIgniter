<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menus extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Menus_model'); 														// load the menus model
	}

	public function index() {
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
		$this->load->model('Locations_model'); 													// load the locations model

		$this->lang->load('main/menus');  														// loads language file

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$filter = array();
		if ($this->uri->segment(3)) {
			$filter['category_id'] = $this->uri->segment(3); 									// retrieve 3rd uri segment else set FALSE if unavailable.
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
		$data['column_id']				= $this->lang->line('column_id');
		$data['column_photo']	 		= $this->lang->line('column_photo');
		$data['column_menu'] 			= $this->lang->line('column_menu');
		$data['column_price'] 			= $this->lang->line('column_price');
		$data['column_action'] 			= $this->lang->line('column_action');
		// END of retrieving lines from language file to send to view.
				
		$data['quantities'] = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
		
		$this->load->model('Image_tool_model');
		
		$data['show_menu_images'] = $this->config->item('show_menu_images');
		$menu_images_h = (is_numeric($this->config->item('menu_images_h'))) ? $this->config->item('menu_images_h') : '50';
		$menu_images_w = (is_numeric($this->config->item('menu_images_w'))) ? $this->config->item('menu_images_w') : '50';

		$data['menus'] = array();		
		$results = $this->Menus_model->getMainMenus($filter);	 								// retrieve menus array based on category_id if available
		foreach ($results as $result) {															// loop through menus array
			if (!empty($result['menu_photo'])) {
				$menu_photo_src = $this->Image_tool_model->resize($result['menu_photo'], $menu_images_w, $menu_images_h);
			} else {
				$menu_photo_src = $this->Image_tool_model->resize('data/no_photo.png', $menu_images_w, $menu_images_h);
			}
						
			if ($result['is_special'] === '1') {
				$price = $result['special_price'];
				$daydiff = floor((strtotime($result['end_date']) - strtotime($this->location->currentTime())) / 86400 );
				$start_date = $result['start_date'];
				$end_date = mdate('%d %M %y', strtotime($result['end_date']));
				$end_days = ($daydiff < 0) ? sprintf($this->lang->line('text_end_today')) : sprintf($this->lang->line('text_end_days'), $daydiff);
			} else {
				$price = $result['menu_price'];	
				$start_date = '';
				$end_date = '';	
				$end_days = '';					
			}
			
			$data['menus'][] = array( 															// create array of menu data to be sent to view
				'menu_id'			=>	$result['menu_id'],
				'menu_name'			=>	$result['menu_name'],
				'menu_description'	=>	$result['menu_description'],
				'category_name'		=>	$result['category_name'],
				'is_special'		=>	$result['is_special'],
				'start_date'		=>	$start_date,
				'end_date'			=>	$end_date,
				'end_days'			=>	$end_days,
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

		$data['button_right'] = '<a class="button" href='. site_url("main/checkout") .'>'. $this->lang->line('button_continue') .'</a>';

		$regions = array('header', 'content_top', 'content_left', 'content_right', 'footer');
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'menus.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'menus', $regions, $data);
		} else {
			$this->template->render('themes/main/default/', 'menus', $regions, $data);
		}
	}

	public function category() {
		$this->index();
	}
}

/* End of file menus.php */
/* Location: ./application/controllers/main/menus.php */