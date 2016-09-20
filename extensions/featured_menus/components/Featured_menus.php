<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Featured_menus extends Base_Component
{

	public function index() {
		$this->load->model('featured_menus/Featured_menus_model');                                                        // load the featured menus model
		$this->lang->load('featured_menus/featured_menus');

		if ($this->setting('featured_menu')) {
			$filter = array(
				'menu_ids'    => $this->settings['featured_menu'],
				'page'        => '1',
				'limit'       => $this->setting('limit', '3'),
				'dimension_w' => $this->setting('dimension_w', '400'),
				'dimension_h' => $this->setting('dimension_h', '300'),
			);
		} else {
			$filter = array();
		}

		$data['featured_menu_title'] = isset($this->settings['title']) ? $this->settings['title'] : $this->lang->line('text_featured_menus');
		$data['items_per_row'] = isset($this->settings['items_per_row']) ? $this->settings['items_per_row'] : '3';

		$this->assets->setStyleTag(extension_url('featured_menus/assets/featured_menus.css'), 'featured_menus-css', '20150918');

		$data['featured_menus_alert'] = $this->alert->display('featured_menus_alert');

		$data['featured_menus'] = $this->Featured_menus_model->getByIds($filter);

		// pass array $data and load view files
		return $this->load->view('featured_menus/featured_menus', $data, TRUE);
	}
}

/* End of file Featured_menus.php */
/* Location: ./extensions/featured_menus/components/Featured_menus.php */