<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Categories extends Admin_Controller
{

	public $list_filters = array(
		'filter_search' => '',
		'filter_status' => '',
		'sort_by'       => 'category_id',
		'order_by'      => 'DESC',
	);

	public $sort_columns = array('name', 'priority', 'category_id');

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Categories');

        $this->load->model('Categories_model'); // load the menus model
        $this->load->model('Image_tool_model');

		$this->load->library('permalink');

		$this->lang->load('categories');
	}

	public function index() {
		if ($this->input->post('delete') AND $this->_deleteCategory() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('categories', $data);
	}

	public function edit() {
		if ($this->input->post() AND $category_id = $this->_saveCategory()) {
			$this->redirect($category_id);
		}

		$category_info = $this->Categories_model->getCategory((int)$this->input->get('id'));

		$title = (isset($category_info['name'])) ? $category_info['name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('categories')));

		$data = $this->getForm($category_info);

		$this->template->render('categories_edit', $data);
	}

	protected function getList() {
		$data = array_merge($this->list_filters, $this->sort_columns);
		$data['order_by_active'] = $this->list_filters['order_by'] . ' active';

		$data['categories'] = array();
		$results = $this->Categories_model->paginate($this->list_filters, $this->index_url);
		foreach ($results->list as $result) {
			$data['categories'][] = array_merge($result, array(
				'description' => strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')),
				'edit'        => $this->pageUrl($this->edit_url, array('id' => $result['category_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	protected function getForm($category_info = array()) {
		$data = $category_info;

		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($category_info['category_id'])) {
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $category_info['category_id']));
		}

		$data['category_id'] = $category_info['category_id'];
		$data['name'] = $category_info['name'];
		$data['parent_id'] = $category_info['parent_id'];
		$data['description'] = $category_info['description'];
		$data['priority'] = $category_info['priority'];
		$data['status'] = $category_info['status'];
		$data['no_image'] = $this->Image_tool_model->resize('data/no_photo.png');

		$data['permalink'] = $this->permalink->getPermalink('category_id=' . $category_info['category_id']);

		$data['image'] = '';
		$data['image_name'] = '';
		$data['image_url'] = $data['no_image'];
		if ($this->input->post('image')) {
			$data['image'] = $this->input->post('image');
			$data['image_name'] = basename($this->input->post('image'));
			$data['image_url'] = $this->Image_tool_model->resize($this->input->post('image'));
		} else if (!empty($category_info['image'])) {
			$data['image'] = $category_info['image'];
			$data['image_name'] = basename($category_info['image']);
			$data['image_url'] = $this->Image_tool_model->resize($category_info['image']);
		}

		$data['categories'] = $this->Categories_model->isEnabled()->dropdown('name');

		return $data;
	}

	protected function _saveCategory() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($category_id = $this->Categories_model->saveCategory($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Category ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $category_id;
		}
	}

	protected function _deleteCategory() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Categories_model->deleteCategory($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Categories' : 'Category';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules = [
			array('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]'),
			array('description', 'lang:label_description', 'xss_clean|trim|min_length[2]|max_length[1028]'),
			array('permalink[permalink_id]', 'lang:label_permalink_id', 'xss_clean|trim|integer'),
			array('permalink[slug]', 'lang:label_permalink_slug', 'xss_clean|trim|alpha_dash|max_length[255]'),
			array('parent_id', 'lang:label_parent', 'xss_clean|trim|integer'),
			array('image', 'lang:label_image', 'xss_clean|trim'),
			array('priority', 'lang:label_priority', 'xss_clean|trim|required|integer'),
			array('status', 'lang:label_status', 'xss_clean|trim|required|integer'),
		];

		return $this->Categories_model->set_rules($rules)->validate();
	}
}

/* End of file Categories.php */
/* Location: ./admin/controllers/Categories.php */