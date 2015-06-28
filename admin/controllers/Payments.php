<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Payments extends Admin_Controller {

    public function __construct() {
		parent::__construct();

        $this->user->restrict('Admin.Payments');

        $this->load->model('Extensions_model');

        $this->lang->load('payments');
	}

	public function index() {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
        $this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/add'));

		$data['payments'] = array();
		$results = $this->Extensions_model->getList(array('type' => 'payment'));
		foreach ($results as $result) {
			if ($result['installed'] === TRUE) {
                $manage = 'uninstall';
            } else {
                $manage = 'install';
			}

			$data['payments'][] = array(
				'extension_id' 	=> $result['extension_id'],
				'name' 			=> $result['title'],
				'installed' 	=> $result['installed'],
				'type' 			=> $result['type'],
				'options' 		=> $result['options'],
				'edit' 			=> site_url('payments/edit?action=edit&name='.$result['name'].'&id='.$result['extension_id']),
                'manage'		=> site_url('payments/edit?action='.$manage.'&name='.$result['name'].'&id='.$result['extension_id'])
			);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('payments', $data);
	}

	public function edit() {
		$extension_name = $this->input->get('name');
		$action = $this->input->get('action');
		$loaded = FALSE;
        $error_msg = FALSE;

        if ($payment = $this->Extensions_model->getExtension('payment', $extension_name, FALSE)) {
            $data['payment_name'] = $payment['name'];
            $ext_controller = $payment['name'] . '/admin_' . $payment['name'];
            $ext_class = strtolower('admin_'.$payment['name']);

            if (isset($payment['installed'], $payment['config'], $payment['options']) AND $action === 'edit') {
                if ($payment['config'] === FALSE) {
                    $error_msg = $this->lang->line('error_config');
                } else if ($payment['options'] === FALSE) {
                    $error_msg = $this->lang->line('error_options');
                } else if ($payment['installed'] === FALSE) {
                    $error_msg = $this->lang->line('error_installed');
                } else {
                    $this->load->module($ext_controller);
                    if (class_exists($ext_class, FALSE)) {
                        $data['payment'] = $this->{$ext_class}->index($payment);
                        $loaded = TRUE;
                    } else {
                        $error_msg = sprintf($this->lang->line('error_failed'), $extension_name);
                    }
                }
            }
        }

        if ($this->input->get('name') AND $this->input->get('action') AND $action !== 'edit') {
            if ($this->input->get('action') === 'install' AND $this->_install() === TRUE) {
                redirect('payments');
            } else if ($this->input->get('action') === 'uninstall' AND $this->_uninstall() === TRUE) {
                redirect('payments');
            }
        }

        if (!$loaded AND $error_msg) {
            $this->alert->set('warning', $error_msg);
            redirect(referrer_url());
        }

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('payments_edit', $data);
	}

	private function _install() {
        if ($this->input->get('action') === 'install') {
            if ($this->Extensions_model->extensionExists($this->input->get('name'))) {
                if ($this->Extensions_model->install('payment', $this->input->get('name'), $this->input->get('id'))) {
                    log_activity($this->user->getStaffId(), 'installed', 'extensions', get_activity_message('activity_custom_no_link',
                        array('{staff}', '{action}', '{context}', '{item}'),
                        array($this->user->getStaffName(), 'installed', 'extension payment', $this->input->get('name'))
                    ));

                    $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Payment installed '));
                    return TRUE;
                }
            }

            $this->alert->danger_now($this->lang->line('alert_error_try_again'));
            return TRUE;
        }
	}

	private function _uninstall() {
        if ($this->input->get('action') === 'uninstall') {
            if ($this->Extensions_model->uninstall('payment', $this->input->get('name'), $this->input->get('id'))) {
                log_activity($this->user->getStaffId(), 'uninstalled', 'extensions', get_activity_message('activity_custom_no_link',
                    array('{staff}', '{action}', '{context}', '{item}'),
                    array($this->user->getStaffName(), 'uninstalled', 'extension payment', $this->input->get('name'))
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Payment uninstalled '));
                return TRUE;
            }

            $this->alert->danger_now($this->lang->line('alert_error_try_again'));
            return TRUE;
        }
	}
}

/* End of file payments.php */
/* Location: ./admin/controllers/payments.php */