<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_cart_module extends Admin_Controller {

	public function index($data = array()) {
        $this->user->restrict('Module.CartModule');

        if (!empty($data)) {
            $data['title'] = (isset($data['title'])) ? $data['title'] : 'Cart Module';

            $this->template->setTitle('Module: ' . $data['title']);
            $this->template->setHeading('Module: ' . $data['title']);
            $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setBackButton('btn btn-back', site_url('extensions'));

            $ext_data = array();
            if (!empty($data['ext_data']) AND is_array($data['ext_data'])) {
                $ext_data = $data['ext_data'];
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

            if ($this->input->post() AND $this->_updateModule() === TRUE) {
                if ($this->input->post('save_close') === '1') {
                    redirect('extensions');
                }

                redirect('extensions/edit?action=edit&name=cart_module');
            }

            return $this->load->view('cart_module/admin_cart_module', $data, TRUE);
        }
	}

	private function _updateModule() {
    	if ($this->validateForm() === TRUE) {
			$update = array();

			$update['type'] 			= 'module';
			$update['name'] 			= $this->input->get('name');
			$update['title'] 			= $this->input->post('title');
			$update['extension_id'] 	= (int) $this->input->get('id');
			$update['data']['show_cart_images'] 	= $this->input->post('show_cart_images');
			$update['data']['cart_images_h'] 		= $this->input->post('cart_images_h');
			$update['data']['cart_images_w'] 		= $this->input->post('cart_images_w');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->alert->set('success', 'Cart Module updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

 	private function validateForm() {
		$this->form_validation->set_rules('title', 'Title', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('show_cart_images', 'Show cart image', 'xss_clean|trim|required|integer');

        if ($this->input->post('show_cart_images') === '1')
        {
            $this->form_validation->set_rules('cart_images_h', 'Image Height', 'xss_clean|trim|required|integer');
            $this->form_validation->set_rules('cart_images_w', 'Image Height', 'xss_clean|trim|required|integer');
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