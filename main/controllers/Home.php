<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Home extends Main_Controller {

	public function index() {
        $this->lang->load('home');

        $this->template->setTitle($this->lang->line('text_heading'));

		$this->template->render('home');
	}
}


/* End of file home.php */
/* Location: ./main/controllers/home.php */