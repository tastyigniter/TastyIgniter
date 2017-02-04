<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Page_anywhere_module extends Base_Component
{

	public function index() {
		$this->load->model('Pages_model');                                                        // load the menus model
		$this->lang->load('page_anywhere_module/page_anywhere_module');

		if (is_numeric($this->input->get('page_id'))) {
			$data['page_id'] = $this->input->get('page_id');
		} else {
			$data['page_id'] = 0;
		}

		$data['module_title'] = $this->setting('title', '');
		$data['heading'] = $this->setting('heading', $this->lang->line('_text_title'));

		$data['pages'] = array();
		$results = $this->Pages_model->getPages();                                        // retrieve all menu categories from getCategories method in Menus model
		foreach ($results as $result) {                                                            // loop through menu categories array

			if (in_array('side_bar', $result['navigation'])) {
				$data['pages'][] = array(                                                        // create array of category data to pass to view
					'page_id' => $result['page_id'],
					'name'    => $result['name'],
					'href'    => site_url('pages?page_id=' . $result['page_id']),
				);
			}
		}

		// pass array $data and load view files
		return $this->load->view('page_anywhere_module/page_anywhere_module', $data, TRUE);
	}
}

/* End of file Page_anywhere_module.php */
/* Location: ./extensions/pages_module/components/Page_anywhere_module.php */