<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Countries extends Admin_Controller {

    public $_permission_rules = array('access[index|edit]', 'modify[index|edit]');

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('pagination');
		$this->load->model('Countries_model');
		$this->load->model('Image_tool_model');
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

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'country_name';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = 'ASC';
		}

		$this->template->setTitle('Countries');
		$this->template->setHeading('Countries');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no countries available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('countries').$url.'sort_by=country_name&order_by='.$order_by;
		$data['sort_iso_2'] 		= site_url('countries').$url.'sort_by=iso_code_2&order_by='.$order_by;
		$data['sort_iso_3'] 		= site_url('countries').$url.'sort_by=iso_code_3&order_by='.$order_by;

		$data['country_id'] = $this->config->item('country_id');

		$data['countries'] = array();
		$results = $this->Countries_model->getList($filter);
		foreach ($results as $result) {
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
				'iso_code_2'	=>	$result['iso_code_2'],
				'iso_code_3'	=>	$result['iso_code_3'],
				'flag'			=>	(!empty($result['flag'])) ? $this->Image_tool_model->resize($result['flag']) : $this->Image_tool_model->resize('data/flags/no_flag.png'),
				'status'		=>	($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 			=> site_url('countries/edit?id=' . $result['country_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('countries').$url;
		$config['total_rows'] 		= $this->Countries_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteCountry() === TRUE) {

			redirect('countries');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('countries', $data);
	}

	public function edit() {
		$country_info = $this->Countries_model->getCountry((int) $this->input->get('id'));

		if ($country_info) {
			$country_id = $country_info['country_id'];
			$data['action']	= site_url('countries/edit?id='. $country_id);
		} else {
		    $country_id = 0;
			$data['action']	= site_url('countries/edit');
		}

		$title = (isset($country_info['country_name'])) ? $country_info['country_name'] : 'New';
		$this->template->setTitle('Country: '. $title);
		$this->template->setHeading('Country: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('countries'));

        $this->template->setStyleTag(root_url('assets/js/fancybox/jquery.fancybox.css'), 'jquery-fancybox-css');
        $this->template->setScriptTag(root_url("assets/js/fancybox/jquery.fancybox.js"), 'jquery-fancybox-js');

        $data['country_name'] 		= $country_info['country_name'];
		$data['iso_code_2'] 		= $country_info['iso_code_2'];
		$data['iso_code_3'] 		= $country_info['iso_code_3'];
		$data['format'] 			= $country_info['format'];
		$data['status'] 			= $country_info['status'];
		$data['no_photo'] 			= $this->Image_tool_model->resize('data/flags/no_flag.png');

		if ($this->input->post('flag')) {
			$data['flag']['path'] = $this->Image_tool_model->resize($this->input->post('flag'));
			$data['flag']['name'] = basename($this->input->post('flag'));
			$data['flag']['input'] = $this->input->post('flag');
		} else if (!empty($country_info['flag'])) {
			$data['flag']['path'] = $this->Image_tool_model->resize($country_info['flag']);
			$data['flag']['name'] = basename($country_info['flag']);
			$data['flag']['input'] = $country_info['flag'];
		} else {
			$data['flag']['path'] = $this->Image_tool_model->resize('data/flags/no_flag.png');
			$data['flag']['name'] = 'no_flag.png';
			$data['flag']['input'] = 'data/flags/no_flag.png';
		}

		if ($this->input->post() AND $country_id = $this->_saveCountry()) {
			if ($this->input->post('save_close') === '1') {
				redirect('countries');
			}

			redirect('countries/edit?id='. $country_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('countries_edit', $data);
	}

    private function _saveCountry() {
    	if ($this->validateForm() === TRUE) {
            $save_type = (! is_numeric($this->input->get('id'))) ? 'added' : 'updated';

			if ($country_id = $this->Countries_model->saveCountry($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', 'Country ' . $save_type . ' successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing ' . $save_type . '.');
			}

			return $country_id;
		}
	}

    private function _deleteCountry() {
    	if ($this->input->post('delete')) {
            $deleted_rows = $this->Countries_model->deleteCountry($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Countries': 'Country';
                $this->alert->set('success', $prefix.' deleted successfully.');
            } else {
                $this->alert->set('warning', 'An error occurred, nothing deleted.');
            }

            return TRUE;
        }
	}

    private function validateForm() {
		$this->form_validation->set_rules('country_name', 'Country', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('iso_code_2', 'ISO Code 2', 'xss_clean|trim|required|exact_length[2]');
		$this->form_validation->set_rules('iso_code_3', 'ISO Code 3', 'xss_clean|trim|required|exact_length[3]');
		$this->form_validation->set_rules('flag', 'Flag', 'xss_clean|trim|required');
		$this->form_validation->set_rules('format', 'Format', 'xss_clean|trim|min_length[2]');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file countries.php */
/* Location: ./admin/controllers/countries.php */