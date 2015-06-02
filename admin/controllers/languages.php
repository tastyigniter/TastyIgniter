<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Languages extends Admin_Controller {

	public function __construct() {
		parent::__construct();
        $this->user->restrict('Site.Languages');
        $this->load->library('pagination');
		$this->load->model('Languages_model');
		$this->load->model('Image_tool_model');
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

		$this->template->setTitle('Languages');
		$this->template->setHeading('Languages');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no languages available.';

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
				'image'				=>	(!empty($result['image'])) ? $this->Image_tool_model->resize($result['image']) : $this->Image_tool_model->resize('data/flags/no_flag.png'),
				'status'			=> ($result['status'] === '1') ? 'Enabled' : 'Disabled',
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

		if ($this->input->post('delete') AND $this->_deleteLanguage() === TRUE) {
			redirect('languages');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('languages', $data);
	}

	public function edit() {
		$language_info = $this->Languages_model->getLanguage((int) $this->input->get('id'));

		if ($language_info) {
			$language_id = $language_info['language_id'];
			$data['_action']	= site_url('languages/edit?id='. $language_id);
		} else {
		    $language_id = 0;
			$data['_action']	= site_url('languages/edit');
		}

		if ($this->input->post() AND $language_id = $this->_saveLanguage()) {
			if ($this->input->post('save_close') === '1') {
				redirect('languages');
			}

			redirect('languages/edit?id='. $language_id);
		}

		$title = (isset($language_info['name'])) ? $language_info['name'] : 'New';
		$this->template->setTitle('Language: '. $title);
		$this->template->setHeading('Language: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('languages'));

        $this->template->setStyleTag(root_url('assets/js/fancybox/jquery.fancybox.css'), 'jquery-fancybox-css');
        $this->template->setScriptTag(root_url("assets/js/fancybox/jquery.fancybox.js"), 'jquery-fancybox-js');

        $data['language_id'] 		= $language_info['language_id'];
		$data['name'] 				= $language_info['name'];
		$data['code'] 				= $language_info['code'];
		$data['directory'] 			= $language_info['directory'];
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

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('languages_edit', $data);
	}

	private function _saveLanguage() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? 'added' : 'updated';

			if ($language_id = $this->Languages_model->saveLanguage($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', 'Language ' . $save_type . ' successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing ' . $save_type . '.');
			}

            return $language_id;
		}
	}

	private function _deleteLanguage() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Languages_model->deleteLanguage($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Languages': 'Language';
                $this->alert->set('success', $prefix.' deleted successfully.');
            } else {
                $this->alert->set('warning', 'An error occurred, nothing deleted.');
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('code', 'Language Code', 'xss_clean|trim|required|min_length[2]');
		$this->form_validation->set_rules('image', 'Image Icon', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('directory', 'Directory Name', 'xss_clean|trim|required|min_length[2]|max_length[32]|callback__valid_directory');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _valid_directory($str) {
		if (!file_exists(APPPATH .'language/'. $str)) {
			$this->form_validation->set_message('_valid_directory', 'The specified directory name does not exist in the language folder');
			return FALSE;
		} else {																				// else validation is successful
			return TRUE;
		}
	}
}

/* End of file languages.php */
/* Location: ./admin/controllers/languages.php */