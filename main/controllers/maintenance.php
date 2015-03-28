<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Maintenance extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('user'); 														// load the user library
	}

	public function index() {

		if ($this->config->item('maintenance_mode') === '1' AND !$this->user->isLogged()) {  													// if customer is not logged in redirect to account login page
			$maintenance_page = ($this->config->item('maintenance_page')) ? $this->config->item('maintenance_page') : '';

			$this->load->model('Pages_model');
			$page = $this->Pages_model->getPage($maintenance_page);

			$this->template->setTitle($page['title']);
			$this->template->setHeading($page['heading']);
			$data['text_heading'] 		= $page['heading'];
			$data['content'] 			= $page['content'];

			if (file_exists(VIEWPATH .'themes/'.$this->config->item('main', 'default_themes').'maintenance.php')) {
				$this->load->view('themes/'.$this->config->item('main', 'default_themes').'maintenance', $data);
			} else {
				$this->load->view('maintenance', $data);
			}
		} else {
			redirect('menus');
		}
	}
}

/* End of file maintenance.php */
/* Location: ./main/controllers//maintenance.php */