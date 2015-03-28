<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Slug extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		//$this->load->library('location'); 														// load the location library
		//$this->load->library('currency'); 														// load the currency library
		//$this->load->model('Pages_model');

		//$this->lang->load('home');
	}

	public function index() {

		// START of retrieving lines from language file to pass to view.
		//$this->template->setTitle($this->lang->line('text_heading'));
		//$this->template->setHeading($this->lang->line('text_heading'));

		//$data['text_postcode'] 			= ($this->config->item('search_by') === 'postcode') ? $this->lang->line('entry_postcode') : $this->lang->line('entry_address');
		//$data['text_place_order'] 		= $this->lang->line('text_place_order');
		//$data['text_find'] 				= $this->lang->line('text_find');
		// END of retrieving lines from language file to send to view.

		//$data['local_action']			= site_url('local_module/local_module/search');
		//$data['menus_url']				= site_url('menus');

		//$local_info = $this->session->userdata('local_info');
		//if ($local_info['search_query']) {
		//	$data['postcode'] = $local_info['search_query'];
		//} else {
		//	$data['postcode'] = '';
		//}

		//$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		//$this->template->render('home', $data);
	}
}


/* End of file home.php */
/* Location: ./main/controllers//home.php */