<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_banners_module extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Layouts_model');
        $this->load->model('Banners_model');
        $this->lang->load('banners_module/banners_module');
    }

	public function index($data = array()) {
        $this->user->restrict('Module.BannersModule');

        if (!empty($data)) {
            $data['title'] = (isset($data['title'])) ? $data['title'] : 'Banner Module';

            $this->template->setTitle('Module: ' . $data['title']);
            $this->template->setHeading('Module: ' . $data['title']);
            $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setButton($this->lang->line('button_banners'), array('class' => 'btn btn-default', 'href' => site_url('banners/edit')));
            $this->template->setBackButton('btn btn-back', site_url('extensions'));

            $ext_data = array();
            if (!empty($data['ext_data']) AND is_array($data['ext_data'])) {
                $ext_data = $data['ext_data'];
            }

            if ($this->input->post('banners')) {
                $ext_data['banners'] = $this->input->post('banners');
            }

            $this->load->model('Image_tool_model');

            $data['module_banners'] = array();
            if (!empty($ext_data['banners'])) {
                foreach ($ext_data['banners'] as $banner) {
                    $data['module_banners'][] = array(
                        'banner_id'	=> $banner['banner_id'],
                        'width' 	=> $banner['width'],
                        'height'	=> $banner['height']
                    );
                }
            }

            $data['banners'] = array();
            $results = $this->Banners_model->getBanners();
            foreach ($results as $result) {
                $data['banners'][] = array(
                    'banner_id'       => $result['banner_id'],
                    'name'			=> $result['name']
                );
            }

            if ($this->input->post() AND $this->_updateModule() === TRUE) {
                if ($this->input->post('save_close') === '1') {
                    redirect('extensions');
                }

                redirect('extensions/edit?action=edit&name=banners_module');
            }

            return $this->load->view('banners_module/admin_banners_module', $data, TRUE);
        }
	}

	private function _updateModule() {
    	if ($this->validateForm() === TRUE) {
			$update = array();

			$update['type'] 			= 'module';
			$update['name'] 			= $this->input->get('name');
			$update['title'] 			= $this->input->post('title');
			$update['extension_id'] 	= (int) $this->input->get('id');
			$update['data']['banners'] 	= $this->input->post('banners');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->alert->set('success', 'Banners module updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

 	private function validateForm() {
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|trim|required|min_length[2]|max_length[128]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file banners_module.php */
/* Location: ./extensions/banners_module/controllers/banners_module.php */