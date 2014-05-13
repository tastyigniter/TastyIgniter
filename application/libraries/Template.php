<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
	
	private $regions = array();
	private $template = array();
	
	public function __construct() {
		$this->CI =& get_instance();
	}
    
	public function regions($regions = array()) {
		
		if (is_array($regions)) {
			$this->regions = $regions;
		}
	}

	public function set_template($template) {
		$this->template = $template;
	}
	
    public function load($template_name, $vars = array(), $return = FALSE) {

		$content = '';
		
		if (is_array($this->regions)) {
			foreach ($this->regions as $key => $value) {
				if ($value !== 'main/footer' AND $value !== 'admin/footer') {
					$content  .= $this->CI->load->view($value, $vars, $return);
				}
			}
		}
		
		$content .= $this->CI->load->view($template_name, $vars, $return);

		if (in_array('main/footer', $this->regions)) {
			$content .= $this->CI->load->view('main/footer', $vars, $return);
		} else if (in_array('admin/footer', $this->regions)) {
			$content .= $this->CI->load->view('admin/footer', $vars, $return);
        }
        
        return $content;
    }

    public function render($template, $main_view, $regions = array(), $vars = array()) {

		$this->set_template($template);
		
		$data = $this->get_regions($main_view, $regions, $vars);
		
		return $data;
    }

    public function get_regions($main_view, $regions = array(), $vars = array()) {
		$content = '';

		if (!empty($regions) AND is_array($regions)) {
			if (in_array('header', $regions)) {
				$content  .= $this->CI->load->view($this->template.'header', $vars, FALSE);
			}
			
			if (in_array('content_top', $regions)) {
				$content  .= $this->CI->load->view($this->template.'content_top', $vars, FALSE);
			}
			
			if (in_array('content_left', $regions)) {
				$content  .= $this->CI->load->view($this->template.'content_left', $vars, FALSE);
			}
			
			if (in_array('content_right', $regions)) {
				$content  .= $this->CI->load->view($this->template.'content_right', $vars, FALSE);
			}
			
			$content  .= $this->CI->load->view($this->template.$main_view, $vars, FALSE);
			
			if (in_array('footer', $regions)) {
				$content  .= $this->CI->load->view($this->template.'footer', $vars, FALSE);
			}
		}

        return $content;
	}
}

// END Template Class

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */