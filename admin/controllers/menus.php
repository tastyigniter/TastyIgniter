<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Menus extends Admin_Controller {

    public $_permission_rules = array('access[index|edit]', 'modify[index|edit]');

    public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('pagination');
		$this->load->library('currency'); // load the currency library
        $this->load->model('Menus_model'); // load the menus model
        $this->load->model('Categories_model'); // load the categories model
        $this->load->model('Menu_options_model'); // load the menu options model
	}

	public function index() {
		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}

		if ($this->input->get('filter_category')) {
			$filter['filter_category'] = $data['category_id'] = (int) $this->input->get('filter_category');
			$url .= 'filter_category='.$filter['filter_category'].'&';
		} else {
			$data['category_id'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'menus.menu_id';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = 'ASC active';
		}

		$this->template->setTitle('Menus');
		$this->template->setHeading('Menus');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

        $data['text_no_menus'] 		= 'There are no menus available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('menus'.$url.'sort_by=menu_name&order_by='.$order_by);
		$data['sort_price'] 		= site_url('menus'.$url.'sort_by=menu_price&order_by='.$order_by);
		$data['sort_stock'] 		= site_url('menus'.$url.'sort_by=stock_qty&order_by='.$order_by);
		$data['sort_id'] 			= site_url('menus'.$url.'sort_by=menus.menu_id&order_by='.$order_by);

		$this->load->model('Image_tool_model');

		$data['menus'] = array();
		$results = $this->Menus_model->getList($filter);
		foreach ($results as $result) {

			if (!empty($result['menu_photo'])) {
				$menu_photo_src = $this->Image_tool_model->resize($result['menu_photo'], 40, 40);
			} else {
				$menu_photo_src = $this->Image_tool_model->resize('data/no_photo.png', 40, 40);
			}

			$special = '';
			if ((!empty($result['start_date']) AND $result['start_date'] !== '0000-00-00') AND (!empty($result['end_date']) AND $result['end_date'] !== '0000-00-00')) {
				if (strtotime($result['start_date']) <= time() AND strtotime($result['end_date']) >= time()) {
					$special = 'enabled';
				} else {
					$special = 'disabled';
				}
			}

			$data['menus'][] = array(
				'menu_id'			=> $result['menu_id'],
				'menu_name'			=> $result['menu_name'],
				'menu_description'	=> $result['menu_description'],
				'category_name'		=> $result['name'],
				'menu_price'		=> $this->currency->format($result['menu_price']),
				'menu_photo'		=> $menu_photo_src,
				'stock_qty'			=> $result['stock_qty'],
				'special'			=> $special,
				'menu_status'		=> ($result['menu_status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 				=> site_url('menus/edit?id='. $result['menu_id'])
			);
		}

		//load category data into array
		$data['categories'] = array();
		$categories = $this->Categories_model->getCategories();
		foreach ($categories as $category) {
			$data['categories'][] = array(
				'category_id'	=>	$category['category_id'],
				'category_name'	=>	$category['name']
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('menus').$url;
		$config['total_rows'] 		= $this->Menus_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteMenu() === TRUE) {
			redirect('menus');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('menus', $data);
	}

	public function edit() {
		$menu_info = $this->Menus_model->getMenu((int) $this->input->get('id'));

		if ($menu_info) {
			$menu_id = $this->input->get('id');
			$data['action']	= site_url('menus/edit?id='. $menu_id);
		} else {
			$menu_id = 0;
			$data['action']	= site_url('menus/edit');
		}

		$title = (isset($menu_info['menu_name'])) ? $menu_info['menu_name'] : 'New';
		$this->template->setTitle('Menu: '. $title);
		$this->template->setHeading('Menu: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('menus'));

        $this->template->setStyleTag(root_url('assets/js/fancybox/jquery.fancybox.css'), 'jquery-fancybox-css');
        $this->template->setScriptTag(root_url("assets/js/fancybox/jquery.fancybox.js"), 'jquery-fancybox-js');

        $this->load->model('Image_tool_model');
		if ($this->input->post('menu_photo')) {
			$data['menu_image'] = $this->input->post('menu_photo');
			$data['image_name'] = basename($this->input->post('menu_photo'));
			$data['menu_image_url'] = $this->Image_tool_model->resize($this->input->post('menu_photo'));
		} else if (!empty($menu_info['menu_photo'])) {
			$data['menu_image'] = $menu_info['menu_photo'];
			$data['image_name'] = basename($menu_info['menu_photo']);
			$data['menu_image_url'] = $this->Image_tool_model->resize($menu_info['menu_photo']);
		} else {
			$data['menu_image'] = 'data/no_photo.png';
			$data['image_name'] = 'no_photo.png';
			$data['menu_image_url'] = $this->Image_tool_model->resize('data/no_photo.png');
		}

		$data['menu_id'] 			= $menu_info['menu_id'];
		$data['menu_name'] 			= $menu_info['menu_name'];
		$data['menu_description']	= $menu_info['menu_description'];
		$data['menu_price'] 		= $menu_info['menu_price'];
		$data['menu_category'] 		= $menu_info['category_id'];
		$data['stock_qty'] 			= $menu_info['stock_qty'];
		$data['minimum_qty'] 		= (isset($menu_info['minimum_qty'])) ? $menu_info['minimum_qty'] : '1';
		$data['subtract_stock']		= $menu_info['subtract_stock'];
		$data['special_id'] 		= $menu_info['special_id'];
		$data['start_date'] 		= (isset($menu_info['start_date']) AND $menu_info['start_date'] !== '0000-00-00') ? mdate('%d-%m-%Y', strtotime($menu_info['start_date'])) : '';
		$data['end_date'] 			= (isset($menu_info['end_date']) AND $menu_info['end_date'] !== '0000-00-00') ? mdate('%d-%m-%Y', strtotime($menu_info['end_date'])) : '';
		$data['special_price'] 		= (isset($menu_info['special_price']) AND $menu_info['special_price'] == '0.00') ? '' : $menu_info['special_price'];
		$data['special_status'] 	= $menu_info['special_status'];
		$data['menu_status'] 		= $menu_info['menu_status'];
		$data['no_photo'] 			= $this->Image_tool_model->resize('data/no_photo.png');

		$data['categories'] = array();
		$results = $this->Categories_model->getCategories();
		foreach ($results as $result) {
			$data['categories'][] = array(
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['name']
			);
		}

		if ($this->input->post('menu_options')) {
			$menu_options = $this->input->post('menu_options');
		} else {
			$menu_options = $this->Menu_options_model->getMenuOptions($menu_id);
		}

		$data['menu_options'] = array();
		foreach ($menu_options as $option) {
			$option_values = array();
			foreach ($option['option_values'] as $value) {
				$option_values[] = array(
					'menu_option_value_id'	=> $value['menu_option_value_id'],
					'option_value_id'		=> $value['option_value_id'],
					'price'					=> (empty($value['new_price']) OR $value['new_price'] == '0.00') ? '' : $value['new_price'],
					'quantity'				=> $value['quantity'],
					'subtract_stock'		=> $value['subtract_stock']
				);
			}

			$data['menu_options'][] = array(
				'menu_option_id'	=> $option['menu_option_id'],
				'option_id'			=> $option['option_id'],
				'option_name'		=> $option['option_name'],
				'display_type'		=> $option['display_type'],
				'required'			=> $option['required'],
				'priority'			=> $option['priority'],
				'option_values'		=> $option_values
			);
		}

		$data['option_values'] = array();
		foreach ($menu_options as $option) {
			if (!isset($data['option_values'][$option['option_id']])) {
				$data['option_values'][$option['option_id']] = $this->Menu_options_model->getOptionValues($option['option_id']);
			}
		}

		if ($this->input->post() AND $menu_id = $this->_saveMenu()) {
			if ($this->input->post('save_close') === '1') {
				redirect('menus');
			}

			redirect('menus/edit?id='. $menu_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('menus_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term')) {
			$filter = array(
				'menu_name' => $this->input->get('term')
			);

			$results = $this->Menus_model->getAutoComplete($filter);
			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 		=> $result['menu_id'],
						'text' 		=> utf8_encode($result['menu_name'])
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => 'No Matches Found');
			}
		}

		$this->output->set_output(json_encode($json));
	}

	private function _saveMenu() {
    	if ($this->validateForm() === TRUE) {
            $save_type = (! is_numeric($this->input->get('id'))) ? 'added' : 'updated';

			if ($menu_id = $this->Menus_model->saveMenu($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', 'Menu ' . $save_type . ' successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing ' . $save_type . '.');
			}

			return $menu_id;
		}
	}

	private function _deleteMenu() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Menus_model->deleteMenu($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Menus': 'Menu';
                $this->alert->set('success', $prefix.' deleted successfully.');
            } else {
                $this->alert->set('warning', 'An error occurred, nothing deleted.');
            }

            return TRUE;
        }
	}

 	private function validateForm() {
		$this->form_validation->set_rules('menu_name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('menu_description', 'Description', 'xss_clean|trim|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('menu_price', 'Price', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('menu_category', 'Category', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('menu_photo', 'Photo', 'xss_clean|trim|required');
		$this->form_validation->set_rules('stock_qty', 'Stock Quantity', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('minimum_qty', 'Minimum Quantity', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('subtract_stock', 'Subtract Stock', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('menu_status', 'Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('special_status', 'Special Status', 'xss_clean|trim|required|integer');

		if ($this->input->post('menu_options')) {
			foreach ($this->input->post('menu_options') as $key => $value) {
				$this->form_validation->set_rules('menu_options['.$key.'][option_id]', 'Option ID', 'xss_clean|trim|required|integer');
				$this->form_validation->set_rules('menu_options['.$key.'][required]', 'Menu Option Required', 'xss_clean|trim|required|integer');

				foreach ($value['option_values'] as $option => $option_value) {
					$this->form_validation->set_rules('menu_options['.$key.'][option_values]['.$option.'][option_value_id]', 'Option Value', 'xss_clean|trim|required|integer');
					$this->form_validation->set_rules('menu_options['.$key.'][option_values]['.$option.'][price]', 'Option Price', 'xss_clean|trim|numeric');
					$this->form_validation->set_rules('menu_options['.$key.'][option_values]['.$option.'][quantity]', 'Option Quantity', 'xss_clean|trim|numeric');
					$this->form_validation->set_rules('menu_options['.$key.'][option_values]['.$option.'][subtract_stock]', 'Option Subtract Stock', 'xss_clean|trim|numeric');
					$this->form_validation->set_rules('menu_options['.$key.'][option_values]['.$option.'][menu_option_value_id]', 'Menu Option Value ID', 'xss_clean|trim|numeric');
				}
			}
		}

		if ($this->input->post('special_status') === '1') {
			$this->form_validation->set_rules('start_date', 'Start Date', 'xss_clean|trim|required');
			$this->form_validation->set_rules('end_date', 'End Date', 'xss_clean|trim|required');
			$this->form_validation->set_rules('special_price', 'Special Price', 'xss_clean|trim|required');
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file menus.php */
/* Location: ./admin/controllers/menus.php */