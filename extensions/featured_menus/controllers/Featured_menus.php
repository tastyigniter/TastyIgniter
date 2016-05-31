<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Featured_menus extends Main_Controller {

	public function index($module = array()) {
		$this->load->model('Featured_menus_model'); 														// load the featured menus model
		$this->lang->load('featured_menus/featured_menus');

		if ( ! file_exists(EXTPATH .'featured_menus/views/featured_menus.php')) { 		//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		$ext_data = (!empty($module['data']) AND is_array($module['data'])) ? $module['data'] : array();

		if (!empty($ext_data['featured_menu'])) {
	        $filter = array(
		        'menu_ids'      => $ext_data['featured_menu'],
		        'page'          => '1',
		        'limit'         => isset($ext_data['limit']) ? $ext_data['limit'] : '3',
		        'dimension_w'   => isset($ext_data['dimension_w']) ? $ext_data['dimension_w'] : '400',
		        'dimension_h'   => isset($ext_data['dimension_h']) ? $ext_data['dimension_h'] : '300',
	        );
        } else {
            $filter = array();
		}

		$data['featured_menu_title'] = isset($ext_data['title']) ? $ext_data['title'] : $this->lang->line('text_featured_menus');
		$data['items_per_row'] = isset($ext_data['items_per_row']) ? $ext_data['items_per_row'] : '3';

        $this->template->setStyleTag(extension_url('featured_menus/views/featured_menus.css'), 'featured_menus-css', '20150918');

        $data['featured_menus_alert']       = $this->alert->display('featured_menus_alert');

		$data['featured_menus'] = $this->Featured_menus_model->getByIds($filter);

		// pass array $data and load view files
		return $this->load->view('featured_menus/featured_menus', $data, TRUE);
	}
}

/* End of file featured_menus.php */
/* Location: ./extensions/featured_menus/controllers/featured_menus.php */