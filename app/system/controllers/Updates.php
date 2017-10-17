<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Updates extends Admin_Controller {

	public function __construct() {
		parent::__construct();

		$this->user->restrict('Site.Updates');

		$this->lang->load('updates');
		$this->load->model('Updates_model');
	}

	public function index() {

		if ( ! $this->input->post()) {

			$this->template->setTitle($this->lang->line('text_title'));
			$this->template->setHeading($this->lang->line('text_heading'));
			$this->template->setButton($this->lang->line('button_check_again'), array('class' => 'btn btn-default', 'href' => site_url('updates?check=force')));

			$refresh = $this->input->get('check') === 'force' ? TRUE : FALSE;
			$data['updates'] = $this->Updates_model->getUpdates($refresh);

		} else {

			$update_type = $this->input->post('update');

			$this->template->setTitle(sprintf($this->lang->line('text_upgrade_title'), ucwords($update_type)));
			$this->template->setHeading(sprintf($this->lang->line('text_upgrade_heading'), ucwords($update_type)));

			if ($update_type === 'core' AND $this->input->post('version')) {
				$data['upgrade_url'] = site_url("updates/upgrade/{$update_type}?version={$this->input->post('version')}");
			} else {

				if ($this->validateUpdate() === TRUE) {
					if (is_array($updates = $this->input->post('updates'))) {
						$data['upgrade_url'] = site_url("updates/upgrade/{$update_type}?action=do_update&updates=". implode(',', $updates));
					}
				} else {
					$this->alert->set('warning', validation_errors());
					redirect('updates');
				}
			}
		}

		$this->template->render('updates', $data);
	}

	public function upgrade() {
		$this->output->enable_profiler(FALSE);

		if (!extension_loaded('zip')) {
			$this->alert->set('warning', $this->lang->line('alert_zip_warning'));
			redirect('updates');
		}

		if ( ! $this->uri->rsegment(3)) {
			$this->alert->set('warning', $this->lang->line('alert_bad_request'));
			redirect('updates');
		} else if ( ! $this->user->hasPermission('Site.Updates.Add')) {
			$this->alert->set('warning', $this->lang->line('alert_permission_warning'));
			redirect('updates');
		}

		$update_type = $this->uri->rsegment(3);

		$this->setHTMLHead();

		set_time_limit(300); // 5 minutes

		if (function_exists('apache_setenv')) @apache_setenv('no-gzip', 1);
		@ini_set('zlib.output_compression', 0);
		@ini_set('implicit_flush', 1);

		ob_implicit_flush(TRUE);
		ignore_user_abort(TRUE);

		if (ob_get_level() == 0) ob_start();

		flush_output($this->load->view($this->config->item('admin', 'default_themes') . 'updates_upgrade', '', TRUE), FALSE);

		if ($update_type === 'core') {
			// Enable maintenance mode, will be disabled after update
			flush_output($this->lang->line('progress_enable_maintenance') . "<br />");
			$maintenance_mode = $this->config->item('maintenance_mode');
			$this->config->set_item('maintenance_mode', 0);

			$this->Updates_model->update($update_type);

			// Restore maintenance mode
			flush_output($this->lang->line('progress_disable_maintenance'));
			$this->config->set_item('maintenance_mode', $maintenance_mode);

			flush_output(sprintf($this->lang->line('text_complete_installation'), base_url()));

		} else if ($updates = $this->input->get('updates')) {
			foreach ($updates as $update) {
				$update = explode('|', $update);
				if (count($update) === 2) {
					$this->Updates_model->update($update_type, $update[0], $update[1]);
				}
			}
		}

		flush_output('<script type="text/javascript">
			parent.jQuery(\'#updateProgress\').attr(\'class\', \'fa fa-check\')
			.attr(\'title\', \'Complete\');
		</script>', FALSE);

		flush_output('</body></html>', FALSE);

		ob_end_flush();
	}

	protected function validateUpdate() {
		if ($this->input->post('update') === 'core') {
			$this->form_validation->set_rules('version', ucwords($this->input->post('update')), 'xss_clean|trim|required');
		} else {
			$this->form_validation->set_rules('updates[]', ucwords($this->input->post('update')), 'xss_clean|trim|required');
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	protected function setHTMLHead() {
		header('Cache-Control: no-cache, must-revalidate');

		$this->template->setDocType('html5');
		$this->template->setMeta(array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'));
		$this->template->setMeta(array('name' => 'X-UA-Compatible', 'content' => 'IE=edge,chrome=1', 'type' => 'equiv'));
		$this->template->setMeta(array('name' => 'X-UA-Compatible', 'content' => 'IE=9; IE=8; IE=7', 'type' => 'equiv'));
		$this->template->setMeta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1', 'type' => 'name'));
		$this->template->setMeta(array('name' => 'robots', 'content' => 'noindex,nofollow', 'type' => 'name'));

		$this->template->setFavIcon('images/favicon.ico', 'shortcut icon', 'image/ico');

		$this->template->setStyleTag('css/bootstrap.min.css', 'bootstrap-css', '10');
		$this->template->setStyleTag('css/font-awesome.min.css', 'font-awesome-css', '11');
		$this->template->setStyleTag('css/fonts.css', 'fonts-css', '16');
		$this->template->setStyleTag('css/stylesheet.css', 'stylesheet-css', '100');

		$this->template->setScriptTag('js/jquery-1.11.2.min.js', 'jquery-js', '1');
	}
}

/* End of file Updates.php */
/* Location: ./admin/controllers/Updates.php */