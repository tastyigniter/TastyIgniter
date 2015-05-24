<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Payments extends Admin_Controller {

    public $_permission_rules = 'access';

    public function __construct() {
		parent::__construct();
		$this->load->model('Extensions_model');
	}

	public function index() {
		if ($this->input->get('name') AND $this->input->get('action')) {
			if ($this->input->get('action') === 'install' AND $this->_install() === TRUE) {
				redirect('payments');
			}

			if ($this->input->get('action') === 'uninstall' AND $this->_uninstall() === TRUE) {
				redirect('payments');
			}
		}

		$this->template->setTitle('Payments');
		$this->template->setHeading('Payments');

		$data['text_empty'] 		= 'There are no extensions available.';

		$data['payments'] = array();
		$results = $this->Extensions_model->getList('payment');
		foreach ($results as $result) {
			if ($result['installed'] === TRUE) {
				$extension_id = $result['extension_id'];
				$manage = site_url('payments?action=uninstall&name='.$result['name']);
			} else {
				$extension_id = '-';
				$manage = site_url('payments?action=install&name='.$result['name']);
			}

			$data['payments'][] = array(
				'extension_id' 	=> $extension_id,
				'name' 			=> $result['title'],
				'installed' 	=> $result['installed'],
				'type' 			=> $result['type'],
				'options' 		=> $result['options'],
				'edit' 			=> site_url('payments/edit?action=edit&name='.$result['name']),
				'manage'		=> $manage
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

        if ($payment = $this->Extensions_model->getExtension('payment', $extension_name)) {

            $data['payment_name'] = $payment['name'];
            $ext_controller = $payment['name'] . '/admin_' . $payment['name'];
            $ext_class = strtolower('admin_'.$payment['name']);

            if (isset($payment['installed'], $payment['config'], $payment['options']) AND $action === 'edit') {
                if ($payment['config'] === FALSE) {
                    $error_msg = 'An error occurred, payment extension config file failed to load.';
                } else if ($payment['options'] === FALSE) {
                    $error_msg = 'An error occurred, payment extension admin options disabled';
                } else if ($payment['installed'] === FALSE) {
                    $error_msg = 'An error occurred, payment extension is not installed properly';
                } else if (!$this->user->hasPermissions('access', $extension_name)) {
                    $error_msg = 'You do not have the right permission to access this payment';
                } else if ($this->input->post() AND !$this->user->hasPermissions('modify', $extension_name)) {
                    $error_msg = 'You do not have the right permission to modify this payment';
                } else {
                    $_GET['extension_id'] = $payment['extension_id'] ? $payment['extension_id'] : 0;
                    $this->load->module($ext_controller);
                    if (class_exists($ext_class, FALSE)) {
                        $data['payment'] = $this->{$ext_class}->index($payment);
                        $loaded = TRUE;
                    } else {
                        $error_msg = 'An error occurred, module extension class failed to load: admin_'.$extension_name;
                    }
                }
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
                if ($this->Extensions_model->install('payment', $this->input->get('name'))) {
                    $this->alert->set('success', 'Payment Installed successfully.');
                    return TRUE;
                }
            }

            $this->alert->danger_now('An error occurred, please try again.');
        }

        return FALSE;
	}

	private function _uninstall() {
        if ($this->input->get('action') === 'uninstall') {
            if ($this->Extensions_model->uninstall('payment', $this->input->get('name'))) {
                $this->alert->set('success', 'Payment Uninstalled successfully.');
                return TRUE;
            }
        }

        return FALSE;
	}
}

/* End of file payments.php */
/* Location: ./admin/controllers/payments.php */