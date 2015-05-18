<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Pages extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
        $this->load->library('permalink');
		$this->load->library('pagination');
		$this->load->model('Pages_model');
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

		$this->template->setTitle('Pages');
		$this->template->setHeading('Pages');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no pages available.';

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

		$config['base_url'] 		= site_url('pages').$url;
		$config['total_rows'] 		= $this->Pages_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deletePage() === TRUE) {
			redirect('pages');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('pages', $data);
	}

	public function edit() {
		$page_info = $this->Pages_model->getPage((int) $this->input->get('id'));

		if ($page_info) {
			$page_id = $page_info['page_id'];
			$data['action']	= site_url('pages/edit?id='. $page_id);
		} else {
		    $page_id = 0;
			$data['action']	= site_url('pages/edit');
		}

		$title = (isset($page_info['name'])) ? $page_info['name'] : 'New';
		$this->template->setTitle('Page: '. $title);
		$this->template->setHeading('Page: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('pages'));
        $this->template->setScriptTag(root_url('assets/js/tinymce/tinymce.min.js'), 'tinymce-js', '111');

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

        $this->load->model('Design_model');
		$data['layouts'] = array();
		$results = $this->Design_model->getLayouts();
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

		if ($this->input->post() AND $this->_addPage() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {
				redirect('pages/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('pages');
			}
		}

		if ($this->input->post() AND $this->_updatePage() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('pages');
			}

			redirect('pages/edit?id='. $page_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('pages_edit', $data);
	}

	public function _addPage() {
    	if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$add = array();

			$add['name'] 				= $this->input->post('name');
			$add['title'] 				= $this->input->post('title');
			$add['heading'] 			= $this->input->post('heading');
			$add['content'] 			= $this->input->post('content');
			$add['permalink'] 			= $this->input->post('permalink');
			$add['meta_description'] 	= $this->input->post('meta_description');
			$add['meta_keywords'] 		= $this->input->post('meta_keywords');
			$add['language_id'] 		= $this->input->post('language_id');
			$add['layout_id'] 			= $this->input->post('layout_id');
			$add['date_added'] 			= mdate('%Y-%m-%d %H:%i:%s', time());
			$add['date_updated'] 		= mdate('%Y-%m-%d %H:%i:%s', time());
			$add['navigation'] 			= $this->input->post('navigation');
			$add['status'] 				= $this->input->post('status');

			if ($_POST['insert_id'] = $this->Pages_model->addPage($add)) {
				$this->alert->set('success', 'Page added successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

	public function _updatePage() {
    	if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$update = array();

			$update['page_id'] 				= $this->input->get('id');
			$update['name'] 				= $this->input->post('name');
			$update['title'] 				= $this->input->post('title');
			$update['heading'] 				= $this->input->post('heading');
			$update['content'] 				= $this->input->post('content');
			$update['meta_description'] 	= $this->input->post('meta_description');
			$update['meta_keywords'] 		= $this->input->post('meta_keywords');
			$update['layout_id'] 			= $this->input->post('layout_id');
			$update['language_id'] 			= $this->input->post('language_id');
			$update['permalink'] 			= $this->input->post('permalink');
			$update['navigation'] 			= $this->input->post('navigation');
			$update['date_updated'] 		= mdate('%Y-%m-%d %H:%i:%s', time());
			$update['status'] 				= $this->input->post('status');

			if ($this->Pages_model->updatePage($update)) {
				$this->alert->set('success', 'Page updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

	public function _deletePage() {
    	if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Pages_model->deletePage($value);
			}

			$this->alert->set('success', 'Page(s) deleted successfully!');
		}

		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('language_id', 'Language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('title', 'Title', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('heading', 'Heading', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('permalink[permalink_id]', 'Permalink ID', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('permalink[slug]', 'Permalink Slug', 'xss_clean|trim|alpha_dash|max_length[255]');
		$this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[2]|max_length[5028]');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'xss_clean|trim|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'xss_clean|trim|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('layout_id', 'Layout', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('navigation[]', 'Navigation', 'xss_clean|trim|required');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file pages.php */
/* Location: ./admin/controllers/pages.php */