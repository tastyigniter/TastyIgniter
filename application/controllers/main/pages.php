<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('user'); 														// load the user library
		$this->load->model('Pages_model');
	}

	public function page($page_id = '') {
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($page_id !== '') {
			$data['page_id'] = $page_id;	
		} else {
			//show_404();
		}

		$result = $this->Pages_model->getPage($page_id);
		
		$data['text_title'] 		= $result['title'];
		$data['text_heading'] 		= $result['heading'];
		$data['meta_description'] 	= $result['meta_description'];
		$data['meta_keywords'] 		= $result['meta_keywords'];
		$data['page_content'] 		= $result['content'];

		$regions = array('header', 'content_top', 'content_left', 'content_right', 'footer');
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'pages.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'pages', $regions, $data);
		} else {
			$this->template->render('themes/main/default/', 'pages', $regions, $data);
		}
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/main/pages.php */