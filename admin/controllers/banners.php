<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Banners extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Design_model');
		$this->load->model('Settings_model');
		$this->load->model('Image_tool_model');
	}

	public function index() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'banners')) {
  			redirect('permission');
		}

		$this->template->setTitle('Banners');
		$this->template->setHeading('Banners');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));
		$this->template->setButton('Modules', array('class' => 'btn btn-default pull-right', 'href' => site_url('extensions')));

		$data['text_empty'] 		= 'There are no banners available.';

		$data['banners'] = array();
		$results = $this->Design_model->getBanners();
		foreach ($results as $result) {
			$data['banners'][] = array(
				'banner_id'		=> $result['banner_id'],
				'name'			=> $result['name'],
				'type'			=> $result['type'],
				'status'		=> ($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 			=> site_url('banners/edit?id=' . $result['banner_id'])
			);
		}

		if ($this->input->post('delete') AND $this->_deleteBanner() === TRUE) {
			redirect('banners');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('banners', $data);
	}

	public function edit() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'banners')) {
  			redirect('permission');
		}

		$banner_info = $this->Design_model->getBanner((int) $this->input->get('id'));

		if ($banner_info) {
			$banner_id = $banner_info['banner_id'];
			$data['action']	= site_url('banners/edit?id='. $banner_id);
		} else {
		    $banner_id = 0;
			$data['action']	= site_url('banners/edit');
		}

		$title = (isset($banner_info['name'])) ? $banner_info['name'] : 'New';
		$this->template->setTitle('Banner: '. $title);
		$this->template->setHeading('Banner: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('banners'));

		$data['banner_id'] 			= $banner_info['banner_id'];
		$data['name'] 				= $banner_info['name'];
		$data['type'] 				= ($this->input->post('type')) ? $this->input->post('type') : $banner_info['type'];
		$data['click_url'] 			= $banner_info['click_url'];
		$data['language_id'] 		= $banner_info['language_id'];
		$data['alt_text'] 			= $banner_info['alt_text'];
		$data['custom_code'] 		= $banner_info['custom_code'];
		$data['status'] 			= $banner_info['status'];
		$data['no_photo'] 			= $this->Image_tool_model->resize('data/no_photo.png');

		$data['image_height'] = $data['image_width'] = $data['carousel_height'] = $data['carousel_width'] = '';
		$data['image'] = array('name' => 'no_photo.png', 'path' => 'data/no_photo.png', 'url' => $data['no_photo']);
		$data['carousels'] = array();

		if (!empty($banner_info['image_code'])) {
			$image = unserialize($banner_info['image_code']);
			if ($banner_info['type'] === 'image') {
				if (!empty($image['path'])) {
					$name = basename($image['path']);
					$data['image'] = array(
						'name'		=> $name,
						'path'		=> $image['path'],
						'url'		=> $this->Image_tool_model->resize($image['path'], 120, 120)
					);
				}
			} else if ($banner_info['type'] === 'carousel') {
				if (!empty($image['paths']) AND is_array($image['paths'])) {
					foreach ($image['paths'] as $path) {
						$name = basename($path);
						$data['carousels'][] = array(
							'name'		=> $name,
							'path'		=> $path,
							'url'		=> $this->Image_tool_model->resize($path, 120, 120)
						);
					}
				}
			}

			$data['image_height'] 	= $image['height'];
			$data['image_width'] 	= $image['width'];
		}

		$data['types'] = array(
			'image'		=> 'Image',
			'carousel'	=> 'Carousel',
			'custom'	=> 'Custom'
		);

		$this->load->model('Languages_model');
		$data['languages'] = array();
		$results = $this->Languages_model->getLanguages();
		foreach ($results as $result) {
			$data['languages'][] = array(
				'language_id'	=> $result['language_id'],
				'name'			=> $result['name']
			);
		}

		if ($this->input->post() AND $this->_addBanner() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {
				redirect('banners/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('banners');
			}
		}

		if ($this->input->post() AND $this->_updateBanner() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('banners');
			}

			redirect('banners/edit?id='. $banner_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('banners_edit', $data);
	}

	public function _addBanner() {
    	if ( ! $this->user->hasPermissions('modify', 'banners')) {
			$this->alert->set('warning', 'Warning: You do not have permission to add!');
  			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$add = array();

			$add['name'] 			= $this->input->post('name');
			$add['type'] 			= $this->input->post('type');
			$add['click_url'] 		= $this->input->post('click_url');
			$add['language_id'] 	= $this->input->post('language_id');
			$add['alt_text'] 		= $this->input->post('alt_text');
			$add['custom_code'] 	= $this->input->post('custom_code');
			$add['status'] 			= $this->input->post('status');

			if ($this->input->post('type') !== 'custom') {
				$add['image_code'] = array();
				$add['image_code']['height'] = $this->input->post('image_height');
				$add['image_code']['width'] = $this->input->post('image_width');

				if ($this->input->post('image_path') AND $this->input->post('type') === 'image') {
					$add['image_code']['path'] = $this->input->post('image_path');
				}

				if ($this->input->post('carousels') AND $this->input->post('type') === 'carousel') {
					foreach ($this->input->post('carousels') as $key => $value) {
						$add['image_code']['paths'][] = $value;
					}
				}
			}

			if ($_POST['insert_id'] = $this->Design_model->addBanner($add)) {
				$this->alert->set('success', 'Banner added sucessfully.');
			} else {
				$this->alert->set('warning', 'An error occured, nothing added.');
			}

			return TRUE;
		}
	}

	public function _updateBanner() {
    	if ( ! $this->user->hasPermissions('modify', 'banners')) {
			$this->alert->set('warning', 'Warning: You do not have permission to update!');
  			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$update = array();

			$update['banner_id'] 	= $this->input->get('id');
			$update['name'] 		= $this->input->post('name');
			$update['type'] 		= $this->input->post('type');
			$update['click_url'] 	= $this->input->post('click_url');
			$update['language_id'] 	= $this->input->post('language_id');
			$update['alt_text'] 	= $this->input->post('alt_text');
			$update['status'] 		= $this->input->post('status');

			if ($this->input->post('type') !== 'custom') {
				$update['image_code'] = array();
				$update['image_code']['height'] = $this->input->post('image_height');
				$update['image_code']['width'] = $this->input->post('image_width');

				if ($this->input->post('image_path') AND $this->input->post('type') === 'image') {
					$update['image_code']['path'] = $this->input->post('image_path');
				}

				if ($this->input->post('carousels') AND $this->input->post('type') === 'carousel') {
					foreach ($this->input->post('carousels') as $key => $value) {
						$update['image_code']['paths'][] = $value;
					}
				}
			} else {
				$update['custom_code'] 	= $this->input->post('custom_code');
			}

			if ($this->Design_model->updateBanner($update)) {
				$this->alert->set('success', 'Banner updated sucessfully.');
			} else {
				$this->alert->set('warning', 'An error occured, nothing added.');
			}

			return TRUE;
		}
	}

	public function _deleteBanner() {
    	if ( ! $this->user->hasPermissions('modify', 'banners')) {
			$this->alert->set('warning', 'Warning: You do not have permission to delete!');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Design_model->deleteBanner($value);
			}

			$this->alert->set('success', 'Banner deleted sucessfully!');
		}

		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('type', 'Type', 'xss_clean|trim|required|aplha|max_length[8]');
		$this->form_validation->set_rules('click_url', 'Click URL', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('language_id', 'Language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('alt_text', 'Alternative Text', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->input->post('type') === 'image') {
			$this->form_validation->set_rules('image_path', 'Image', 'xss_clean|trim|required');
		}

		if ($this->input->post('type') === 'carousel' AND $this->input->post('carousels')) {
			foreach ($this->input->post('carousels') as $key => $value) {
				$this->form_validation->set_rules('carousels['.$key.']', 'Images', 'xss_clean|trim|required');
			}
		}

		if ($this->input->post('type') !== 'custom') {
			$this->form_validation->set_rules('image_height', 'Dimension height', 'xss_clean|trim|required|integer');
			$this->form_validation->set_rules('image_width', 'Dimension width', 'xss_clean|trim|required|integer');
		}

		if ($this->input->post('type') === 'custom') {
			$this->form_validation->set_rules('custom_code', 'Name', 'xss_clean|trim|required');
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file banners.php */
/* Location: ./admin/controllers/banners.php */