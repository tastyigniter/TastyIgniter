<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menus extends CI_Controller {

	private $error = array();

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->library('currency'); // load the currency library
		$this->load->model('Menus_model'); // load the menus model
	}

	public function index() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later

		if ( !file_exists(APPPATH .'/views/admin/menus.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/menus')) {
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
				
		if ($this->input->get('filter_category')) {
			$filter['category_id'] = (int) $this->input->get('filter_category');
			$data['category_id'] = $this->input->get('filter_category');
		} else {
			$data['category_id'] = '';
		}
		
		$data['heading'] 			= 'Menus';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Add new menu</a></li>';
		$data['text_no_menus'] 		= 'There are no menus added to your database.';
		
		$data['menus'] = array();		
		$results = $this->Menus_model->getList($filter);
		foreach ($results as $result) {
			
			if (!empty($result['menu_photo'])) {
				$menu_photo_src = $this->config->base_url('assets/img/' . $result['menu_photo']);
			} else {
				$menu_photo_src = $this->config->base_url('assets/img/no_menu_photo.png');
			}
						
			$data['menus'][] = array(
				'menu_id'			=> $result['menu_id'],
				'menu_name'			=> $result['menu_name'],
				'menu_description'	=> $result['menu_description'],
				'category_name'		=> $result['category_name'],
				'menu_price'		=> $this->currency->format($result['menu_price']),
				'menu_photo'		=> $menu_photo_src,
				'stock_qty'			=> $result['stock_qty'],
				'menu_status'		=> ($result['menu_status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 				=> $this->config->site_url('admin/menus/edit/' . $result['menu_id'])
			);
		}	

		//load category data into array
		$data['categories'] = array();
		$categories = $this->Menus_model->getCategories();
		foreach ($categories as $category) {					
			$data['categories'][] = array(
				'category_id'	=>	$category['category_id'],
				'category_name'	=>	$category['category_name']
			);
		}
		
		$data['has_options'] = $this->Menus_model->hasMenuOptions();

		$this->load->model('Specials_model');
		$data['is_specials'] = $this->Specials_model->getIsSpecials();

		//load food option data into array
		$data['menu_options'] = array();
		$menu_options = $this->Menus_model->getMenuOptions();
		foreach ($menu_options as $food_option) {
			$data['menu_options'][] = array(
				'option_id' 	=> $food_option['option_id'],
				'option_name' 	=> $food_option['option_name'],
				'option_price' 	=> $food_option['option_price']
			);
		}

		$config['base_url'] 		= $this->config->site_url('admin/menus');
		$config['total_rows'] 		= $this->Menus_model->menus_record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post() && $this->_addMenu() === TRUE) {
		
			redirect('admin/menus');
		}

		//check if POST update_food then remove menu_id
		if ($this->input->post('delete') && $this->_deleteMenu() === TRUE) {

			redirect('admin/menus');  			
		}	

		$this->load->view('admin/header', $data);
		$this->load->view('admin/menus', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		
		if ( !file_exists(APPPATH .'/views/admin/menus_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/menus')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		//check if /menu_id is set in uri string
		if (is_numeric($this->uri->segment(4))) {
			$menu_id = $this->uri->segment(4);
		} else {
		    redirect('admin/menus');
		}
		
		$menu_info = $this->Menus_model->getAdminMenu($menu_id);

		$data['heading'] 			= 'Menus';
		$data['sub_menu_update'] 	= 'Update';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/menus');

		if (!empty($menu_info['menu_photo'])) {
			$data['menu_photo'] = $this->config->base_url('assets/img/' . $menu_info['menu_photo']);
		} else {
			$data['menu_photo'] = $this->config->base_url('assets/img/no_menu_photo.png');
		}

		$data['menu_id'] 			= $menu_info['menu_id'];
		$data['menu_name'] 			= $menu_info['menu_name'];
		$data['menu_description']	= $menu_info['menu_description'];
		$data['menu_price'] 		= $menu_info['menu_price'];
		$data['menu_category'] 		= $menu_info['category_id'];
		$data['stock_qty'] 			= $menu_info['stock_qty'];
		$data['minimum_qty'] 		= $menu_info['minimum_qty'];
		$data['start_date'] 		= $menu_info['start_date'];
		$data['end_date'] 			= $menu_info['end_date'];
		$data['special_price'] 		= $menu_info['special_price'];
		$data['subtract_stock']		= $menu_info['subtract_stock'];
		$data['menu_status'] 		= $menu_info['menu_status'];

		$data['has_options'] 		= $this->Menus_model->hasMenuOptions($menu_id);

		//load category data into array
		$data['categories'] = array();
		$results = $this->Menus_model->getCategories();
		foreach ($results as $result) {					
			$data['categories'][] = array(
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['category_name']
			);
		}

		//load food option data into array
		$data['menu_options'] = array();
		$results = $this->Menus_model->getMenuOptions();
		foreach ($results as $result) {
			$data['menu_options'][] = array(
				'option_id' 	=> $result['option_id'],
				'option_name' 	=> $result['option_name'],
				'option_price' 	=> $result['option_price']
			);
		}
		
		// check if POST add_food, validate fields and add Menu to model
		if ($this->input->post() && $this->_updateMenu($menu_id) === TRUE) {
					
			redirect('admin/menus');
		}
							
		$this->load->view('admin/header', $data);
		$this->load->view('admin/menus_edit', $data);
		$this->load->view('admin/footer');
	}

	public function autocomplete() {
		$json = array();
		
		if ($this->input->get('menu')) {
			$filter_data = array();
			$filter_data = array(
				'menu_name' => $this->input->get('menu')
			);
		}
		
		$results = $this->Menus_model->getAutoComplete($filter_data);

		if ($results) {
			foreach ($results as $result) {
				$json[] = array(
					'menu_id' 		=> $result['menu_id'],
					'menu_name' 	=> $result['menu_name']
				);
			}
		}
		
		$this->output->set_output(json_encode($json));
	}
	
	public function _addMenu() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/menus')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
  	
    	} else if ( ! $this->input->post('delete')) { 
    	
    		//form validation
			$this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required|min_length[2]|max_length[255]');
			$this->form_validation->set_rules('menu_description', 'Menu Description', 'trim|min_length[2]|max_length[1028]');
			$this->form_validation->set_rules('menu_price', 'Menu Price', 'trim|required|numeric');
			$this->form_validation->set_rules('menu_category', 'Menu Category', 'trim|required|integer');
			$this->form_validation->set_rules('menu_photo', 'Menu Photo', 'callback_handle_upload');
			$this->form_validation->set_rules('stock_qty', 'Stock Quantity', 'trim|required|integer');
			$this->form_validation->set_rules('minimum_qty', 'Minimum Quantity', 'trim|required|integer');
			$this->form_validation->set_rules('subtract_stock', 'Subtract Stock', 'trim|requried|integer');
			$this->form_validation->set_rules('menu_options[]', 'Menu Options', 'trim|integer');
			$this->form_validation->set_rules('menu_special', 'Menu Special', 'trim|required|integer');
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|callback_handle_date');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|callback_handle_date');
			$this->form_validation->set_rules('special_price', 'Special Price', 'trim|numeric');
			$this->form_validation->set_rules('menu_status', 'Menu Status', 'trim|requried|integer');

			//if validation is true
  			if ($this->form_validation->run() === TRUE) {
				$add = array();
  		    	
  		    	//Sanitizing the POST values
				$add['menu_name'] 			= $this->input->post('menu_name');
				$add['menu_description'] 	= $this->input->post('menu_description');
				$add['menu_price'] 			= $this->input->post('menu_price');
				$add['menu_category'] 		= $this->input->post('menu_category');
				$add['menu_photo'] 			= $this->input->post('menu_photo');			
				$add['stock_qty'] 			= $this->input->post('stock_qty');			
				$add['minimum_qty'] 		= $this->input->post('minimum_qty');			
				$add['subtract_stock'] 		= $this->input->post('subtract_stock');			
				$add['menu_options'] 		= $this->input->post('menu_options');
				$add['menu_special'] 		= $this->input->post('menu_special');
				$add['start_date'] 			= $this->input->post('start_date');
				$add['end_date'] 			= $this->input->post('end_date');
				$add['special_price'] 		= $this->input->post('special_price');
				$add['menu_status'] 		= $this->input->post('menu_status');
				
				if ($this->Menus_model->addMenu($add)) {
				
					$this->session->set_flashdata('alert', '<p class="success">Menu Added Sucessfully!</p>');
				
				} else {
				
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
				
				}
				
				return TRUE;
			}
		}	
	}

	public function _updateMenu($menu_id) {
    	if (!$this->user->hasPermissions('modify', 'admin/menus')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else { 
		
			$this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required|min_length[2]|max_length[255]');
			$this->form_validation->set_rules('menu_description', 'Menu Description', 'trim|min_length[2]|max_length[1028]');
			$this->form_validation->set_rules('menu_price', 'Menu Price', 'trim|required|numeric');
			$this->form_validation->set_rules('menu_category', 'Menu Category', 'trim|required|integer');
			$this->form_validation->set_rules('menu_photo', 'Menu Photo', 'callback_handle_upload');
			$this->form_validation->set_rules('stock_qty', 'Stock Quantity', 'trim|required|integer');
			$this->form_validation->set_rules('minimum_qty', 'Minimum Quantity', 'trim|required|integer');
			$this->form_validation->set_rules('subtract_stock', 'Subtract Stock', 'trim|requried|integer');
			$this->form_validation->set_rules('menu_options[]', 'Menu Options', 'trim|integer');
			$this->form_validation->set_rules('menu_special', 'Menu Special', 'trim|required|integer');
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|callback_handle_date');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|callback_handle_date');
			$this->form_validation->set_rules('special_price', 'Special Price', 'trim|numeric');
			$this->form_validation->set_rules('menu_status', 'Menu Status', 'trim|requried|integer');

			if ($this->form_validation->run() === TRUE) {
				$update = array();

				$update['menu_id'] 			= $menu_id;
				
				//Sanitizing the POST values
				$update['menu_name'] 			= $this->input->post('menu_name');
				$update['menu_description'] 	= $this->input->post('menu_description');
				$update['menu_price']			= $this->input->post('menu_price');
				$update['menu_category'] 		= $this->input->post('menu_category');
				$update['menu_photo'] 			= $this->input->post('menu_photo');					
				$update['stock_qty'] 			= $this->input->post('stock_qty');			
				$update['minimum_qty'] 			= $this->input->post('minimum_qty');			
				$update['subtract_stock'] 		= $this->input->post('subtract_stock');			
				$update['menu_options'] 		= $this->input->post('menu_options');
				$update['menu_special'] 		= $this->input->post('menu_special');
				$update['start_date'] 			= $this->input->post('start_date');
				$update['end_date'] 			= $this->input->post('end_date');
				$update['special_price'] 		= $this->input->post('special_price');
				$update['menu_status'] 			= $this->input->post('menu_status');


				if ($this->Menus_model->updateMenu($update)) {						
				
					$this->session->set_flashdata('alert', '<p class="success">Menu Updated Sucessfully!</p>');
				
				} else {
				
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				
				}
				
				return TRUE;
			}
		}
	}

	public function _deleteMenu($menu_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/menus')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if ($this->input->post('delete') === '1') {
					
				$this->Menus_model->deleteMenu($menu_id);
					
				$this->session->set_flashdata('alert', '<p class="success">Menu Deleted Sucessfully!</p>');

			} else if (is_array($this->input->post('delete'))) {

				//sorting the post[quantity] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$menu_id = $value;
				
					$this->Menus_model->deleteMenu($menu_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Menu(s) Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}
	
 	public function handle_upload() {
		//loading upload library
		$this->load->library('upload');

		//setting upload preference
		$this->upload->set_upload_path($this->config->item('config_upload_path'));
		$this->upload->set_allowed_types($this->config->item('config_allowed_types'));
		$this->upload->set_max_filesize($this->config->item('config_max_size'));
		$this->upload->set_max_width($this->config->item('config_max_width'));
		$this->upload->set_max_height($this->config->item('config_max_height'));

		if (isset($_FILES['menu_photo']) && !empty($_FILES['menu_photo']['name'])) {
      		
      		if ($this->upload->do_upload('menu_photo')) {

        		// set a $_POST value for 'menu_photo' that we can use later
        		$upload_data    = $this->upload->data();
        		if ($upload_data) {
        			$_POST['menu_photo'] = $this->security->sanitize_filename($upload_data['file_name']);
        		}
        		return TRUE;        
      		} else {
        		
        		// possibly do some clean up ... then throw an error
        		$this->form_validation->set_message('handle_upload', $this->upload->display_errors());
        		return FALSE;
     		}
    	} else {
      	
        	// set an empty $_POST value for 'menu_photo' to be used on database queries
        	$_POST['menu_photo'] = '';
      		//return TRUE;
      	}
    }

 	public function handle_date($date) {
      		
     	$human_to_unix = human_to_unix($date);
		if ( ! isset($human_to_unix)) {
        	$this->form_validation->set_message('handle_date', 'The %s field is not a valid date/time.');
      		return FALSE;
    	} else {
        	return TRUE;        
      	}
    }
}