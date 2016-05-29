<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Categories_module extends Main_Controller {

	public function index() {
		$this->load->model('Menus_model'); 														// load the menus model
		$this->load->model('Categories_model'); 														// load the menus model
		$this->lang->load('categories_module/categories_module');

		if ( ! file_exists(EXTPATH .'categories_module/views/categories_module.php')) { 		//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if (is_numeric($this->input->get('category_id'))) {
			$data['category_id'] = $this->input->get('category_id');
		} else {
			$data['category_id'] = 0;
		}

		$this->template->setStyleTag(extension_url('categories_module/views/stylesheet.css'), 'categories-module-css', '155000');

		$data['menu_total'] 			= $this->Menus_model->getCount();

		$data['categories'] = array();
		$results = $this->Categories_model->getCategories(); 										// retrieve all menu categories from getCategories method in Menus model
		foreach (sort_array($results) as $result) {															// loop through menu categories array
			$children_data = array();

			if ($result['child_id'] !== NULL) {
				$children = $this->Categories_model->getCategories($result['category_id']); 										// retrieve all menu categories from getCategories method in Menus model

				foreach ($children as $child) {
					$children_data[$child['category_id']] = array( 														// create array of category data to pass to view
						'category_id'	=>	$child['category_id'],
						'category_name'	=>	$child['name'],
						'href'			=>	site_url('menus?category_id='. $child['category_id'])
					);
				}
			}

			$data['categories'][$result['category_id']] = array( 														// create array of category data to pass to view
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['name'],
				'children'		=>	$children_data,
				'href'			=>	site_url('menus?category_id='. $result['category_id'])
			);
		}

		$fixed_top_offset = isset($ext_data['fixed_top_offset']) ? $ext_data['fixed_top_offset'] : '350';
		$fixed_bottom_offset = isset($ext_data['fixed_bottom_offset']) ? $ext_data['fixed_bottom_offset'] : '320';
		$data['fixed_categories'] = 'data-spy="affix" data-offset-top="'.$fixed_top_offset.'" data-offset-bottom="'.$fixed_bottom_offset.'"';

		// pass array $data and load view files
		return $this->load->view('categories_module/categories_module', $data, TRUE);
	}
}

/* End of file categories_module.php */
/* Location: ./extensions/categories_module/controllers/categories_module.php */