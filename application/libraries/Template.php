<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
	
	private $doctype = '';
	private $title;
	private $heading;
	private $metas = array();
	private $link_tags = array();
	private $back_button = '';
	private $button_list = array();
	private $icon_list = array();
	private $regions = array();
	private $template;
    protected $_ci_controllers = array();
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('html');
	}
    
	public function setDocType($doctype = '') {
		$this->doctype = $doctype;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setHeading($heading) {
		$this->heading = $heading;
	}
	
	public function setMeta($metas) {
		$this->metas[] = $metas;
	}
	
	public function setLinkTag($href = '', $rel = 'stylesheet', $type = 'text/css') {
		$this->link_tags[] = link_tag($href, $rel, $type);
	}
	
	public function setBackButton($class, $href) {
		$this->back_button = '<a class="'.$class.'" href="'.$href.'"></a>';
	}
	
	public function setButton($name, $attributes = array()) {
		$attr = '';
		foreach ($attributes as $key => $value) {
			$attr .= ' '. $key .'="'. $value .'"';
		}

		$this->button_list[] = '<a'.$attr.'>'.$name.'</a>';
	}
	
	public function setIcon($icon) {
		$this->icon_list[] = $icon;
	}
	
	public function getDocType() {
		return doctype($this->doctype);
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getHeading() {
		return $this->heading;
	}
	
	public function getMetas() {
		return meta($this->metas);
	}
	
	public function getLinkTags() {
		$tags = '';
		foreach ($this->link_tags as $link_tag) {
			$tags .= $link_tag;
		}
		return $tags;
	}
	
	public function getBackButton() {
		return $this->back_button;
	}
	
	public function getButtonList() {
		$list = '';
		foreach ($this->button_list as $button) {
			$list .= $button;
		}
		return $list;
	}

	public function getIconList() {
		$list = '';
		foreach ($this->icon_list as $icon) {
			$list .= $icon;
		}
		return $list;
	}
	
	public function setTemplate($template) {
		$this->template = $template;
	}
	
	public function regions($regions = array()) {
		$this->regions = $regions;
	}

    public function render($template, $main_view, $vars = array()) {
		$this->setTemplate($template);

		$content = $this->loadViews($this->regions, $main_view, $vars);
		//$data = array_merge($region_vars, $vars);
		
    	return $content;
    }

    public function getRegions() {
		$data = array();
		
		if (!empty($this->regions)) {
			foreach ($this->regions as $region) {
				$data[$region] = $this->importController($this->template, $region);				
			}
		}
		
		return $data;	
	}

	public function loadViews($regions, $main_view, $vars) {
		$content = '';

		if (!empty($regions) AND is_array($regions)) {
			if (in_array('header', $regions)) {
				$content .= $this->CI->load->view($this->template .'header', $vars);
			}

			if (in_array('content_top', $regions)) {
				$content .= $this->CI->load->view($this->template .'content_top', $vars);
			}

			if (in_array('content_left', $regions)) {
				$content .= $this->CI->load->view($this->template .'content_left', $vars);
			}

			if (in_array('content_right', $regions)) {
				$content .= $this->CI->load->view($this->template .'content_right', $vars);
			}

			$content .= $this->CI->load->view($this->template.$main_view, $vars);
	
			if (in_array('footer', $regions)) {
				$content .= $this->CI->load->view($this->template .'footer', $vars);
			}
		}

        return $content;		
	}

	public function importController($template, $region) {
 		if (strpos($template, 'admin/') !== FALSE) {
			$region_path = 'admin/';
		} else {
			$region_path = 'main/';
		}
		
		$class = ucfirst($region);
	    $method = 'index';
	    $params = array();
		$file_path = APPPATH .'/controllers/'. $region_path . $region.'.php';

		if (file_exists($file_path)) {
			include_once($file_path);
            
			$cCI =& get_instance();
            $this->cCI->_ci_controllers[strtolower($class)] = new $class($params);
			$controller = $this->_ci_controllers[strtolower($class)];
			
			ob_start();
	        $result = call_user_func_array(array($controller, $method), $params);
			$buffer = ob_get_clean();
			return ($output !== NULL) ? $output : $buffer;
		} else {
			show_error('Unable to load the requested file: '. $region_path . $region.'.php');
		}
	} 	
}

// END Template Class

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */