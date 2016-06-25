<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Categories extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Categories');

        $this->load->model('Categories_model'); // load the menus model
        $this->load->model('Image_tool_model');

        $this->load->library('permalink');
        $this->load->library('pagination');

        $this->lang->load('categories');
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
			$filter['sort_by'] = $data['sort_by'] = 'category_id';
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

		if ($this->input->post('delete') AND $this->_deleteCategory() === TRUE) {
			redirect('categories');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('categories'.$url.'sort_by=name&order_by='.$order_by);
		$data['sort_priority'] 		= site_url('categories'.$url.'sort_by=priority&order_by='.$order_by);
		$data['sort_id'] 			= site_url('categories'.$url.'sort_by=category_id&order_by='.$order_by);

		$results = $this->Categories_model->getList($filter);
		$data['categories'] = array();
		foreach ($results as $result) {
			//load categories data into array
			$data['categories'][] = array(
				'category_id' 			=> $result['category_id'],
                'name' 					=> $result['name'],
                'parent_id' 			=> $result['parent_id'],
                'priority' 			    => $result['priority'],
				'description' 			=> substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'status'		        => ($result['status'] === '1') ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
				'edit' 					=> site_url('categories/edit?id=' . $result['category_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('categories'.$url);
		$config['total_rows'] 		= $this->Categories_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('categories', $data);
	}

	public function edit() {
		$category_info = $this->Categories_model->getCategory((int) $this->input->get('id'));

		if ($category_info) {
			$category_id = $category_info['category_id'];
			$data['_action']	= site_url('categories/edit?id='. $category_id);
		} else {
		    $category_id = 0;
			$data['_action']	= site_url('categories/edit');
		}

        $title = (isset($category_info['name'])) ? $category_info['name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('categories')));

		if ($this->input->post() AND $category_id = $this->_saveCategory()) {
			if ($this->input->post('save_close') === '1') {
				redirect('categories');
			}

			redirect('categories/edit?id='. $category_id);
		}

        $data['category_id'] 		= $category_info['category_id'];
		$data['name'] 				= $category_info['name'];
		$data['parent_id'] 			= $category_info['parent_id'];
		$data['description'] 		= $category_info['description'];
		$data['priority'] 		    = $category_info['priority'];
		$data['status'] 		    = $category_info['status'];
		$data['no_image'] 			= $this->Image_tool_model->resize('data/no_photo.png');

		$data['permalink'] = $this->permalink->getPermalink('category_id='.$category_info['category_id']);

        if ($this->input->post('image')) {
			$data['image'] = $this->input->post('image');
			$data['image_name'] = basename($this->input->post('image'));
			$data['image_url'] = $this->Image_tool_model->resize($this->input->post('image'));
		} else if (!empty($category_info['image'])) {
			$data['image'] = $category_info['image'];
			$data['image_name'] = basename($category_info['image']);
			$data['image_url'] = $this->Image_tool_model->resize($category_info['image']);
		} else {
			$data['image'] = '';
			$data['image_name'] = '';
			$data['image_url'] = $data['no_image'];
		}

		$data['categories'] = array();
		$results = $this->Categories_model->getCategories();
		foreach ($results as $result) {
			$data['categories'][] = array(
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['name']
			);
		}

		$this->template->render('categories_edit', $data);
	}

	private function _saveCategory() {
    	if ($this->validateForm() === TRUE) {
            $save_type = (! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($category_id = $this->Categories_model->saveCategory($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Category '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $category_id;
		}
	}

    private function _deleteCategory() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Categories_model->deleteCategory($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Categories': 'Category';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

    private function validateForm() {
		$this->form_validation->set_rules('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('description', 'lang:label_description', 'xss_clean|trim|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('permalink[permalink_id]', 'lang:label_permalink_id', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('permalink[slug]', 'lang:label_permalink_slug', 'xss_clean|trim|alpha_dash|max_length[255]');
		$this->form_validation->set_rules('parent_id', 'lang:label_parent', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image', 'lang:label_image', 'xss_clean|trim');
		$this->form_validation->set_rules('priority', 'lang:label_priority', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file categories.php */
/* Location: ./admin/controllers/categories.php */