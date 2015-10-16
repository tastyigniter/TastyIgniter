<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Featured_menus extends Main_Controller {

	public function index($ext_data = array()) {
		$this->load->model('Featured_menus_model'); 														// load the featured menus model
		$this->lang->load('featured_menus/featured_menus');

		if ( ! file_exists(EXTPATH .'featured_menus/views/featured_menus.php')) { 		//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

        if (!empty($ext_data['featured_menu'])) {
            $filter = array(
                'menu_ids'  => $ext_data['featured_menu'],
                'page'      => '1',
                'limit'     => '3',
                'dimension_w'     => isset($ext_data['dimension_w']) ? $ext_data['dimension_w'] : '400',
                'dimension_h'     => isset($ext_data['dimension_h']) ? $ext_data['dimension_h'] : '300',
            );
        } else {
            $filter = array();
		}

        $this->template->setStyleTag(extension_url('featured_menus/views/featured_menus.css'), 'featured_menus-css', '20150918');

        $data['featured_menus_alert']       = $this->alert->display('featured_menus_alert');

		$data['featured_menus'] = $this->Featured_menus_model->getByIds($filter);

		// pass array $data and load view files
		return $this->load->view('featured_menus/featured_menus', $data, TRUE);
	}
}

/* End of file featured_menus.php */
/* Location: ./extensions/featured_menus/controllers/featured_menus.php */