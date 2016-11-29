<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Banners extends Admin_Controller
{

	public $filter = [
		'filter_search' => '',
		'filter_status' => '',
	];

	public $default_sort = ['banner_id', 'DESC'];

	public $sort = ['name', 'type', 'status', 'banner_id'];

	public function __construct()
	{
		parent::__construct();

		$this->user->restrict('Admin.Banners');

		$this->load->model('Banners_model');
		$this->load->model('Image_tool_model');

		$this->lang->load('banners');
	}

	public function index()
	{
		if ($this->input->post('delete') AND $this->_deleteBanner() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => page_url() . '/edit']);
		$this->template->setButton($this->lang->line('button_delete'), ['class' => 'btn btn-danger', 'onclick' => 'confirmDelete();']);;
		$this->template->setButton($this->lang->line('button_modules'), ['class' => 'btn btn-default', 'href' => site_url('extensions')]);
		$this->template->setButton($this->lang->line('button_icon_filter'), ['class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button']);

		$data = $this->getList();

		$this->template->render('banners', $data);
	}

	public function edit()
	{
		if ($this->input->post() AND $banner_id = $this->_saveBanner()) {
			$this->redirect($banner_id);
		}

		$bannerModel = $this->Banners_model->findOrNew((int)$this->input->get('id'));

		$title = (isset($bannerModel->name)) ? $bannerModel->name : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
		$this->template->setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);
		$this->template->setButton($this->lang->line('button_modules'), ['class' => 'btn btn-default', 'href' => site_url('extensions')]);
		$this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('banners')]);

		$data = $this->getFrom($bannerModel);

		$this->template->render('banners_edit', $data);
	}

	public function getList()
	{
		$data = array_merge($this->getFilter(), $this->getSort());

		$data['banners'] = [];
		$results = $this->Banners_model->paginateWithFilter($this->getFilter());
		foreach ($results->list as $result) {
			$data['banners'][] = array_merge($result, [
				'edit' => $this->pageUrl($this->edit_url, ['id' => $result['banner_id']]),
			]);
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	protected function getFrom(Banners_model $bannerModel)
	{
		$data = $banner_info = $bannerModel->toArray();

		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($banner_info['banner_id'])) {
			$data['_action'] = $this->pageUrl($this->edit_url, ['id' => $banner_info['banner_id']]);
		}

		$banner_type = ($this->input->post('type')) ? $this->input->post('type') : $banner_info['type'];
		$data['type'] = !empty($banner_type) ? $banner_type : 'image';

		$data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png');

		if ($data['type'] === 'image') {
			$data['image'] = $bannerModel->getImageThumb(['no_photo' => $data['no_photo']]);
		} else {
			$data['carousels'] = $bannerModel->getCarouselThumbs(['no_photo' => $data['no_photo']]);
		}

		$data['types'] = ['image' => 'Image', 'carousel' => 'Carousel', 'custom' => 'Custom'];

		$this->load->model('Languages_model');
		$data['languages'] = $this->Languages_model->isEnabled()->dropdown('name');

		return $data;
	}

	protected function _saveBanner()
	{
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

	protected function _deleteBanner()
	{
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

	protected function validateForm()
	{
		$rules = [
			['name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[255]'],
			['type', 'lang:label_type', 'xss_clean|trim|required|alpha|max_length[8]'],
			['click_url', 'lang:label_click_url', 'xss_clean|trim|required|min_length[2]|max_length[255]'],
			['language_id', 'lang:label_language', 'xss_clean|trim|required|integer'],
			['status', 'lang:label_status', 'xss_clean|trim|required|integer'],
		];

		if ($this->input->post('type') === 'image') {
			$rules[] = ['alt_text', 'lang:label_alt_text', 'xss_clean|trim|required|min_length[2]|max_length[255]'];
			$rules[] = ['image_path', 'lang:label_image', 'xss_clean|trim|required'];
		}

		if ($this->input->post('type') === 'carousel' AND $this->input->post('carousels')) {
			$rules[] = ['alt_text', 'lang:label_alt_text', 'xss_clean|trim|required|min_length[2]|max_length[255]'];
			foreach ($this->input->post('carousels') as $key => $value) {
				$rules[] = ['carousels[' . $key . ']', 'lang:label_images', 'xss_clean|trim|required'];
			}
		}

		if ($this->input->post('type') === 'custom') {
			$rules[] = ['custom_code', 'lang:label_custom_code', 'xss_clean|trim|required'];
		}

		return $this->form_validation->set_rules($rules)->run();
	}
}

/* End of file Banners.php */
/* Location: ./admin/controllers/Banners.php */