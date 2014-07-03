<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Pages extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('user'); 														// load the user library
		$this->load->model('Pages_model');
	}

	public function index() {
		$page_id = (int) $this->input->get('page_id');	
		$result = $this->Pages_model->getPage($page_id);
		
		if (!$result) {
			show_404();
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
		
		$this->template->setTitle($result['title']);
		$this->template->setHeading($result['heading']);
		$this->template->setMeta(array('name' => 'description', 'content' => $result['meta_description']));
		$this->template->setMeta(array('name' => 'description', 'content' => $result['meta_keywords']));
		$data['page_id'] 			= $result['page_id'];
		$data['text_heading'] 		= $result['heading'];
		$data['page_content'] 		= $result['content'];

		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'pages.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'pages', $data);
		} else {
			$this->template->render('themes/main/default/', 'pages', $data);
		}
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/main/pages.php */