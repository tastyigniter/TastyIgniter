<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_options extends Extension {

	public function options($options = array()) {
		$this->load->library('user');
		$this->load->model('Extensions_model');
		$this->load->model('Design_model');

		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'cart_module')) {
  			redirect('permission');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		extract($options);

		$ext_name 			= strtolower($name);
		$data['title'] 		= $title;

		if (empty($ext_data) OR !is_array($ext_data)) {
			$ext_data = array();
		}

		if (isset($ext_data['show_cart_images'])) {
			$data['show_cart_images'] = $ext_data['show_cart_images'];
		} else {
			$data['show_cart_images'] = $this->input->post('show_cart_images');
		}

		if (isset($ext_data['cart_images_h'])) {
			$data['cart_images_h'] = $ext_data['cart_images_h'];
		} else {
			$data['cart_images_h'] = $this->input->post('cart_images_h');
		}

		if (isset($ext_data['cart_images_w'])) {
			$data['cart_images_w'] = $ext_data['cart_images_w'];
		} else {
			$data['cart_images_w'] = $this->input->post('cart_images_w');
		}

		if ($this->input->post('layouts')) {
			$ext_data['layouts'] = $this->input->post('layouts');
		}

		$data['modules'] = array();
		if (!empty($ext_data['layouts'])) {
			foreach ($ext_data['layouts'] as $module) {

				$data['modules'][] = array(
					'layout_id'		=> $module['layout_id'],
					'position' 		=> $module['position'],
					'priority' 		=> $module['priority'],
					'status' 		=> $module['status']
				);
			}
		}

		$data['layouts'] = array();
		$results = $this->Design_model->getLayouts();
		foreach ($results as $result) {
			$data['layouts'][] = array(
				'layout_id'		=> $result['layout_id'],
				'name'			=> $result['name']
			);
		}

		$_GET['extension_id'] = $extension_id;
		if ($this->input->post() AND $this->_updateModule() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('extensions');
			}

			redirect('extensions/edit?action=edit&name='.$ext_name);
		}

		$this->render($data);
	}

	public function _updateModule() {
    	if (!$this->user->hasPermissions('modify', 'cart_module')) {
			$this->alert->set('warning', 'Warning: You do not have permission to update!');
			return TRUE;
    	} else if ($this->validateForm() === TRUE) {
			$update = array();

			$update['type'] 			= 'module';
			$update['name'] 			= $this->input->get('name');
			$update['title'] 			= $this->input->post('title');
			$update['extension_id'] 	= (int) $this->input->get('extension_id');
			$update['data']['layouts'] 	= $this->input->post('layouts');
			$update['data']['show_cart_images'] 	= $this->input->post('show_cart_images');
			$update['data']['cart_images_h'] 		= $this->input->post('cart_images_h');
			$update['data']['cart_images_w'] 		= $this->input->post('cart_images_w');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->alert->set('success', 'Cart Module updated sucessfully.');
			} else {
				$this->alert->set('warning', 'An error occured, nothing updated.');
			}

			return TRUE;
		}
	}

 	public function validateForm() {
		$this->form_validation->set_rules('title', 'Title', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('show_cart_images', 'Show cart image', 'xss_clean|trim|required|integer');

        if ($this->input->post('show_cart_images') === '1')
        {
            $this->form_validation->set_rules('cart_images_h', 'Image Height', 'xss_clean|trim|required|integer');
            $this->form_validation->set_rules('cart_images_w', 'Image Height', 'xss_clean|trim|required|integer');
        }

		foreach ($this->input->post('layouts') as $key => $value) {
			$this->form_validation->set_rules('layouts['.$key.'][layout_id]', 'Layout', 'xss_clean|trim|required|integer');
			$this->form_validation->set_rules('layouts['.$key.'][position]', 'Position', 'xss_clean|trim|required');
			$this->form_validation->set_rules('layouts['.$key.'][priority]', 'Priority', 'xss_clean|trim|integer');
			$this->form_validation->set_rules('layouts['.$key.'][status]', 'Status', 'xss_clean|trim|required|integer');
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file cart_module.php */
/* Location: ./extensions/cart_module/controllers/cart_module.php */