<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
	
	private $regions = array();
	
	public function __construct() {
		$this->CI =& get_instance();
	}
    
	public function regions($regions = array()) {
		
		if (is_array($regions)) {
			$this->regions = $regions;
		}
	}
	
    public function load($template_name, $vars = array(), $return = FALSE) {

		$content = '';
		
		if (is_array($this->regions)) {
			foreach ($this->regions as $key => $value) {
				if ($value !== 'main/footer' && $value !== 'admin/footer') {
					$content  .= $this->CI->load->view($value, $vars, $return);
				}
			}
		}
		
		$content .= $this->CI->load->view($template_name, $vars, $return);

		if (in_array('main/footer', $this->regions)) {
			$content .= $this->CI->load->view('main/footer', $vars, $return);
		}
		
		if (in_array('admin/footer', $this->regions)) {
			$content .= $this->CI->load->view('admin/footer', $vars, $return);
        }
        
        return $content;
    }

	public function fetch($filename) {
		$file = APPPATH .'controllers/'. $filename .'.php';
    
		if (file_exists($file)) {
			//extract($data);
			
      		ob_start();
      
	  		include($file);
      
	  		$content = ob_get_contents();

      		ob_end_clean();

			//return $this->CI->load->view($filename, $content);
      		return $content;
    	} else {
			show_error('Error: Could not load template '.$file.'!');
			exit();				
    	}	
	}
}