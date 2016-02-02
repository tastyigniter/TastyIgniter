<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_local_module extends Admin_Controller {

	public function index($data = array()) {
		$this->lang->load('local_module/local_module');

		$this->user->restrict('Module.LocalModule');

        if (!empty($data)) {
	        $title = (isset($data['title'])) ? $data['title'] : $this->lang->line('_text_title');

	        $this->template->setTitle('Module: ' . $title);
	        $this->template->setHeading('Module: ' . $title);
            $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

	        if ($this->input->post('location_search_mode')) {
		        $data['location_search_mode'] = $this->input->post('location_search_mode');
	        } else if (isset($data['ext_data']['location_search_mode'])) {
		        $data['location_search_mode'] = $data['ext_data']['location_search_mode'];
	        } else {
		        $data['location_search_mode'] = 'multi';
	        }

	        if ($this->input->post('use_location')) {
		        $data['use_location'] = $this->input->post('use_location');
	        } else {
		        $data['use_location'] = $data['ext_data']['use_location'];
	        }

	        $data['lang_texts'] = array(
		        'text_find'                 => lang('text_find'),
		        'text_order_summary'        => lang('text_order_summary'),
		        'text_location_summary'     => lang('text_location_summary'),
		        'text_goto_menus'           => lang('text_goto_menus'),
		        'text_enter_location'       => lang('text_enter_location'),
		        'text_is_opened'            => lang('text_is_opened'),
		        'text_is_closed'            => lang('text_is_closed'),
		        'text_is_temp_closed'       => lang('text_is_temp_closed'),
		        'text_offer'                => lang('text_offer'),
		        'text_delivery_only'        => lang('text_delivery_only'),
		        'text_collection_only'      => lang('text_collection_only'),
		        'text_both_types'           => lang('text_both_types'),
		        'text_no_types'             => lang('text_no_types'),
		        'text_24_7_hour'            => lang('text_24_7_hour'),
		        'text_min_total'            => lang('text_min_total'),
		        'text_delivery_time_info'   => lang('text_delivery_time_info'),
		        'text_collection_time_info' => lang('text_collection_time_info'),
		        'text_delivery_charge'      => lang('text_delivery_charge'),
		        'text_free_delivery'        => lang('text_free_delivery'),
	        );

	        if ($this->input->post('lang')) {
		        $data['lang_texts'] = $this->input->post('lang');
	        } else if (isset($data['ext_data']['lang'])) {
		        $data['lang_texts'] = $data['ext_data']['lang'];
	        }

	        if ($this->input->post('status')) {
		        $data['status'] = $this->input->post('status');
	        } else if (isset($data['ext_data']['status'])) {
		        $data['status'] = $data['ext_data']['status'];
	        } else {
		        $data['status'] = '0';
	        }

	        $this->load->model('Locations_model');
	        $data['locations'] = array();
	        $results = $this->Locations_model->getLocations();
	        foreach ($results as $result) {
		        $data['locations'][] = array(
			        'location_id'	=>	$result['location_id'],
			        'location_name'	=>	$result['location_name'],
		        );
	        }

	        if ($this->input->post() AND $this->_updateModule() === TRUE) {
                if ($this->input->post('save_close') === '1') {
                    redirect('extensions');
                }

                redirect('extensions/edit/module/local_module');
            }

            return $this->load->view('local_module/admin_local_module', $data, TRUE);
        }
	}

	private function _updateModule() {
		$this->user->restrict('Module.LocalModule.Manage');

    	if ($this->validateForm() === TRUE) {

			if ($this->Extensions_model->updateExtension('module', 'local_module', $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title').' module '.$this->lang->line('text_updated')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
			}

			return TRUE;
		}
	}

 	private function validateForm() {
		$this->form_validation->set_rules('location_search_mode', 'lang:label_location_search_mode', 'xss_clean|trim|required|alpha');
		$this->form_validation->set_rules('use_location', 'lang:label_use_location', 'xss_clean|trim|required|integer');

	    foreach ($this->input->post('lang') as $key => $value) {
		    $this->form_validation->set_rules('lang[$key]', 'lang:label_lang', 'trim');
	    }

	    $this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file local_module.php */
/* Location: ./extensions/local_module/controllers/local_module.php */