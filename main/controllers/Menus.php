<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Menus extends Main_Controller
{

	public $filter = array(
		'filter_status' => '1',
	);

	public $default_sort = array('menus.menu_priority', 'ASC');

	public function __construct() {
		parent::__construct();                                                                    // calls the constructor

		$this->load->model('Menus_model');                                                        // load the menus model
		$this->load->model('Categories_model');                                                        // load the menus model
		$this->load->model('Menu_options_model');                                                        // load the menus model
		$this->load->model('Pages_model');

		$this->load->library('location');                                                        // load the location library

		$this->load->library('currency');                                                        // load the currency library

		$this->lang->load('menus');
	}

	public function index() {
//		$categories = $this->Categories_model->getCategory($this->input->get('category_id'));
//		if (!$categories AND $this->input->get('category_id')) {
			show_404();
//		}

		$this->template->setTitle($this->lang->line('text_heading'));

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'menus');

		$this->template->setScriptTag('js/jquery.mixitup.js', 'jquery-mixitup-css', '100330');

		$data['menu_list'] = $this->getList();

		$data['menu_total'] = $this->Menus_model->getCount();

		$this->load->module('local');

		$data['location_name'] = $this->location->getName();

		$data['local_info'] = $this->local->info();

		$data['local_reviews'] = $this->local->reviews();

		$data['local_gallery'] = $this->local->gallery();
		
		$this->template->render('menus', $data);
	}

	public function category() {
		$this->index();
	}

	public function getList() {
		$url = '?';

		$data['quantities'] = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
		$data['show_menu_images'] = $this->config->item('show_menu_images');
		$data['category_id'] = $this->input->get('category_id');

		$data['menu_total'] = $this->Menus_model->getCount();
		$mix_it_up = (!empty($menu_total) AND $menu_total < 500) ? TRUE : FALSE;

		if (!$mix_it_up AND $this->input->get('category_id')) {
			$this->setFilter('filter_category', (int)$this->input->get('category_id'));
		}

		$results = $this->Menus_model->paginate($this->getFilter(), current_url());
		$data['menus'] = $results->list;
		$data['pagination'] = $results->pagination;
		
		$data['categories'] = array();
		$categories = $this->Categories_model->getCategories();
		foreach (sort_array($categories) as $category) {
			if (!empty($data['category_id']) AND !$mix_it_up AND $data['category_id'] != $category['category_id']) continue;

			$category_image = '';
			if (!empty($category['image'])) {
				$category_image = $this->Image_tool_model->resize($category['image'], '800', '115');
			}

			$permalink = $this->permalink->getPermalink('category_id=' . $category['category_id']);
			$permalink['slug'] = (!empty($permalink['slug'])) ? $permalink['slug'] : strtolower(str_replace(' ', '-', str_replace('&', '_', $category['name'])));
			$data['categories'][$category['category_id']] = array_merge($category, array(
				'image' => $category_image,
				'slug' => $permalink['slug'],
			));
		}

		$data['menu_options'] = array();
		$menu_options = $this->Menu_options_model->getMenuOptions();
		foreach ($menu_options as $menu_id => $option) {
			$option_values = array();
			foreach ($option['option_values'] as $value) {
				$option_values[] = array_merge($value, array(
					'price' => (empty($value['new_price']) OR $value['new_price'] == '0.00') ? $this->currency->format($value['price']) : $this->currency->format($value['new_price']),
				));
			}

			$data['menu_options'][$option['menu_id']][] = array_merge($option, array(
				'default_value_id' => isset($option['default_value_id']) ? $option['default_value_id'] : 0,
				'option_values'    => $option_values,
			));
		}

		$data['option_values'] = array();
		foreach ($menu_options as $option) {
			if (!isset($data['option_values'][$option['option_id']])) {
				$data['option_values'][$option['option_id']] = $this->Menu_options_model->getOptionValues($option['option_id']);
			}
		}

		return $data;
	}
}

/* End of file menus.php */
/* Location: ./main/controllers/menus.php */