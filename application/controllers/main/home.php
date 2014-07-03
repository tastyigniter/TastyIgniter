<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Home extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
					
		$this->load->library('language');
		$this->lang->load('main/home', $this->language->folder());
	}

	public function index() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->session->flashdata('local_alert')) {
			$data['local_alert'] = $this->session->flashdata('local_alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['local_alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_postcode'] 			= ($this->config->item('search_by') === 'postcode') ? $this->lang->line('entry_postcode') : $this->lang->line('entry_address');
		$data['text_find'] 				= $this->lang->line('text_find');
		// END of retrieving lines from language file to send to view.

		$data['local_action']			= site_url('local_module/main/local_module/distance');
		$data['menus_url']				= site_url('main/menus');

		$local_info = $this->session->userdata('local_info');
		if ($local_info['search_query']) {
			$data['postcode'] = $local_info['search_query'];
		} else {
			$data['postcode'] = '';
		}
		
		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'home.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'home', $data);
		} else {
			$this->template->render('themes/main/default/', 'home', $data);
		}
	}
}


/* End of file home.php */
/* Location: ./application/controllers/main/home.php */