<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Newsletter extends Base_Component
{

	public function index() {
		$this->lang->load('newsletter/newsletter');

		$this->assets->setStyleTag(extension_url('newsletter/assets/stylesheet.css'), 'newsletter-css', '20150828');

		$data['newsletter_alert'] = $this->alert->display('newsletter_alert');

		$data['subscribe_url'] = site_url('newsletter/newsletter/subscribe');

		// pass array $data and load view files
		return $this->load->view('newsletter/newsletter', $data, TRUE);
	}

	public function subscribe() {
		$this->lang->load('newsletter/newsletter');

		$this->load->library('user_agent');
		$validated = FALSE;
		$json = array();

		$referrer_uri = explode('/', str_replace(site_url(), '', $this->agent->referrer()));
		$referrer_uri = (!empty($referrer_uri[0]) AND $referrer_uri[0] !== 'newsletter') ? $referrer_uri[0] : 'home';

		$this->form_validation->set_rules('subscribe_email', 'lang:label_email', 'xss_clean|trim|required|valid_email');

		if ($this->form_validation->run() === TRUE) {                                            // checks if form validation routines ran successfully
			$validated = TRUE;
		} else {
			$json['error'] = $this->form_validation->error('subscribe_email', '', '');
		}

		if ($validated === TRUE) {
			$settings = $this->Extensions_model->getSettings('newsletter');

			is_array($settings['subscribe_list']) OR $settings['subscribe_list'] = array();

			$subscribe_email = strtolower($this->input->post('subscribe_email'));

			if (!in_array($subscribe_email, $settings['subscribe_list'])) {
				$settings['subscribe_list'][] = $subscribe_email;

				if ($this->Extensions_model->saveExtensionData('newsletter', $settings)) {
					$json['success'] = $this->lang->line('alert_success_subscribed');
				}

			} else if (in_array($subscribe_email, $settings['subscribe_list'])) {

				$json['success'] = $this->lang->line('alert_success_existing');

			} else {
				$json['error'] = $this->lang->line('alert_error_try_again');
			}
		}

		$redirect = $referrer_uri;

		if ($this->input->is_ajax_request()) {
			$this->output->set_output(json_encode($json));                                            // encode the json array and set final out to be sent to jQuery AJAX
		} else {
			if (isset($json['error'])) $this->alert->set('danger', $json['error'], 'newsletter_alert');
			if (isset($json['success'])) $this->alert->set('success', $json['success'], 'newsletter_alert');
			$this->redirect($redirect);
		}
	}
}

/* End of file Newsletter.php */
/* Location: ./extensions/newsletter/components/Newsletter.php */