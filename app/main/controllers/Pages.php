<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Pages extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor

        $this->load->model('Pages_model');

        $this->load->library('user'); 														// load the user library
	}

	public function index() {
		if (!$result = $this->Pages_model->getPage((int) $this->input->get('page_id'))) {
			show_404();
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($result['heading'], 'pages?page_id='.$result['page_id']);

		$this->template->setTitle($result['title']);
		$this->template->setHeading($result['heading']);
		$this->template->setMeta(array('name' => 'description', 'content' => $result['meta_description']));
		$this->template->setMeta(array('name' => 'keywords', 'content' => $result['meta_keywords']));
		$data['page_id'] 			= $result['page_id'];
		$data['text_heading'] 		= $result['heading'];
		$data['page_content'] 		= $result['content'];

        $data['page_popup'] 		= $this->input->get('popup');

        $this->template->render('pages', $data);
    }
}

/* End of file pages.php */
/* Location: ./main/controllers/pages.php */