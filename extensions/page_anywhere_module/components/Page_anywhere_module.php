<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Page_anywhere_module extends Base_Component
{
	public function index() {
		$this->load->model('Pages_model');
		$this->load->model('Page_anywhere_model');
		$this->lang->load('page_anywhere_module/page_anywhere_module');

		$currentLayoutId = isset($this->properties['layout_id']) ? $this->properties['layout_id'] : null;
		$currentPartialName = isset($this->properties['partial']) ? $this->properties['partial'] : null;

		$data['module_title'] = $this->setting('title', '');
		$data['heading'] = $this->setting('heading', $this->lang->line('_text_title'));

		$data['placedPages'] = array();
		$results = $this->Page_anywhere_model->getPageAnywhereRefs();

		foreach ($results as $result) {
			if ($result['layout_id'] === $currentLayoutId && $result['partial'] === $currentPartialName) {
				$foundPage = $this->Pages_model->getPage($result['page_id']);

				if ($foundPage) {
					$data['placedPages'][] = $foundPage;
				}
			}
		}

		// pass array $data and load view files
		return $this->load->view('page_anywhere_module/page_anywhere_module', $data, TRUE);
	}
}

/* End of file Page_anywhere_module.php */
/* Location: ./extensions/page_anywhere_module/components/Page_anywhere_module.php */