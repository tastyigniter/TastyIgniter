<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Banners extends Admin_Controller
{

	public $list_filters = array(
		'filter_search' => '',
		'filter_status' => '',
		'sort_by'       => 'banner_id',
		'order_by'      => 'DESC',
	);

	public $sort_columns = array('name', 'type', 'status', 'banner_id');

	public function __construct() {
		parent::__construct();

		$this->user->restrict('Admin.Banners');

		$this->load->model('Banners_model');
		$this->load->model('Image_tool_model');

		$this->lang->load('banners');
	}

	public function index() {
		if ($this->input->post('delete') AND $this->_deleteBanner() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_modules'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('banners', $data);
	}

	public function edit() {
		if ($this->input->post() AND $banner_id = $this->_saveBanner()) {
			$this->redirect($banner_id);
		}

		$banner_info = $this->Banners_model->getBanner((int)$this->input->get('id'));

		$title = (isset($banner_info['name'])) ? $banner_info['name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_modules'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('banners')));

		$data = $this->getFrom($banner_info);

		$this->template->render('banners_edit', $data);
	}

	protected function getList() {
		$data = array_merge($this->list_filters, $this->sort_columns);
		$data['order_by_active'] = $this->list_filters['order_by'] . ' active';

		$results = $this->Banners_model->paginate($this->list_filters, $this->index_url);

		$data['banners'] = array();
		foreach ($results->list as $result) {
			$data['banners'][] = array_merge($result, array(
				'edit' => $this->pageUrl($this->edit_url, array('id' => $result['banner_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	protected function getFrom($banner_info = array()) {
		$data = $banner_info;

		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($banner_info['category_id'])) {
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $banner_info['banner_id']));
		}

		$data['banner_id'] = $banner_info['banner_id'];
		$data['name'] = $banner_info['name'];
		$data['type'] = ($this->input->post('type')) ? $this->input->post('type') : $banner_info['type'];
		$data['click_url'] = $banner_info['click_url'];
		$data['language_id'] = $banner_info['language_id'];
		$data['alt_text'] = $banner_info['alt_text'];
		$data['custom_code'] = $banner_info['custom_code'];
		$data['status'] = $banner_info['status'];
		$data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png');

		$data['type'] = !empty($data['type']) ? $data['type'] : 'image';

		$data['carousels'] = array();
		$data['image'] = array('name' => 'no_photo.png', 'path' => 'data/no_photo.png', 'url' => $data['no_photo']);
		if (!empty($banner_info['image_code'])) {
			$image = unserialize($banner_info['image_code']);
			if ($banner_info['type'] === 'image') {
				if (!empty($image['path'])) {
					$name = basename($image['path']);
					$data['image'] = array(
						'name' => $name,
						'path' => $image['path'],
						'url'  => $this->Image_tool_model->resize($image['path'], 120, 120),
					);
				}
			} else if ($banner_info['type'] === 'carousel') {
				if (!empty($image['paths']) AND is_array($image['paths'])) {
					foreach ($image['paths'] as $path) {
						$name = basename($path);
						$data['carousels'][] = array(
							'name' => $name,
							'path' => $path,
							'url'  => $this->Image_tool_model->resize($path, 120, 120),
						);
					}
				}
			}
		}

		$data['types'] = array('image' => 'Image', 'carousel' => 'Carousel', 'custom' => 'Custom');

		$this->load->model('Languages_model');
		$data['languages'] = $this->Languages_model->isEnabled()->dropdown('language_id', 'name');

		return $data;
	}

	protected function _saveBanner() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($banner_id = $this->Banners_model->saveBanner($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Banner ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $banner_id;
		}
	}

	protected function _deleteBanner() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Banners_model->deleteBanner($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Banners' : 'Banner';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules = array(
			array('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[255]'),
			array('type', 'lang:label_type', 'xss_clean|trim|required|alpha|max_length[8]'),
			array('click_url', 'lang:label_click_url', 'xss_clean|trim|required|min_length[2]|max_length[255]'),
			array('language_id', 'lang:label_language', 'xss_clean|trim|required|integer'),
			array('status', 'lang:label_status', 'xss_clean|trim|required|integer'),
		);

		if ($this->input->post('type') === 'image') {
			$rules[] = array('alt_text', 'lang:label_alt_text', 'xss_clean|trim|required|min_length[2]|max_length[255]');
			$rules[] = array('image_path', 'lang:label_image', 'xss_clean|trim|required');
		}

		if ($this->input->post('type') === 'carousel' AND $this->input->post('carousels')) {
			$rules[] = array('alt_text', 'lang:label_alt_text', 'xss_clean|trim|required|min_length[2]|max_length[255]');
			foreach ($this->input->post('carousels') as $key => $value) {
				$rules[] = array('carousels[' . $key . ']', 'lang:label_images', 'xss_clean|trim|required');
			}
		}

		if ($this->input->post('type') === 'custom') {
			$rules[] = array('custom_code', 'lang:label_custom_code', 'xss_clean|trim|required');
		}
		
		return $this->Banners_model->set_rules($rules)->validate();
	}
}

/* End of file Banners.php */
/* Location: ./admin/controllers/Banners.php */