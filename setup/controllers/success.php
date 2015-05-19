<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Success extends Base_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Setup_model');
    }

    public function index() {
        if ( ! file_exists(VIEWPATH .'/success.php')) {
            show_404();
        }

        if ($this->session->tempdata('setup') === 'step_3') {
            $data['heading'] 			= 'TastyIgniter - Setup - Successful';
            $data['sub_heading'] 		= 'Installation Successful';
            $data['complete_setup'] 	= '<a href="'. root_url(ADMINDIR) .'">Login to Administrator Panel</a>';

            $this->load->library('user');
            $this->user->logout();

            $this->load->view('header', $data);
            $this->load->view('success', $data);
            $this->load->view('footer', $data);

        } else if ($this->config->item('ti_version')) {
            redirect(root_url());
        } else {
            redirect('setup');
        }

    }
}

/* End of file success.php */
/* Location: ./setup/controllers/success.php */
