<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Pages extends Main_Controller {

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

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($result['heading'], 'pages?page_id='.$result['page_id']);

		$this->template->setTitle($result['title']);
		$this->template->setHeading($result['heading']);
		$this->template->setMeta(array('name' => 'description', 'content' => $result['meta_description']));
		$this->template->setMeta(array('name' => 'description', 'content' => $result['meta_keywords']));
		$data['page_id'] 			= $result['page_id'];
		$data['text_heading'] 		= $result['heading'];
		$data['page_content'] 		= $result['content'];

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('pages', $data);
	}
}

/* End of file pages.php */
/* Location: ./main/controllers//pages.php */