<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Home extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor

        $this->load->model('Pages_model');

        $this->load->library('location'); 														// load the location library
        $this->load->library('currency'); 														// load the currency library

		$this->lang->load('home');
	}

	public function index() {
		$this->template->setTitle($this->lang->line('text_heading'));

		$this->template->render('home');
	}
}


/* End of file home.php */
/* Location: ./main/controllers/home.php */