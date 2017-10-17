<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Pages extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Site.Pages');

        $this->load->model('Pages_model');

        $this->load->library('permalink');
        $this->load->library('pagination');

        $this->lang->load('pages');
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

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deletePage() === TRUE) {
			redirect('pages');
		}

		$data['pages'] = array();
		$results = $this->Pages_model->getList($filter);
		foreach ($results as $result) {
			$data['pages'][] = array(
				'page_id'			=> $result['page_id'],
				'name'				=> $result['name'],
				'language'			=> $result['language_name'],
				'date_updated'		=> mdate('%d %M %y - %H:%i', strtotime($result['date_updated'])),
				'status'			=> ($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'preview' 			=> root_url('pages?page_id='. $result['page_id']),
				'edit' 				=> site_url('pages/edit?id='. $result['page_id'])
			);
		}

		$config['base_url'] 		= site_url('pages'.$url);
		$config['total_rows'] 		= $this->Pages_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('pages', $data);
	}

	public function edit() {
		$page_info = $this->Pages_model->getPage((int) $this->input->get('id'));

		if ($page_info) {
			$page_id = $page_info['page_id'];
			$data['_action']	= site_url('pages/edit?id='. $page_id);
		} else {
		    $page_id = 0;
			$data['_action']	= site_url('pages/edit');
		}

		$title = (isset($page_info['name'])) ? $page_info['name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('pages')));

		$this->template->setStyleTag(assets_url('js/summernote/summernote.css'), 'summernote-css');
		$this->template->setScriptTag(assets_url('js/summernote/summernote.min.js'), 'summernote-js');

		if ($this->input->post() AND $page_id = $this->_savePage()) {
			if ($this->input->post('save_close') === '1') {
				redirect('pages');
			}

			redirect('pages/edit?id='. $page_id);
		}

		$data['page_id'] 			= $page_info['page_id'];
		$data['language_id'] 		= $page_info['language_id'];
		$data['name'] 				= $page_info['name'];
		$data['page_title'] 		= $page_info['title'];
		$data['page_heading'] 		= $page_info['heading'];
		$data['content'] 			= html_entity_decode($page_info['content']);
		$data['meta_description'] 	= $page_info['meta_description'];
		$data['meta_keywords'] 		= $page_info['meta_keywords'];
		$data['layout_id'] 			= $page_info['layout_id'];
		$data['status'] 			= $page_info['status'];

		if ($this->input->post('navigation')) {
			$data['navigation'] = $this->input->post('navigation');
		} else if (!empty($page_info['navigation'])) {
			$data['navigation'] = unserialize($page_info['navigation']);
		} else {
			$data['navigation'] =  array();
		}

		$data['permalink'] = $this->permalink->getPermalink('page_id='.$page_info['page_id']);
        $data['permalink']['url'] = root_url();

        $this->load->model('Layouts_model');
		$data['layouts'] = array();
		$results = $this->Layouts_model->getLayouts();
		foreach ($results as $result) {
			$data['layouts'][] = array(
				'layout_id'		=> $result['layout_id'],
				'name'			=> $result['name']
			);
		}

		$this->load->model('Languages_model');
		$data['languages'] = array();
		$results = $this->Languages_model->getLanguages();
		foreach ($results as $result) {
			$data['languages'][] = array(
				'language_id'	=> $result['language_id'],
				'name'			=> $result['name']
			);
		}

		$data['menu_locations'] = array('Hide', 'All', 'Header', 'Footer', 'Module');

		$this->template->render('pages_edit', $data);
	}

	private function _savePage() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($page_id = $this->Pages_model->savePage($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Page '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $page_id;
		}
	}

	private function _deletePage() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Pages_model->deletePage($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Pages': 'Page';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('language_id', 'lang:label_language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('title', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('heading', 'lang:label_heading', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('permalink[permalink_id]', 'lang:label_permalink_id', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('permalink[slug]', 'lang:label_permalink_slug', 'xss_clean|trim|alpha_dash|max_length[255]');
		$this->form_validation->set_rules('content', 'lang:label_content', 'trim|required|min_length[2]|max_length[5028]');
		$this->form_validation->set_rules('meta_description', 'lang:label_meta_description', 'xss_clean|trim|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('meta_keywords', 'lang:label_meta_keywords', 'xss_clean|trim|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('layout_id', 'lang:label_layout', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('navigation[]', 'lang:label_navigation', 'xss_clean|trim|required');
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file pages.php */
/* Location: ./admin/controllers/pages.php */