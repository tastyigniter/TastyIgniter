<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_cod extends Ext_Controller {

	public function index($data = array()) {
        if (!empty($data)) {
            $this->load->model('Statuses_model');

            $data['title'] = (isset($data['title'])) ? $data['title'] : 'Cash On Delivery';

            $this->template->setTitle('Payment: ' . $data['title']);
            $this->template->setHeading('Payment: ' . $data['title']);
            $this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setBackButton('btn btn-back', site_url('payments'));

            $ext_data = array();
            if (!empty($data['ext_data']) AND is_array($data['ext_data'])) {
                $ext_data = $data['ext_data'];
            }

            if (isset($this->input->post['name'])) {
                $data['name'] = $this->input->post['name'];
            } else if (isset($ext_data['name'])) {
                $data['name'] = $ext_data['name'];
            } else {
                $data['name'] = '';
            }

            if (isset($this->input->post['order_total'])) {
                $data['order_total'] = $this->input->post['order_total'];
            } else if (isset($ext_data['order_total'])) {
                $data['order_total'] = $ext_data['order_total'];
            } else {
                $data['order_total'] = '';
            }

            if (isset($this->input->post['order_status'])) {
                $data['order_status'] = $this->input->post['order_status'];
            } else if (isset($ext_data['order_status'])) {
                $data['order_status'] = $ext_data['order_status'];
            } else {
                $data['order_status'] = '';
            }

            if (isset($this->input->post['priority'])) {
                $data['priority'] = $this->input->post['priority'];
            } else if (isset($ext_data['priority'])) {
                $data['priority'] = $ext_data['priority'];
            } else {
                $data['priority'] = '';
            }

            if (isset($this->input->post['status'])) {
                $data['status'] = $this->input->post['status'];
            } else if (isset($ext_data['status'])) {
                $data['status'] = $ext_data['status'];
            } else {
                $data['status'] = '';
            }

            $data['statuses'] = array();
            $results = $this->Statuses_model->getStatuses('order');
            foreach ($results as $result) {
                $data['statuses'][] = array(
                    'status_id' => $result['status_id'],
                    'status_name'		=> $result['status_name']
                );
            }

            if ($this->input->post() AND $this->_updateCod() === TRUE){
                if ($this->input->post('save_close') === '1') {
                    redirect('payments');
                }

                redirect('payments/edit?action=edit&name=cod');
            }

            return $this->load->view('cod/admin_cod', $data, TRUE);
        }
	}

	private function _updateCod() {
    	if (!$this->input->post('delete') AND $this->validateForm() === TRUE) {
			$update = array();

			$update['type'] 				= 'payment';
			$update['name'] 				= $this->input->get('name');
			$update['title'] 				= $this->input->post('title');
			$update['extension_id'] 		= (int) $this->input->get('extension_id');
			$update['data']['name'] 		= $this->input->post('name');
			$update['data']['order_total'] 	= $this->input->post('order_total');
			$update['data']['order_status'] = $this->input->post('order_status');
			$update['data']['priority'] 	= $this->input->post('priority');
			$update['data']['status'] 		= $this->input->post('status');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->alert->set('success', 'COD Payment updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

	private function validateForm() {
		$this->form_validation->set_rules('order_total', 'Minimum Total', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('order_status', 'Order Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file cod.php */
/* Location: ./extensions/payments/cod/controllers/cod.php */