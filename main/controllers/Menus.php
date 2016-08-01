<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Menus extends Main_Controller
{

	public $list_filters = array(
		'filter_status' => '1',
		'sort_by'       => 'menus.menu_priority',
		'order_by'      => 'ASC',
	);

	public function __construct() {
		parent::__construct();                                                                    // calls the constructor

		$this->load->model('Menus_model');                                                        // load the menus model
		$this->load->model('Categories_model');                                                        // load the menus model
		$this->load->model('Menu_options_model');                                                        // load the menus model
		$this->load->model('Pages_model');

		$this->load->library('location');                                                        // load the location library
		$this->location->initialize();

		$this->load->library('currency');                                                        // load the currency library

		$this->lang->load('menus');
	}

	public function index() {
		$categories = $this->Categories_model->getCategory($this->input->get('category_id'));
		if (!$categories AND $this->input->get('category_id')) {
			show_404();
		}

		$this->template->setTitle($this->lang->line('text_heading'));

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'menus');

		$this->template->setScriptTag('js/jquery.mixitup.js', 'jquery-mixitup-css', '100330');

		$filter = array();
		$filter['filter_category'] = $data['category_id'] = (int)$this->input->get('category_id');                                    // retrieve 3rd uri segment else set FALSE if unavailable.

		$data['menu_list'] = $this->getList($this->list_filters + $filter);

		$data['menu_total'] = $this->Menus_model->getCount();
		if (is_numeric($data['menu_total']) AND $data['menu_total'] < 150) {
			$filter['category_id'] = 0;
		}

		$this->load->module('local');

		$data['location_name'] = $this->location->getName();

		$data['local_info'] = $this->local->info();

		$data['local_reviews'] = $this->local->reviews();

		$data['local_gallery'] = $this->local->gallery();


		$this->template->render('local', $data);
	}

	public function category() {
		$this->index();
	}

	public function getList($filter, $list_data = array()) {
		$url = '?';

		$list_data['quantities'] = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10');

		$list_data['show_menu_images'] = $this->config->item('show_menu_images');

		if ($this->input->get('category_id')) {
			$index_url = 'menus?category_id=' . $this->input->get('category_id') . $url;
		} else {
			$index_url = 'menus' . $url;
		}

		$results = $this->Menus_model->paginate($filter, $index_url);
		$list_data['menus'] = $results->list;

		$list_data['pagination'] = $results->pagination;

		$categories = $this->Categories_model->getCategories();

		$list_data['categories'] = array();
		foreach (sort_array($categories) as $category) {
			if (!empty($filter['filter_category']) AND $filter['filter_category'] != $category['category_id']) continue;

			$category_image = '';
			if (!empty($category['image'])) {
				$category_image = $this->Image_tool_model->resize($category['image'], '800', '115');
			}

			$list_data['categories'][$category['category_id']] = array_merge($category, array(
				'image' => $category_image,
			));
		}

		$list_data['menu_options'] = array();
		$menu_options = $this->Menu_options_model->getMenuOptions();
		foreach ($menu_options as $menu_id => $option) {
			$option_values = array();
			foreach ($option['option_values'] as $value) {
				$option_values[] = array_merge($value, array(
					'price' => (empty($value['new_price']) OR $value['new_price'] == '0.00') ? $this->currency->format($value['price']) : $this->currency->format($value['new_price']),
				));
			}

			$list_data['menu_options'][$option['menu_id']][] = array_merge($option, array(
				'default_value_id' => isset($option['default_value_id']) ? $option['default_value_id'] : 0,
				'option_values'    => $option_values,
			));
		}

		$list_data['option_values'] = array();
		foreach ($menu_options as $option) {
			if (!isset($list_data['option_values'][$option['option_id']])) {
				$list_data['option_values'][$option['option_id']] = $this->Menu_options_model->getOptionValues($option['option_id']);
			}
		}

		return $list_data;
	}
}

/* End of file menus.php */
/* Location: ./main/controllers/menus.php */