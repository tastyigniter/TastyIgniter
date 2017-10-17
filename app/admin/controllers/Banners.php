<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Banners extends Admin_Controller {

	public function __construct() {
		parent::__construct();

        $this->user->restrict('Admin.Banners');

        $this->load->model('Banners_model');
        $this->load->model('Image_tool_model');

        $this->lang->load('banners');
    }

	public function index() {
		if ($this->input->post('delete') AND $this->_deleteBanner() === TRUE) {
			redirect('banners');
		}

		$this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_modules'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

		$data['banners'] = array();
		$results = $this->Banners_model->getBanners();
		foreach ($results as $result) {
			$data['banners'][] = array(
				'banner_id'		=> $result['banner_id'],
				'name'			=> $result['name'],
				'type'			=> $result['type'],
				'status'		=> ($result['status'] === '1') ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
				'edit' 			=> site_url('banners/edit?id=' . $result['banner_id'])
			);
		}

		$this->template->render('banners', $data);
	}

	public function edit() {
		$banner_info = $this->Banners_model->getBanner((int) $this->input->get('id'));

		if (!empty($banner_info)) {
			$banner_id = $banner_info['banner_id'];
			$data['_action']	= site_url('banners/edit?id='. $banner_id);
		} else {
		    $banner_id = 0;
			$data['_action']	= site_url('banners/edit');
		}

		$title = (isset($banner_info['name'])) ? $banner_info['name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_modules'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('banners')));

		if ($this->input->post() AND $banner_id = $this->_saveBanner()) {
			if ($this->input->post('save_close') === '1') {
				redirect('banners');
			}

			redirect('banners/edit?id='. $banner_id);
		}

        $data['banner_id'] 			= $banner_info['banner_id'];
		$data['name'] 				= $banner_info['name'];
		$data['type'] 				= ($this->input->post('type')) ? $this->input->post('type') : $banner_info['type'];
		$data['click_url'] 			= $banner_info['click_url'];
		$data['language_id'] 		= $banner_info['language_id'];
		$data['alt_text'] 			= $banner_info['alt_text'];
		$data['custom_code'] 		= $banner_info['custom_code'];
		$data['status'] 			= $banner_info['status'];
		$data['no_photo'] 			= $this->Image_tool_model->resize('data/no_photo.png');

		$data['type'] = !empty($data['type']) ? $data['type'] : 'image';
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

		$this->template->render('banners_edit', $data);
	}

    private function _saveBanner() {
    	if ($this->validateForm() === TRUE) {
            $save_type = (! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

            if ($banner_id = $this->Banners_model->saveBanner($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Banner '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $banner_id;
		}
	}

    private function _deleteBanner() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Banners_model->deleteBanner($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Banners': 'Banner';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('type', 'lang:label_type', 'xss_clean|trim|required|alpha|max_length[8]');
		$this->form_validation->set_rules('click_url', 'lang:label_click_url', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('language_id', 'lang:label_language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');

		if ($this->input->post('type') === 'image') {
			$this->form_validation->set_rules('alt_text', 'lang:label_alt_text', 'xss_clean|trim|required|min_length[2]|max_length[255]');
			$this->form_validation->set_rules('image_path', 'lang:label_image', 'xss_clean|trim|required');
		}

		if ($this->input->post('type') === 'carousel' AND $this->input->post('carousels')) {
			$this->form_validation->set_rules('alt_text', 'lang:label_alt_text', 'xss_clean|trim|required|min_length[2]|max_length[255]');
			foreach ($this->input->post('carousels') as $key => $value) {
				$this->form_validation->set_rules('carousels['.$key.']', 'lang:label_images', 'xss_clean|trim|required');
			}
		}

		if ($this->input->post('type') === 'custom') {
			$this->form_validation->set_rules('custom_code', 'lang:label_custom_code', 'xss_clean|trim|required');
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