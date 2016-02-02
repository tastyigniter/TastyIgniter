<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_cart_module extends Admin_Controller {

	public function index($data = array()) {
        $this->lang->load('cart_module/cart_module');

        $this->user->restrict('Module.CartModule');

        if (!empty($data)) {
            $title = (isset($data['title'])) ? $data['title'] : $this->lang->line('_text_title');

            $this->template->setTitle('Module: ' . $title);
            $this->template->setHeading('Module: ' . $title);
            $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

            $ext_data = array();
            if (!empty($data['ext_data']) AND is_array($data['ext_data'])) {
                $ext_data = $data['ext_data'];
            }

	        if (isset($ext_data['show_cart_images'])) {
		        $data['show_cart_images'] = $ext_data['show_cart_images'];
	        } else {
		        $data['show_cart_images'] = $this->input->post('show_cart_images');
	        }

	        if (isset($ext_data['fixed_cart'])) {
		        $data['fixed_cart'] = $ext_data['fixed_cart'];
	        } else if ($this->input->post('fixed_cart')) {
		        $data['fixed_cart'] = $this->input->post('fixed_cart');
	        } else {
		        $data['fixed_cart'] = '1';
	        }

	        if (isset($ext_data['fixed_top_offset'])) {
		        $data['fixed_top_offset'] = $ext_data['fixed_top_offset'];
	        } else if ($this->input->post('fixed_top_offset')) {
		        $data['fixed_top_offset'] = $this->input->post('fixed_top_offset');
	        } else {
		        $data['fixed_top_offset'] = '250';
	        }

	        if (isset($ext_data['fixed_bottom_offset'])) {
		        $data['fixed_bottom_offset'] = $ext_data['fixed_bottom_offset'];
	        } else if ($this->input->post('fixed_bottom_offset')) {
		        $data['fixed_bottom_offset'] = $this->input->post('fixed_bottom_offset');
	        } else {
		        $data['fixed_bottom_offset'] = '120';
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

                redirect('extensions/edit/module/cart_module');
            }

            return $this->load->view('cart_module/admin_cart_module', $data, TRUE);
        }
	}

	private function _updateModule() {
		$this->user->restrict('Module.CartModule.Manage');

    	if ($this->validateForm() === TRUE) {

			if ($this->Extensions_model->updateExtension('module', 'cart_module', $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title').' module '.$this->lang->line('text_updated')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
			}

			return TRUE;
		}
	}

 	private function validateForm() {
		$this->form_validation->set_rules('show_cart_images', 'lang:label_show_cart_images', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('fixed_cart', 'lang:label_fixed_cart', 'xss_clean|trim|required|integer');

	    if ($this->input->post('fixed_cart') === '1') {
		    $this->form_validation->set_rules('fixed_top_offset', 'lang:label_fixed_top_offset', 'xss_clean|trim|required|integer');
		    $this->form_validation->set_rules('fixed_bottom_offset', 'lang:label_fixed_bottom_offset', 'xss_clean|trim|required|integer');
	    }

        if ($this->input->post('show_cart_images') === '1')
        {
            $this->form_validation->set_rules('cart_images_h', 'lang:label_cart_images_h', 'xss_clean|trim|required|integer');
            $this->form_validation->set_rules('cart_images_w', 'lang:label_cart_images_w', 'xss_clean|trim|required|integer');
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