<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Page_anywhere_module extends Base_Component
{

	public function index() {
		$this->load->model('Page_anywhere_model');                                                   // load the menus model
		$this->lang->load('page_anywhere_module/page_anywhere_module');

		if (is_numeric($this->input->get('page_id'))) {
			$data['page_id'] = $this->input->get('page_id');
		} else {
			$data['page_id'] = 0;
		}

		$data['module_title'] = $this->setting('title', '');
		$data['heading'] = $this->setting('heading', $this->lang->line('_text_title'));

		$data['placedPages'] = array();
		$results = $this->Page_anywhere_model->getPageAnywhereRefs();
		foreach ($results as $result) {
			if ($result['page_id'] === $data['page_id']) {
				$data['placedPages'][] = $result;
			}
		}

		// pass array $data and load view files
		return $this->load->view('page_anywhere_module/page_anywhere_module', $data, TRUE);
	}
}

/* End of file Page_anywhere_module.php */
/* Location: ./extensions/page_anywhere_module/components/Page_anywhere_module.php */