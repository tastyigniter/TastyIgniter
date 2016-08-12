<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Restaurant_settings extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Restaurant_settings');

        $this->load->model('Settings_model'); // load the settings model
		$this->load->model('Locations_model');
		$this->load->model('Restaurant_settings_model'); // load the restaurant_settings model
        $this->load->model('Tables_model');
        $this->load->model('Countries_model');
        $this->load->model('Extensions_model');

        $this->load->library('permalink');

        $this->lang->load('restaurant_settings');
    }

	public function index() {
		if ($this->input->post() AND $this->_saveSettings()) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

		$this->template->setStyleTag(assets_url('js/datepicker/bootstrap-timepicker.css'), 'bootstrap-timepicker-css');
		$this->template->setScriptTag(assets_url("js/datepicker/bootstrap-timepicker.js"), 'bootstrap-timepicker-js');
		$this->template->setScriptTag(assets_url("js/jquery-sortable.js"), 'jquery-sortable-js');

		$this->template->setStyleTag(assets_url('js/summernote/summernote.css'), 'summernote-css');
		$this->template->setScriptTag(assets_url('js/summernote/summernote.min.js'), 'summernote-js');

		$data = $this->getForm();

        $this->template->render('locations_edit', $data);
    }

	public function getForm() {
		$location_info = $this->Locations_model->getLocation((int) $this->user->getLocationId());

		$this->load->module('Locations');
		return $this->locations->getForm($location_info);
	}

	protected function _saveSettings() {
    	if ($this->validateForm() === TRUE) {
            $save_type = $this->lang->line('text_updated');
			if ($location_id = $this->Locations_model->saveLocation($this->user->getLocationId(), $this->input->post())) {
				log_activity($this->user->getStaffId(), $save_type, 'locations', get_activity_message('activity_custom',
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), $save_type, 'location', $this->pageUrl($this->edit_url, array('id' => $location_id)), $this->input->post('location_name'))
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Location '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $location_id;
		}
	}

	protected function validateForm() {
		$this->load->module('Locations');
		return $this->locations->validateForm();
	}
}

/* End of file Restaurant_settings.php */
/* Location: ./admin/controllers/Restaurant_settings.php */