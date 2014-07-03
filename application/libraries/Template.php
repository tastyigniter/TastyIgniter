<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Template {
	
	private $template;
	private $template_path;
	private $doctype = '';
	private $title;
	private $heading;
	private $metas = array();
	private $link_tags = array();
	private $script_tags = array();
	private $back_button = '';
	private $button_list = array();
	private $icon_list = array();
	private $regions = array();
    protected $_ci_controllers = array();
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('html');
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
	
	public function getScriptTags() {
		$tags = '';
		foreach ($this->script_tags as $script_tag) {
			$tags .= $script_tag;
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
	
	public function setTemplate($template = '') {
		if ($template != '') {
			$this->template = trim($template, '/');
		}
	}
	
	public function setTemplatePath($template_path = '') {
		if ($template_path != '') {
			$this->template_path = rtrim($template_path, '/').'/';
		}
	}
	
	public function setDocType($doctype = '') {
		$this->doctype = $doctype;
	}
	
	public function setMeta($metas) {
		$this->metas[] = $metas;
	}
	
	public function setLinkTag($href = '', $rel = 'stylesheet', $type = 'text/css') {
		if ($href != '') {
			$href = APPPATH .'views/themes/'. $this->template .'/'. $href;
			$this->link_tags[] = link_tag($href, $rel, $type);
		}
	}
	
	public function setScriptTag($href = '') {
		if ($href != '') {
			$href = APPPATH .'views/themes/'. $this->template .'/'. $href;
			$this->script_tags[] = $this->_script_tag($href);
		}
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setHeading($heading) {
		$this->heading = $heading;
	}
	
	public function setBackButton($class, $href) {
		$this->back_button = '<a class="'.$class.'" href="'.$href.'"><b class="fa fa-caret-left"></b></a>';
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
	
	public function regions($regions = array()) {
		$this->regions = $regions;
	}

    public function render($template_path, $main_view, $vars = array()) {
		$this->setTemplatePath($template_path);

	   	return $this->getViews($this->regions, $main_view, $vars);
    }

	public function getViews($regions, $main_view, $vars) {
		$content = array();

		if (!empty($regions) AND is_array($regions)) {
			if (in_array('header', $regions)) {
				$content['header'] = $this->CI->load->view($this->template_path .'header', $vars, TRUE);
			}

			if (in_array('content_top', $regions)) {
				$content['content_top'] = $this->CI->load->view($this->template_path .'content_top', $vars, TRUE);
			}

			if (in_array('content_left', $regions)) {
				$content['content_left'] = $this->CI->load->view($this->template_path .'content_left', $vars, TRUE);
			}

			if (in_array('content_right', $regions)) {
				$content['content_right'] = $this->CI->load->view($this->template_path .'content_right', $vars, TRUE);
			}
	
			if (in_array('footer', $regions)) {
				$content['footer'] = $this->CI->load->view($this->template_path .'footer', $vars, TRUE);
			}
		}

		$content = array_merge($content, $vars);
		$content = $this->CI->load->view($this->template_path.$main_view, $content);

        return $content;		
	}

	public function _script_tag($href = '') {
		$str = '<script type="text/javascript" charset="'.strtolower($this->CI->config->item('charset')).'"';
		$str .= ($href == '') ? '>' : ' src="'.base_url($href).'">';
		$str .= '</script>';
		return $str;
	}
}

// END Template Class

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */