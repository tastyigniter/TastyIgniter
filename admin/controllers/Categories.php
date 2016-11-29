<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Categories extends Admin_Controller
{

	public $filter = [
		'filter_search' => '',
		'filter_status' => '',
	];

	public $default_sort = ['category_id', 'DESC'];

	public $sort = ['name', 'priority', 'category_id'];

	public function __construct()
	{
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Categories');

		$this->load->model('Categories_model'); // load the menus model
		$this->load->model('Image_tool_model');

		$this->load->library('permalink');

		$this->lang->load('categories');
	}

	public function index()
	{
		if ($this->input->post('delete') AND $this->_deleteCategory() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => page_url() . '/edit']);
		$this->template->setButton($this->lang->line('button_delete'), ['class' => 'btn btn-danger', 'onclick' => 'confirmDelete();']);;
		$this->template->setButton($this->lang->line('button_icon_filter'), ['class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button']);

		$data = $this->getList();

		$this->template->render('categories', $data);
	}

	public function edit()
	{
		if ($this->input->post() AND $category_id = $this->_saveCategory()) {
			$this->redirect($category_id);
		}

		$categoryModel = $this->Categories_model->findOrNew((int)$this->input->get('id'));

		$title = (isset($categoryModel->name)) ? $categoryModel->name : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
		$this->template->setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);
		$this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('categories')]);

		$data = $this->getForm($categoryModel);

		$this->template->render('categories_edit', $data);
	}

	public function getList()
	{
		$data = array_merge($this->getFilter(), $this->getSort());

		$data['categories'] = [];
		$results = $this->Categories_model->paginateWithFilter($this->getFilter());
		foreach ($results->list as $result) {
			$data['categories'][] = array_merge($result, [
				'edit' => $this->pageUrl($this->edit_url, ['id' => $result['category_id']]),
			]);
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm(Categories_model $categoryModel)
	{
		$data = $category_info = $categoryModel->toArray();

		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($category_info['category_id'])) {
			$data['_action'] = $this->pageUrl($this->edit_url, ['id' => $category_info['category_id']]);
		}

		$data['no_image'] = $this->Image_tool_model->resize('data/no_photo.png');

		$data['permalink'] = $this->permalink->getPermalink('category_id=' .
			(isset($category_info['category_id']) ? $category_info['category_id'] : null));

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

	protected function _saveCategory()
	{
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

	protected function _deleteCategory()
	{
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

	protected function validateForm()
	{
		$rules = [
			['name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]'],
			['description', 'lang:label_description', 'xss_clean|trim|min_length[2]|max_length[1028]'],
			['permalink[permalink_id]', 'lang:label_permalink_id', 'xss_clean|trim|integer'],
			['permalink[slug]', 'lang:label_permalink_slug', 'xss_clean|trim|alpha_dash|max_length[255]'],
			['parent_id', 'lang:label_parent', 'xss_clean|trim|integer'],
			['image', 'lang:label_image', 'xss_clean|trim'],
			['priority', 'lang:label_priority', 'xss_clean|trim|required|integer'],
			['status', 'lang:label_status', 'xss_clean|trim|required|integer'],
		];

		return $this->form_validation->set_rules($rules)->run();
	}
}

/* End of file Categories.php */
/* Location: ./admin/controllers/Categories.php */