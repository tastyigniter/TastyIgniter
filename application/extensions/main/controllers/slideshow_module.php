<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slideshow_module extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
	}

	public function index() {
		$this->lang->load('main/slideshow_module');  											// loads language file
		
		if ( !file_exists(EXTPATH .'main/views/slideshow_module.php')) { 						//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
		
		if ($this->config->item('slideshow_module')) {
			$result = $this->config->item('slideshow_module');
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
		$this->load->view('main/slideshow_module', $data);
	}		
}