<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Pages extends Admin_Controller
{

	public $filter = array(
		'filter_search' => '',
		'filter_status' => '',
	);

	public $default_sort = array('page_id', 'DESC');

	public $sort = array('order_id', 'location_name', 'first_name', 'status_name',
		'order_type', 'payment', 'order_total', 'order_time', 'date_added');

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Site.Pages');

		$this->load->model('Pages_model');

		$this->load->library('permalink');

		$this->lang->load('pages');
	}

	public function index() {
		if ($this->input->post('delete') AND $this->_deletePage() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('pages', $data);
	}

	public function edit() {
		if ($this->input->post() AND $page_id = $this->_savePage()) {
			$this->redirect($page_id);
		}

		$page_info = $this->Pages_model->getPage((int)$this->input->get('id'));

		$title = (isset($page_info['name'])) ? $page_info['name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('pages')));

		$this->template->setStyleTag(assets_url('js/summernote/summernote.css'), 'summernote-css');
		$this->template->setScriptTag(assets_url('js/summernote/summernote.min.js'), 'summernote-js');

		$data = $this->getForm($page_info);

		$this->template->render('pages_edit', $data);
	}

	public function getList() {
		$data = array_merge($this->getFilter(), $this->getSort());

		$data['pages'] = array();
		$results = $this->Pages_model->paginate($this->getFilter());
		foreach ($results->list as $result) {
			$data['pages'][] = array_merge($result, array(
				'preview' => root_url('pages?page_id=' . $result['page_id']),
				'edit'    => $this->pageUrl($this->edit_url, array('id' => $result['page_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm($page_info) {
		$data = $page_info;

		$page_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($page_info['page_id'])) {
			$page_id = $page_info['page_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $page_id));
		}

		$data['page_id'] = $page_info['page_id'];
		$data['language_id'] = $page_info['language_id'];
		$data['name'] = $page_info['name'];
		$data['page_title'] = $page_info['title'];
		$data['page_heading'] = $page_info['heading'];
		$data['content'] = html_entity_decode($page_info['content']);
		$data['meta_description'] = $page_info['meta_description'];
		$data['meta_keywords'] = $page_info['meta_keywords'];
		$data['layout_id'] = $page_info['layout_id'];
		$data['status'] = $page_info['status'];

		$data['navigation'] = array();
		if ($this->input->post('navigation')) {
			$data['navigation'] = $this->input->post('navigation');
		} else if (!empty($page_info['navigation'])) {
			$data['navigation'] = unserialize($page_info['navigation']);
		}

		$data['permalink'] = $this->permalink->getPermalink('page_id=' . $page_info['page_id']);
		$data['permalink']['url'] = root_url();

		$this->load->model('Layouts_model');
		$data['layouts'] = $this->Layouts_model->dropdown('name');

		$this->load->model('Languages_model');
		$data['languages'] = $this->Languages_model->isEnabled()->dropdown('name');

		$data['menu_locations'] = array('Hide', 'All', 'Header', 'Footer', 'Module');

		return $data;
	}

	protected function _savePage() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($page_id = $this->Pages_model->savePage($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Page ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $page_id;
		}
	}

	protected function _deletePage() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Pages_model->deletePage($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Pages' : 'Page';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules[] = array('language_id', 'lang:label_language', 'xss_clean|trim|required|integer');
		$rules[] = array('title', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$rules[] = array('heading', 'lang:label_heading', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$rules[] = array('permalink[permalink_id]', 'lang:label_permalink_id', 'xss_clean|trim|integer');
		$rules[] = array('permalink[slug]', 'lang:label_permalink_slug', 'xss_clean|trim|alpha_dash|max_length[255]');
		$rules[] = array('content', 'lang:label_content', 'trim|required|min_length[2]|max_length[5028]');
		$rules[] = array('meta_description', 'lang:label_meta_description', 'xss_clean|trim|min_length[2]|max_length[255]');
		$rules[] = array('meta_keywords', 'lang:label_meta_keywords', 'xss_clean|trim|min_length[2]|max_length[255]');
		$rules[] = array('layout_id', 'lang:label_layout', 'xss_clean|trim|integer');
		$rules[] = array('navigation[]', 'lang:label_navigation', 'xss_clean|trim|required');
		$rules[] = array('status', 'lang:label_status', 'xss_clean|trim|required|integer');

		return $this->Pages_model->set_rules($rules)->validate();
	}
}

/* End of file Pages.php */
/* Location: ./admin/controllers/Pages.php */