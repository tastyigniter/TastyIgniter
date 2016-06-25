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
		$results = $this->Categories_model->getCategories(0); 										// retrieve all menu categories from getCategories method in Menus model
		foreach (sort_array($results) as $result) {															// loop through menu categories array
			$children_data = array();

			if (!empty($result['child_id'])) {
				$sibling_data = array();

				if (!empty($result['sibling_id'])) {
					$sibling = $this->Categories_model->getCategories($result['child_id']);							// retrieve all menu categories from getCategories method in Menus model

					foreach ($sibling as $sib) {
						$sibling_data[$sib['category_id']] = array( 														// create array of category data to pass to view
							'category_id'	=>	$sib['category_id'],
							'category_name'	=>	$sib['name'],
							'href'			=>	site_url('menus?category_id='. $sib['category_id']),
						);
					}
				}

				$children = $this->Categories_model->getCategories($result['category_id']);							// retrieve all menu categories from getCategories method in Menus model

				foreach ($children as $child) {
					$children_data[$child['category_id']] = array( 														// create array of category data to pass to view
						'category_id'	=>	$child['category_id'],
						'category_name'	=>	$child['name'],
						'href'			=>	site_url('menus?category_id='. $child['category_id']),
						'children'		=>	$sibling_data,
					);
				}
			}

			$data['categories'][$result['category_id']] = array( 														// create array of category data to pass to view
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['name'],
				'href'			=>	site_url('menus?category_id='. $result['category_id']),
				'children'		=>	$children_data,
			);
		}

		$mix_it_up = (!empty($menu_total) AND $menu_total > 500) ? FALSE : TRUE;
		$data['category_tree'] = $this->categoryTree($data['categories'], $mix_it_up);

		$fixed_top_offset = isset($ext_data['fixed_top_offset']) ? $ext_data['fixed_top_offset'] : '350';
		$fixed_bottom_offset = isset($ext_data['fixed_bottom_offset']) ? $ext_data['fixed_bottom_offset'] : '320';
		$data['fixed_categories'] = 'data-spy="affix" data-offset-top="'.$fixed_top_offset.'" data-offset-bottom="'.$fixed_bottom_offset.'"';

		// pass array $data and load view files
		return $this->load->view('categories_module/categories_module', $data, TRUE);
	}

	protected function categoryTree($categories, $mix_it_up, $is_child = FALSE) {
		$category_id = $this->input->get('category_id');

		$url = 'menus';
		if ($location_id = $this->input->get('location_id')) {
			$url = "local?location_id={$location_id}";
		}

		$tree = '<ul class="list-group list-group-responsive">';

		if (!$is_child) {
			$tree .= '<li class="list-group-item"><a class="" href="'.site_url($url).'"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;'.$this->lang->line('text_show_all').'</a>';
		}

		if ( ! empty($categories)) {
			foreach ($categories as $category) {
				$selector = '.'.strtolower(str_replace(' ', '-', str_replace('&', '_', $category['category_name'])));

				if ($mix_it_up) {
					$attr = ' class="filter" data-filter="'.$selector.'" ';
				} else {
					$attr = ($category['category_id'] === $category_id) ? ' class="" ' : ' class="active" ';
					$attr .= 'href="' . site_url($url . (($location_id) ? '&' : '?') . 'category_id=' . $category['category_id']) . '" ';
				}

				if (!empty($category['children'])) {
					$tree .= '<li class="list-group-item"><a'.$attr.'><i class="fa fa-angle-right"></i>&nbsp;&nbsp;' . $category['category_name'] . '</a>';
					$tree .= $this->categoryTree($category['children'], $mix_it_up, TRUE);
					$tree .= '</li>';
				} else {
					$tree .= '<li class="list-group-item"><a'.$attr.'><i class="fa fa-angle-right"></i>&nbsp;&nbsp;' . $category['category_name'] . '</a></li>';
				}
			}
		}

		$tree .= '</ul>';

		return $tree;
	}
}

/* End of file categories_module.php */
/* Location: ./extensions/categories_module/controllers/categories_module.php */