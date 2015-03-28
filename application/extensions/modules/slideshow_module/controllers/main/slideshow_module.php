<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Slideshow_module extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Extensions_model');	    
		$this->load->library('language');
		$this->lang->load('slideshow_module/slideshow_module', $this->language->folder());
	}

	public function index() {
		if ( ! file_exists(EXTPATH .'modules/slideshow_module/views/main/slideshow_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
		
		$extension = $this->Extensions_model->getExtension('module', 'slideshow_module');
		
		if (!empty($extension['data'])) {
			$result = unserialize($extension['data']);
		} else {
			$result = array();
		}
		
		$data['dimension_h'] 		= (isset($result['dimension_h'])) ? $result['dimension_h'] : '360';
		$data['dimension_w'] 		= (isset($result['dimension_w'])) ? $result['dimension_w'] : '960';
		$data['effect'] 			= (isset($result['effect'])) ? $result['effect'] : 'ease';
		$data['speed'] 				= (isset($result['speed'])) ? $result['speed'] : '500';

		$data['images'] = array();
		if (!empty($result['images'])) {
			foreach ($result['images'] as $key => $value) {
				
				if (!empty($value)) {
					$name = basename($value);
					$this->load->model('Image_tool_model');
					$data['images'][$name] = $this->Image_tool_model->resize($value, $data['dimension_w'], $data['dimension_h']);
				}
			}
		}
		// pass array $data and load view files
		$this->load->view('slideshow_module/main/slideshow_module', $data);
	}		
}

/* End of file slideshow_module.php */
/* Location: ./application/extensions/modules/slideshow_module/controllers/main/slideshow_module.php */