<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Payments extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->library('extension');
		$this->load->model('Extensions_model');
	}

	public function index() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'payments')) {
  			redirect('permission');
		}

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
		$this->template->setButton('Uninstall', array('class' => 'btn btn-danger', 'onclick' => 'uninstallPayment()'));

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
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'payments')) {
  			redirect('permission');
		}

		$extension_name = $this->input->get('name');
		$action = $this->input->get('action');
		$loaded = FALSE;

		if ($payment = $this->Extensions_model->getExtension('payment', $extension_name)) {

			if (isset($payment['installed']) AND $payment['installed'] === TRUE)  {
				$loaded = TRUE;
			}

			if (isset($payment['config']) AND $payment['config'] === TRUE)  {
				$loaded = TRUE;
			}

			if ($loaded === TRUE AND $action === 'edit') {
				$this->template->setTitle('Module: '. $payment['title']);
				$this->template->setHeading('Module: '. $payment['title']);
				$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
				$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
				$this->template->setBackButton('btn btn-back', site_url('payments'));

				$data['payment_name'] 		= $payment['name'];
				$data['payments_options'] 	= $payment;
			}
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('payments_edit', $data);
	}

	public function _install() {
    	if ( ! $this->user->hasPermissions('modify', 'payments')) {
			$this->alert->set('warning', 'Warning: You do not have permission to install!');
    	} else if ($this->input->get('action') === 'install') {
    		$name = $this->input->get('name');

    		$this->Extensions_model->install('payment', $name);

			$this->load->model('Staff_groups_model');
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'access', $name);
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'modify', $name);

			$this->alert->set('success', 'Payment Installed Sucessfully!');

			return TRUE;
		}
	}

	public function _uninstall() {
    	if ( ! $this->user->hasPermissions('modify', 'payments')) {
			$this->alert->set('warning', 'Warning: You do not have permission to uninstall!');
    	} else if ($this->input->get('action') === 'uninstall') {
    		$name = $this->input->get('name');

    		$this->Extensions_model->uninstall('payment', $name);

			$this->alert->set('success', 'Payment Uninstalled Sucessfully!');

			return TRUE;
		}
	}
}

/* End of file payments.php */
/* Location: ./admin/controllers/payments.php */