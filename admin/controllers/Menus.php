<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Menus extends Admin_Controller
{

	public $list_filters = array(
		'filter_search'   => '',
		'filter_category' => '',
		'filter_status'   => '',
		'sort_by'         => 'menus.menu_id',
		'order_by'        => 'DESC',
	);

	public $sort_columns = array('menu_name', 'menu_price', 'stock_qty', 'menus.menu_id');

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Menus');

		$this->load->model('Menus_model'); // load the menus model
		$this->load->model('Categories_model'); // load the categories model
		$this->load->model('Menu_options_model'); // load the menu options model
		$this->load->model('Mealtimes_model'); // load the mealtimes model

		$this->load->library('currency'); // load the currency library

		$this->lang->load('menus');
	}

	public function index() {
		if ($this->input->post('delete') AND $this->_deleteMenu() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('menus', $data);
	}

	public function edit() {
		if ($this->input->post() AND $menu_id = $this->_saveMenu()) {
			$this->redirect($menu_id);
		}

		$menu_info = $this->Menus_model->getMenu((int)$this->input->get('id'));

		$title = (isset($menu_info['menu_name'])) ? $menu_info['menu_name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('menus')));

		$this->template->setStyleTag(assets_url('js/datepicker/datepicker.css'), 'datepicker-css');
		$this->template->setScriptTag(assets_url("js/datepicker/bootstrap-datepicker.js"), 'bootstrap-datepicker-js');

		$data = $this->getForm($menu_info);

		$this->template->render('menus_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term')) {
			$results = $this->Menus_model->getAutoComplete(array('menu_name' => $this->input->get('term')));
			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id'   => $result['menu_id'],
						'text' => utf8_encode($result['menu_name']),
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => $this->lang->line('text_no_match'));
			}
		}

		$this->output->set_output(json_encode($json));
	}

	protected function getList() {
		$data = array_merge($this->list_filters, $this->sort_columns);
		$data['order_by_active'] = $this->list_filters['order_by'] . ' active';

		$data['menus'] = array();
		$results = $this->Menus_model->paginate($this->list_filters, $this->index_url);
		foreach ($results->list as $result) {
			$price = ($result['special_status'] === '1' AND $result['is_special'] === '1') ? $result['special_price'] : $result['menu_price'];
			$data['menus'][] = array_merge($result, array(
				'category_name' => $result['name'],
				'menu_price'    => $this->currency->format($price),
				'edit'          => $this->pageUrl($this->edit_url, array('id' => $result['menu_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		$data['categories'] = $this->Categories_model->isEnabled()->dropdown('name');

		return $data;
	}

	protected function getForm($menu_info = array()) {
		$menu_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($menu_info['menu_id'])) {
			$menu_id = $menu_info['menu_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $menu_id));
		}

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
			$data['menu_image'] = '';
			$data['image_name'] = '';
			$data['menu_image_url'] = $this->Image_tool_model->resize('data/no_photo.png');
		}

		$data['menu_id'] = $menu_info['menu_id'];
		$data['menu_name'] = $menu_info['menu_name'];
		$data['menu_description'] = $menu_info['menu_description'];
		$data['menu_price'] = $menu_info['menu_price'];
		$data['menu_category_id'] = $menu_info['category_id'];
		$data['stock_qty'] = $menu_info['stock_qty'];
		$data['minimum_qty'] = (isset($menu_info['minimum_qty'])) ? $menu_info['minimum_qty'] : '1';
		$data['subtract_stock'] = $menu_info['subtract_stock'];
		$data['special_id'] = $menu_info['special_id'];
		$data['start_date'] = (isset($menu_info['start_date']) AND $menu_info['start_date'] !== '0000-00-00') ? mdate('%d-%m-%Y', strtotime($menu_info['start_date'])) : '';
		$data['end_date'] = (isset($menu_info['end_date']) AND $menu_info['end_date'] !== '0000-00-00') ? mdate('%d-%m-%Y', strtotime($menu_info['end_date'])) : '';
		$data['special_price'] = (isset($menu_info['special_price']) AND $menu_info['special_price'] == '0.00') ? '' : $menu_info['special_price'];
		$data['special_status'] = ($this->input->post('special_status')) ? $this->input->post('special_status') : $menu_info['special_status'];
		$data['menu_status'] = isset($menu_info['menu_status']) ? $menu_info['menu_status'] : '1';
		$data['mealtime_id'] = $menu_info['mealtime_id'];
		$data['menu_priority'] = $menu_info['menu_priority'];
		$data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png');

		$data['categories'] = $this->Categories_model->isEnabled()->dropdown('name');

		$data['mealtimes'] = array();
		$results = $this->Mealtimes_model->getMealtimes();
		foreach ($results as $result) {
			$start_time = mdate('%H:%i', strtotime($result['start_time']));
			$end_time = mdate('%H:%i', strtotime($result['end_time']));
			$data['mealtimes'][] = array_merge($result, array(
				'label' => "({$start_time} - {$end_time})",
			));
		}

		if ($this->input->post('menu_options')) {
			$menu_options = $this->input->post('menu_options');
		} else {
			$menu_options = $this->Menu_options_model->getMenuOptions($menu_id);
		}

		$data['menu_options'] = array();
		foreach ($menu_options as $option) {
			$option_values = array();
			if (isset($option['option_values'])) foreach ($option['option_values'] as $value) {
				$option_values[] = array_merge($value, array(
					'price' => (empty($value['new_price']) OR $value['new_price'] == '0.00') ? '' : $value['new_price'],
				));
			}

			$data['menu_options'][] = array_merge($option, array(
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

	protected function _saveMenu() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($menu_id = $this->Menus_model->saveMenu($this->input->get('id'), $this->input->post())) {
				log_activity($this->user->getStaffId(), $save_type, 'menus', get_activity_message('activity_custom',
					array('{staff}', '{action}', '{context}', '{link}', '{item}'),
					array($this->user->getStaffName(), $save_type, 'menu item', $this->pageUrl($this->edit_url, array('id' => $menu_id)), $this->input->post('menu_name'))
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Menu ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $menu_id;
		}
	}

	protected function _deleteMenu() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Menus_model->deleteMenu($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Menus' : 'Menu';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules[] = array('menu_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$rules[] = array('menu_description', 'lang:label_description', 'xss_clean|trim|min_length[2]|max_length[1028]');
		$rules[] = array('menu_price', 'lang:label_price', 'xss_clean|trim|required|numeric');
		$rules[] = array('menu_category_id', 'lang:label_category', 'xss_clean|trim|required|integer');
		$rules[] = array('menu_photo', 'lang:label_photo', 'xss_clean|trim');
		$rules[] = array('stock_qty', 'lang:label_stock_qty', 'xss_clean|trim|integer');
		$rules[] = array('minimum_qty', 'lang:label_minimum_qty', 'xss_clean|trim|required|integer');
		$rules[] = array('subtract_stock', 'lang:label_subtract_stock', 'xss_clean|trim|required|integer');
		$rules[] = array('menu_status', 'lang:label_status', 'xss_clean|trim|required|integer');
		$rules[] = array('mealtime_id', 'lang:label_mealtime', 'xss_clean|trim|required|integer');
		$rules[] = array('menu_priority', 'lang:label_menu_priority', 'xss_clean|trim|integer');
		$rules[] = array('special_status', 'lang:label_special_status', 'xss_clean|trim|required|integer');

		if ($this->input->post('menu_options')) {
			foreach ($this->input->post('menu_options') as $key => $value) {
				$rules[] = array('menu_options[' . $key . '][menu_option_id]', 'lang:label_option', 'xss_clean|trim|integer');
				$rules[] = array('menu_options[' . $key . '][option_id]', 'lang:label_option_id', 'xss_clean|trim|required|integer');
				$rules[] = array('menu_options[' . $key . '][option_name]', 'lang:label_option_name', 'xss_clean|trim|required');
				$rules[] = array('menu_options[' . $key . '][display_type]', 'lang:label_option_display_type', 'xss_clean|trim|required');
				$rules[] = array('menu_options[' . $key . '][default_value_id]', 'lang:label_default_value_id', 'xss_clean|trim|integer');
				$rules[] = array('menu_options[' . $key . '][priority]', 'lang:label_option_id', 'xss_clean|trim|required|integer');
				$rules[] = array('menu_options[' . $key . '][required]', 'lang:label_option_required', 'xss_clean|trim|required|integer');

				if (isset($value['option_values'])) foreach ($value['option_values'] as $option => $option_value) {
					$rules[] = array('menu_options[' . $key . '][option_values][' . $option . '][option_value_id]', 'lang:label_option_value', 'xss_clean|trim|required|integer');
					$rules[] = array('menu_options[' . $key . '][option_values][' . $option . '][price]', 'lang:label_option_price', 'xss_clean|trim|numeric');
					$rules[] = array('menu_options[' . $key . '][option_values][' . $option . '][quantity]', 'lang:label_option_qty', 'xss_clean|trim|numeric');
					$rules[] = array('menu_options[' . $key . '][option_values][' . $option . '][subtract_stock]', 'lang:label_option_subtract_stock', 'xss_clean|trim|numeric');
					$rules[] = array('menu_options[' . $key . '][option_values][' . $option . '][menu_option_value_id]', 'lang:label_option_value_id', 'xss_clean|trim|numeric');
				}
			}
		}

		if ($this->input->post('special_status') === '1') {
			$rules[] = array('start_date', 'lang:label_start_date', 'xss_clean|trim|required');
			$rules[] = array('end_date', 'lang:label_end_date', 'xss_clean|trim|required');
			$rules[] = array('special_price', 'lang:label_special_price', 'xss_clean|trim|required|numeric');
		}

		return $this->Menus_model->set_rules($rules)->validate();
	}
}

/* End of file Menus.php */
/* Location: ./admin/controllers/Menus.php */