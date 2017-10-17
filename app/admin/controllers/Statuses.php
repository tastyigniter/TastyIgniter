<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Statuses extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Statuses');

        $this->load->model('Statuses_model');

        $this->load->library('pagination');

        $this->lang->load('statuses');
	}

	public function index() {
        $url = '?';
        $filter = array();
        if ($this->input->get('page')) {
            $filter['page'] = (int) $this->input->get('page');
        } else {
            $filter['page'] = '';
        }

        if ($this->config->item('page_limit')) {
            $filter['limit'] = $this->config->item('page_limit');
        }

        if ($this->input->get('filter_type')) {
            $filter['filter_type'] = $data['filter_type'] = $this->input->get('filter_type');
            $url .= 'filter_type='.$filter['filter_type'].'&';
        } else {
            $filter['filter_type'] = '';
            $data['filter_type'] = '';
        }

        if ($this->input->get('sort_by')) {
            $filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
        } else {
            $filter['sort_by'] = $data['sort_by'] = 'status_for';
        }

        if ($this->input->get('order_by')) {
            $filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
            $data['order_by_active'] = $this->input->get('order_by') .' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'ASC';
            $data['order_by_active'] = '';
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deleteStatus() === TRUE) {
			redirect('statuses');
		}

        $order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
        $data['sort_id'] 		    = site_url('statuses'.$url.'sort_by=status_id&order_by='.$order_by);
        $data['sort_name'] 			= site_url('statuses'.$url.'sort_by=status_name&order_by='.$order_by);
        $data['sort_type'] 			= site_url('statuses'.$url.'sort_by=status_for&order_by='.$order_by);
        $data['sort_notify'] 		= site_url('statuses'.$url.'sort_by=notify_customer&order_by='.$order_by);

		$data['statuses'] = array();
		$results = $this->Statuses_model->getList($filter);
		foreach ($results as $result) {

			$data['statuses'][] = array(
				'status_id'			=> $result['status_id'],
				'status_name'		=> $result['status_name'],
				'status_comment'	=> $result['status_comment'],
				'status_for'		=> ($result['status_for'] === 'reserve') ? 'Reservations' : ucwords($result['status_for']),
				'notify_customer' 	=> ($result['notify_customer'] === '1') ? 'Yes' : 'No',
				'edit' 				=> site_url('statuses/edit?id=' . $result['status_id'])
			);
		}

        $config['base_url'] 		= site_url('statuses'.$url);
        $config['total_rows'] 		= $this->Statuses_model->getCount($filter);
        $config['per_page'] 		= $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info'		=> $this->pagination->create_infos(),
            'links'		=> $this->pagination->create_links()
        );

		$this->template->render('statuses', $data);
	}

	public function edit() {
		$status_info = $this->Statuses_model->getStatus((int) $this->input->get('id'));

		if ($status_info) {
			$status_id = $status_info['status_id'];
			$data['_action']	= site_url('statuses/edit?id='. $status_id);
		} else {
		    $status_id = 0;
			$data['_action']	= site_url('statuses/edit');
		}

		$title = (isset($status_info['status_name'])) ? $status_info['status_name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('statuses')));

		$this->template->setStyleTag(assets_url('js/colorpicker/css/bootstrap-colorpicker.min.css'), 'bootstrap-colorpicker-css');
		$this->template->setScriptTag(assets_url('js/colorpicker/js/bootstrap-colorpicker.min.js'), 'bootstrap-colorpicker-js');

		if ($this->input->post() AND $status_id = $this->_saveStatus()) {
			if ($this->input->post('save_close') === '1') {
				redirect('statuses');
			}

			redirect('statuses/edit?id='. $status_id);
		}

		$data['status_id'] 			= $status_info['status_id'];
		$data['status_name'] 		= $status_info['status_name'];
        $data['status_color'] 		= $status_info['status_color'];
		$data['status_comment'] 	= $status_info['status_comment'];
        $data['status_for'] 		= $status_info['status_for'];
		$data['notify_customer'] 	= $status_info['notify_customer'];

		$this->template->render('statuses_edit', $data);
	}

	public function comment_notify() {
		if ($this->input->get('status_id')) {
			$status = $this->Statuses_model->getStatus($this->input->get('status_id'));

			$json = array('comment' => $status['status_comment'], 'notify' => $status['notify_customer']);

			$this->output->set_output(json_encode($json));
		}
	}

	private function _saveStatus() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($status_id = $this->Statuses_model->saveStatus($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Status '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $status_id;
		}
	}

	private function _deleteStatus() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Statuses_model->deleteStatus($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Order Statuses': 'Order Status';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('status_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('status_for', 'lang:label_for', 'xss_clean|trim|required|alpha');
        $this->form_validation->set_rules('status_color', 'lang:label_color', 'xss_clean|trim|required|max_length[7]');
        $this->form_validation->set_rules('status_comment', 'lang:label_comment', 'xss_clean|trim|max_length[1028]');
		$this->form_validation->set_rules('notify_customer', 'lang:label_notify', 'xss_clean|trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file statuses.php */
/* Location: ./admin/controllers/statuses.php */