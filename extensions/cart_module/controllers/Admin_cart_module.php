<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_cart_module extends Admin_Controller {

	public function index($module = array()) {
		$this->load->model('cart_module/Cart_model'); 														// load the cart model

		$this->lang->load('cart_module/cart_module');

        $this->user->restrict('Module.CartModule');

        if (!empty($module)) {
            $title = (isset($module['title'])) ? $module['title'] : $this->lang->line('_text_title');

            $this->template->setTitle('Module: ' . $title);
            $this->template->setHeading('Module: ' . $title);
            $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

			$this->template->setScriptTag(assets_url('js/jquery-sortable.js'), 'jquery-sortable-js');

			if ($this->input->post() AND $this->_updateModule() === TRUE) {
				if ($this->input->post('save_close') === '1') {
					redirect('extensions');
				}

				redirect('extensions/edit/module/cart_module');
			}

			$ext_data = array();
            if (!empty($module['ext_data']) AND is_array($module['ext_data'])) {
                $ext_data = $module['ext_data'];
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


			if ($this->input->post('cart_totals')) {
				$cart_totals = $ext_data['cart_totals'];
			} else {
				$cart_totals = $this->Cart_model->getTotals(array('filter_status' => '0'));
			}

			$data['cart_totals'] = array();
			foreach ($cart_totals as $key => $result) {
				$data['cart_totals'][] = array(
					'priority'    => isset($result['priority']) ? $result['priority'] : $key,
					'name'        => $result['name'],
					'title'       => $result['title'],
					'admin_title' => $result['admin_title'],
					'status'      => $result['status'],
				);
			}

            return $this->load->view('cart_module/admin_cart_module', $data, TRUE);
        }
	}

	private function _updateModule() {
		$this->user->restrict('Module.CartModule.Manage');

    	if ($this->validateForm() === TRUE) {

			if ($this->Extensions_model->updateExtension('module', 'cart_module', $this->input->post())) {
				$this->Cart_model->updateTotals($this->input->post('cart_totals'));
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

		if ($this->input->post('totals')) {
			foreach ($this->input->post('totals') as $key => $value) {
				$this->form_validation->set_rules('totals['.$key.'][title]', "[{$key}] ".$this->lang->line('column_title'), 'xss_clean|trim|required|max_length[128]');
				$this->form_validation->set_rules('totals['.$key.'][admin_title]', "[{$key}] ".$this->lang->line('column_admin_title'), 'xss_clean|trim|required|max_length[128]');
				$this->form_validation->set_rules('totals['.$key.'][name]', "[{$key}] ".$this->lang->line('column_name'), 'xss_clean|trim|required|alpha_dash');
				$this->form_validation->set_rules('totals['.$key.'][status]', "[{$key}] ".$this->lang->line('column_display'), 'xss_clean|trim|required|integer');
			}
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