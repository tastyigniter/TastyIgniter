<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Menus extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor

        $this->load->model('Menus_model'); 														// load the menus model
        $this->load->model('Categories_model'); 														// load the menus model
        $this->load->model('Menu_options_model'); 														// load the menus model
        $this->load->model('Pages_model');

        $this->load->library('currency'); 														// load the currency library

        $this->lang->load('menus');
	}

	public function index() {
        $categories = $this->Categories_model->getCategory($this->input->get('category_id'));
        if (!$categories AND $this->input->get('category_id')) {
            show_404();
        }

		$filter = array();

        $this->template->setTitle($this->lang->line('text_heading'));

        $this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_heading'), 'menus');

        $this->template->setScriptTag('js/jquery.mixitup.js', 'jquery-mixitup-css', '100330');

		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('menus_page_limit')) {
			$filter['limit'] = $this->config->item('menus_page_limit');
		}

        $filter['sort_by'] = 'menus.menu_priority';
        $filter['order_by'] = 'ASC';
        $filter['filter_status'] = '1';

        $filter['filter_category'] = $data['category_id'] = (int) $this->input->get('category_id'); 									// retrieve 3rd uri segment else set FALSE if unavailable.

        $data['menu_list'] = $this->getList($filter);

        $data['menu_total']	= $this->Menus_model->getCount();
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

        $list_data['menus'] = $this->Menus_model->getList($filter);

        $categories = $this->Categories_model->getCategories();

        $list_data['categories'] = array();
        foreach (sort_array($categories) as $category) {
            if (!empty($filter['filter_category']) AND $filter['filter_category'] != $category['category_id']) continue;

            $category_image = '';
            if ( ! empty($category['image'])) {
                $category_image = $this->Image_tool_model->resize($category['image'], '800', '115');
            }

            $list_data['categories'][$category['category_id']] = array(
                'category_id'	    =>	$category['category_id'],
                'name'	            =>	$category['name'],
                'description'	    =>	$category['description'],
                'priority'	        =>	$category['priority'],
                'image'	            =>	$category_image
            );
        }

        $list_data['menu_options'] = array();
        $menu_options = $this->Menu_options_model->getMenuOptions();
        foreach ($menu_options as $menu_id => $option) {
            $option_values = array();

            foreach ($option['option_values'] as $value) {
                $option_values[] = array(
                    'option_value_id' => $value['option_value_id'],
                    'value'           => $value['value'],
                    'price'           => (empty($value['new_price']) OR $value['new_price'] == '0.00') ? $this->currency->format($value['price']) : $this->currency->format($value['new_price']),
                );
            }

            $list_data['menu_options'][$option['menu_id']][] = array(
                'menu_option_id'   => $option['menu_option_id'],
                'option_id'        => $option['option_id'],
                'option_name'      => $option['option_name'],
                'display_type'     => $option['display_type'],
                'priority'         => $option['priority'],
                'default_value_id' => isset($option['default_value_id']) ? $option['default_value_id'] : 0,
                'option_values'    => $option_values,
            );
        }

        $list_data['option_values'] = array();
        foreach ($menu_options as $option) {
            if ( ! isset($list_data['option_values'][$option['option_id']])) {
                $list_data['option_values'][$option['option_id']] = $this->Menu_options_model->getOptionValues($option['option_id']);
            }
        }

        if ($this->input->get('category_id')) {
            $prefs['base_url'] = site_url('menus?category_id=' . $this->input->get('category_id')) . $url;
        } else {
            $prefs['base_url'] = site_url('menus' . $url);
        }

        $prefs['total_rows'] = $this->Menus_model->getCount($filter);
        $prefs['per_page'] = $filter['limit'];

        $this->load->library('pagination');
        $this->pagination->initialize($prefs);

        $list_data['pagination'] = array(
            'info'  => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links()
        );

        return $list_data;
    }
}

/* End of file menus.php */
/* Location: ./main/controllers/menus.php */