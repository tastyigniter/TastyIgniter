<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Menus extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Menus_model'); 														// load the menus model
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
		$this->load->model('Locations_model'); 													// load the locations model
		$this->load->library('language');
		$this->lang->load('main/menus', $this->language->folder());
	}

	public function index() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
		
		$filter['category_id'] = $data['category_id'] = (int) $this->input->get('category_id'); 									// retrieve 3rd uri segment else set FALSE if unavailable.
		$categories = $this->Menus_model->getCategory($data['category_id']);
		
		if (!$categories AND $this->input->get('category_id')) {
			show_404();
		}

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['text_category'] 			= $this->lang->line('text_category');
		$data['text_specials'] 			= $this->lang->line('text_specials');
		$data['text_filter'] 			= $this->lang->line('text_filter');
		$data['text_reviews'] 			= $this->lang->line('text_reviews');
		$data['button_add'] 			= $this->lang->line('button_add');
		$data['column_id']				= $this->lang->line('column_id');
		$data['column_photo']	 		= $this->lang->line('column_photo');
		$data['column_menu'] 			= $this->lang->line('column_menu');
		$data['column_price'] 			= $this->lang->line('column_price');
		$data['column_action'] 			= $this->lang->line('column_action');
		// END of retrieving lines from language file to send to view.
				
		$data['button_order'] = '<a class="btn btn-success btn-checkout" href="'. site_url('main/checkout') .'">'. $this->lang->line('button_order') .'</a>';
		$data['quantities'] = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
		
		$this->load->model('Image_tool_model');
		
		$data['show_menu_images'] = $this->config->item('show_menu_images');
		$menu_images_h = (is_numeric($this->config->item('menu_images_h'))) ? $this->config->item('menu_images_h') : '50';
		$menu_images_w = (is_numeric($this->config->item('menu_images_w'))) ? $this->config->item('menu_images_w') : '50';

		$data['menus'] = array();		
		$menus = $this->Menus_model->getMainMenus($filter);	 								// retrieve menus array based on category_id if available
		foreach ($menus as $menu) {															// loop through menus array
			if (!empty($menu['menu_photo'])) {
				$menu_photo_src = $this->Image_tool_model->resize($menu['menu_photo'], $menu_images_w, $menu_images_h);
			} else {
				$menu_photo_src = $this->Image_tool_model->resize('data/no_photo.png', $menu_images_w, $menu_images_h);
			}
						
			if ($menu['is_special'] === '1') {
				$price = $menu['special_price'];
				$daydiff = floor((strtotime($menu['end_date']) - strtotime($this->location->currentTime())) / 86400 );
				$start_date = $menu['start_date'];
				$end_date = mdate('%d %M', strtotime($menu['end_date']));
				$end_days = ($daydiff < 0) ? sprintf($this->lang->line('text_end_today')) : sprintf($this->lang->line('text_end_days'), $end_date, $daydiff);
			} else {
				$price = $menu['menu_price'];	
				$start_date = '';
				$end_date = '';	
				$end_days = '';					
			}
			
			$data['menus'][] = array( 															// create array of menu data to be sent to view
				'menu_id'			=> $menu['menu_id'],
				'menu_name' 		=> (strlen($menu['menu_name']) > 80) ? strtolower(substr($menu['menu_name'], 0, 80)) .'...' : strtolower($menu['menu_name']),			
				'menu_description' 	=> (strlen($menu['menu_description']) > 120) ? substr($menu['menu_description'], 0, 120) .'...' : $menu['menu_description'],			
				'category_name'		=> $menu['name'],
				'is_special'		=> $menu['is_special'],
				'start_date'		=> $start_date,
				'end_days'			=> $end_days,
				'menu_price'		=> $this->currency->format($price), 		//add currency symbol and format price to two decimal places
				'menu_photo'		=> $menu_photo_src
			);
		}	
		
		$data['menu_options'] = array();
		$menu_options = $this->Menus_model->getMainMenuOptions();
		foreach ($menu_options as $menu_id => $option) {					
			$option_values = array();
			foreach ($option['option_values'] as $value) {
				$option_values[] = array(
					'option_value_id'	=> $value['option_value_id'],
					'value'				=> $value['value'],
					'price'				=> (empty($value['new_price']) OR $value['new_price'] == '0.00') ? $this->currency->format($value['price']) : $this->currency->format($value['new_price']),
				);
			}
			
			$data['menu_options'][$option['menu_id']][] = array(
				'menu_option_id'	=> $option['menu_option_id'],
				'option_id'			=> $option['option_id'],
				'option_name'		=> $option['option_name'],
				'display_type'		=> $option['display_type'],
				'priority'			=> $option['priority'],
				'option_values'		=> $option_values
			);
		}
		
		$data['option_values'] = array();
		foreach ($menu_options as $option) {					
			if (!isset($data['option_values'][$option['option_id']])) {
				$data['option_values'][$option['option_id']] = $this->Menus_model->getOptionValues($option['option_id']);
			}
		}
		
		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'menus.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'menus', $data);
		} else {
			$this->template->render('themes/main/default/', 'menus', $data);
		}
	}

	public function category() {
		$this->index();
	}
}

/* End of file menus.php */
/* Location: ./application/controllers/main/menus.php */