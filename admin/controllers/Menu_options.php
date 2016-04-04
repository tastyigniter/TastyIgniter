<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Menu_options extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.MenuOptions');

        $this->load->model('Menu_options_model'); // load the menus model

        $this->load->library('pagination');
        $this->load->library('currency'); // load the currency library

        $this->lang->load('menu_options');
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

		if ($this->input->get('filter_display_type')) {
			$filter['filter_display_type'] = $data['filter_display_type'] = $this->input->get('filter_display_type');
			$url .= 'filter_display_type='.$filter['filter_display_type'].'&';
		} else {
			$filter['filter_display_type'] = $data['filter_display_type'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'priority';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = 'ASC';
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));

        $this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deleteMenuOption() === TRUE) {
			redirect('menu_options');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('menu_options'.$url.'sort_by=option_name&order_by='.$order_by);
		$data['sort_priority'] 		= site_url('menu_options'.$url.'sort_by=priority&order_by='.$order_by);
		$data['sort_display_type'] 	= site_url('menu_options'.$url.'sort_by=display_type&order_by='.$order_by);
		$data['sort_id'] 			= site_url('menu_options'.$url.'sort_by=option_id&order_by='.$order_by);

		$data['menu_options'] = array();
		$results = $this->Menu_options_model->getList($filter);
		foreach ($results as $result) {
			$data['menu_options'][] = array(
				'option_id' 	=> $result['option_id'],
				'option_name' 	=> $result['option_name'],
				'priority' 		=> $result['priority'],
				'display_type' 	=> ucwords($result['display_type']),
				'edit' 			=> site_url('menu_options/edit?id=' . $result['option_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('menu_options'.$url);
		$config['total_rows'] 		= $this->Menu_options_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('menu_options', $data);
	}

	public function edit() {
		$option_info = $this->Menu_options_model->getOption((int) $this->input->get('id'));

		if ($option_info) {
			$option_id = $option_info['option_id'];
			$data['_action']	= site_url('menu_options/edit?id='. $option_id);
		} else {
			$option_id = 0;
			$data['_action']	= site_url('menu_options/edit');
		}

		$title = (isset($option_info['option_name'])) ? $option_info['option_name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('menu_options')));

		$this->template->setScriptTag(assets_url('js/jquery-sortable.js'), 'jquery-sortable-js');

		if ($this->input->post() AND $option_id = $this->_saveOption()){
			if ($this->input->post('save_close') === '1') {
				redirect('menu_options');
			}

			redirect('menu_options/edit?id='. $option_id);
		}

		$data['option_id'] 			= $option_info['option_id'];
		$data['option_name'] 		= $option_info['option_name'];
		$data['display_type'] 		= $option_info['display_type'];
		$data['priority'] 			= $option_info['priority'];

		if ($this->input->post('option_values')) {
			$values = $this->input->post('option_values');
		} else {
			$values = $this->Menu_options_model->getOptionValues($option_id);
		}

		$data['values'] = array();
		foreach ($values as $value) {
			$data['values'][] = array(
				'option_value_id'	=> $value['option_value_id'],
				'value'				=> $value['value'],
				'price'				=> $value['price']
			);
		}

		$this->template->render('menu_options_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term')) {
			$filter = array(
				'option_name' => $this->input->get('term')
			);

			$results = $this->Menu_options_model->getAutoComplete($filter);
			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 				=> $result['option_id'],
						'text' 				=> utf8_encode($result['option_name']),
						'display_type' 		=> utf8_encode($result['display_type']),
						'priority' 			=> $result['priority'],
						'option_values' 	=> $result['option_values']
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => $this->lang->line('text_no_match'));
			}
		}

		$this->output->set_output(json_encode($json));
	}

	private function _saveOption() {
    	if ($this->validateForm() === TRUE) {
            $save_type = (! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($option_id = $this->Menu_options_model->saveOption($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Menu option '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $option_id;
		}
	}

	private function _deleteMenuOption() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Menu_options_model->deleteOption($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Menu options': 'Menu option';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('option_name', 'lang:label_option_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('display_type', 'lang:label_display_type', 'xss_clean|trim|required|alpha');
		$this->form_validation->set_rules('priority', 'lang:label_priority', 'xss_clean|trim|required|integer');

		if ($this->input->post('option_values')) {
			foreach ($this->input->post('option_values') as $key => $value) {
				$this->form_validation->set_rules('option_values['.$key.'][value]', 'lang:label_option_value', 'xss_clean|trim|required|min_length[2]|max_length[128]');
				$this->form_validation->set_rules('option_values['.$key.'][price]', 'lang:label_option_price', 'xss_clean|trim|required|numeric');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file menu_options.php */
/* Location: ./admin/controllers/menu_options.php */