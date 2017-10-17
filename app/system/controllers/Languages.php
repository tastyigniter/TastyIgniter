<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Languages extends Admin_Controller {

	public function __construct() {
		parent::__construct();

        $this->user->restrict('Site.Languages');

        $this->load->model('Languages_model');
        $this->load->model('Image_tool_model');

        $this->load->library('pagination');

        $this->load->helper('language');

        $this->lang->load('languages');
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

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'language_id';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deleteLanguage() === TRUE) {
			redirect('languages');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('languages'.$url.'sort_by=name&order_by='.$order_by);
		$data['sort_code'] 			= site_url('languages'.$url.'sort_by=code&order_by='.$order_by);

		$data['language_id'] = $this->config->item('language_id');

		$data['languages'] = array();
		$results = $this->Languages_model->getList($filter);
		foreach ($results as $result) {
			$data['languages'][] = array(
				'language_id'		=> $result['language_id'],
				'name'				=> $result['name'],
				'code'				=> $result['code'],
				'image'				=> (!empty($result['image'])) ? $this->Image_tool_model->resize($result['image']) : $this->Image_tool_model->resize('data/flags/no_flag.png'),
				'status'			=> ($result['status'] === '1') ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
				'edit' 				=> site_url('languages/edit?id=' . $result['language_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('languages'.$url);
		$config['total_rows'] 		= $this->Languages_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('languages', $data);
	}

	public function edit() {
		$language_info = $this->Languages_model->getLanguage((int) $this->input->get('id'));

		if ($language_info) {
			$language_id = $language_info['language_id'];
			$data['_action']	= current_url();
		} else {
		    $language_id = 0;
			$data['_action']	= site_url('languages/edit');
		}

		if ($this->input->post() AND $language_id = $this->_saveLanguage()) {
			if ($this->input->post('save_close') === '1') {
				redirect('languages');
			} else if ( is_numeric($this->input->get('id'))) {
                redirect("languages/edit?id={$language_id}&location={$this->input->get('location')}&file={$this->input->get('file')}");
            }

            redirect('languages/edit?id='. $language_id);
        }

		if ($language_id === '11') {
			$this->alert->set('info', $this->lang->line('alert_caution_edit'));
		}

		$title = (isset($language_info['name'])) ? $language_info['name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('languages')));

        $data['language_id'] 		= $language_info['language_id'];
		$data['name'] 				= $language_info['name'];
		$data['code'] 				= $language_info['code'];
		$data['idiom'] 			    = $language_info['idiom'];
		$data['can_delete'] 		= $language_info['can_delete'];
		$data['status'] 			= $language_info['status'];
		$data['no_photo'] 			= $this->Image_tool_model->resize('data/flags/no_flag.png');

		if ($this->input->post('image')) {
			$data['image']['path'] = $this->Image_tool_model->resize($this->input->post('image'));
			$data['image']['name'] = basename($this->input->post('image'));
			$data['image']['input'] = $this->input->post('image');
		} else if (!empty($language_info['image'])) {
			$data['image']['path'] = $this->Image_tool_model->resize($language_info['image']);
			$data['image']['name'] = basename($language_info['image']);
			$data['image']['input'] = $language_info['image'];
		} else {
			$data['image']['path'] = $this->Image_tool_model->resize('data/flags/no_flag.png');
			$data['image']['name'] = 'no_flag.png';
			$data['image']['input'] = 'data/flags/no_flag.png';
		}

        $data['close_edit_link'] = site_url('languages/edit?id='.$language_id);
        $data['lang_file'] = $this->input->get('file');
        $data['lang_location'] = $this->input->get('location');

        $data['lang_files'] = array();
        $data['lang_file_values'] = array();
        if (!empty($language_info['idiom']) AND $lang_files = list_lang_files($language_info['idiom'])) {
            foreach ($lang_files as $location => $files) {
                if (!empty($files)) {
                    foreach ($files as $file) {
                        $data['lang_files'][$location][] = array(
                            'name' => $file,
                            'edit' => site_url('languages/edit?id=' . $language_id . '&location=' . $location . '&file=' . $file),
                        );
                    }
                }
            }

            if (!empty($data['lang_file'])) {
                if ($lang_file_values = load_lang_file($this->input->get('file'), $language_info['idiom'], $this->input->get('location'))) {
                    foreach ($lang_file_values as $key => $value) {
                        $data['lang_file_values'][$key] = $value;
                    }
                }
            }
        }

        $data['languages'] = array();
        $results = $this->Languages_model->getLanguages();
        foreach ($results as $result) {
            $data['languages'][] = array(
                'idiom'	        =>	$result['idiom'],
                'name'			=>	$result['name'],
            );
        }

		$this->template->render('languages_edit', $data);
	}

	private function _saveLanguage() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($language_id = $this->Languages_model->saveLanguage($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Language '.$save_type));

                if ($save_type === 'added' AND $this->input->post('clone_language') === '1') {
                    if ( ! clone_language($this->input->post('idiom'), $this->input->post('language_to_clone'))) {
                        $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_cloned')));
                    }
                }

                if ($save_type === 'updated' AND $this->input->get('file')) {
                    if ( ! save_lang_file($this->input->get('file'), $this->input->post('idiom'), $this->input->get('location'), $this->input->post('lang'))) {
                        $this->alert->set('warning', sprintf($this->lang->line('alert_warning_file'), $save_type));
                    }
                }
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

            return $language_id;
		}
	}

	private function _deleteLanguage() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Languages_model->deleteLanguage($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Languages': 'Language';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('code', 'lang:label_code', 'xss_clean|trim|required|min_length[2]');
		$this->form_validation->set_rules('image', 'lang:label_image', 'xss_clean|trim|required|min_length[2]|max_length[32]');

        if ($this->input->post('clone_language') === '1') {
            $this->form_validation->set_rules('idiom', 'lang:label_idiom', 'xss_clean|trim|required|min_length[2]|max_length[32]');
            $this->form_validation->set_rules('language_to_clone', 'lang:label_language', 'xss_clean|trim|required|alpha');
        } else {
            $this->form_validation->set_rules('idiom', 'lang:label_idiom', 'xss_clean|trim|required|min_length[2]|max_length[32]|callback__valid_idiom');
        }

        $this->form_validation->set_rules('can_delete', 'lang:label_can_delete', 'xss_clean|trim|required|integer');
        $this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _valid_idiom($str) {
		$lang_files = list_lang_files($str);
        if (empty($lang_files['admin']) AND empty($lang_files['main']) AND empty($lang_files['module'])) {
            $this->form_validation->set_message('_valid_idiom', $this->lang->line('error_invalid_idiom'));
            return FALSE;
        } else {																				// else validation is not successful
            return TRUE;
        }
	}
}

/* End of file languages.php */
/* Location: ./admin/controllers/languages.php */