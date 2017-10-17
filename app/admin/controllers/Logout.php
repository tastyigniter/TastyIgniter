<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Logout extends Admin_Controller {

    public function __construct() {
        parent::__construct(); //  calls the constructor
    }

    public function index() {
        $this->lang->load('login');

        log_activity($this->user->getStaffId(), 'logged out', 'staffs', get_activity_message('activity_logged_out',
            array('{staff}', '{link}'),
            array($this->user->getStaffName(), admin_url('staffs/edit?id=' . $this->user->getStaffId()))
        ));

        $this->user->logout();
        $this->alert->set('success', $this->lang->line('alert_success_logout'));
        redirect('login');
    }
}

/* End of file logout.php */
/* Location: ./admin/controllers/logout.php */