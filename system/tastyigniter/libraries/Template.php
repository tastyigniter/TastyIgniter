<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Template {

	private $_module = '';
	private $_controller = '';
	private $_method = '';

	private $_theme = NULL;
	private $_theme_path = NULL;
	private $_theme_locations = array();
	private $_theme_shortpath = NULL;
	private $_partials = array();

	private $_parser_enabled = TRUE;
	private $_parser_body_enabled = TRUE;

	private $doctype = '';
	private $title = '';
	private $heading = '';
	private $breadcrumbs = array();
	private $_breadcrumb_divider = '';
	private $_breadcrumb_tag_open = '';
	private $_breadcrumb_tag_close = '';
	private $_breadcrumb_link_open = '';
	private $_breadcrumb_link_close = '';

	private $_title_separator = ' | ';
	private $metas = array();
	private $link_tags = array();
	private $script_tags = array();
	private $back_button = '';
	private $button_list = array();
	private $icon_list = array();
    private $is_loaded = array();

    private $error_string = '';


	private $CI;

	private $_data = array();

	/**
	 * Constructor - Sets Preferences
	 *
	 * The constructor can be passed an array of config values
	 */
	public function __construct($config = array()) {
		$this->CI =& get_instance();
		$this->CI->load->helper('html');

		if ( ! empty($config)) {
			$this->initialize($config);
		}

		log_message('debug', 'Template Class Initialized');
	}

	public function initialize($config = array()) {
		// initialize config
		foreach ($config as $key => $val) {
			$this->{'_'.$key} = $val;
		}

		unset($config);

		// No locations set in config?
		if ($this->_theme_locations === array()) {
			// Let's use this obvious default
			$this->_theme_locations = array(VIEWPATH . 'themes/');
		}

		// Theme was set
		if ($default_theme = $this->CI->config->item(APPDIR, 'default_themes')) {
			$this->setTheme($default_theme);
		}

		// If the parse is going to be used, best make sure it's loaded
		if ($this->_parser_enabled === TRUE) {
			$this->CI->load->library('parser');
		}

		// Modular Separation / Modular Extensions has been detected
		if (method_exists( $this->CI->router, 'fetch_module' )) {
			$this->_module 	= $this->CI->router->fetch_module();
		}

		// What controllers or methods are in use
		$this->_controller	= $this->CI->router->fetch_class();
		$this->_method 		= $this->CI->router->fetch_method();

		// Load user agent library if not loaded
		$this->CI->load->library('user_agent');

		// We'll want to know this later
		$this->_is_mobile	= $this->CI->agent->is_mobile();
	}

    public function render($view, $data = array(), $return = FALSE) {

		if ($this->_theme === '') {
			show_error('Unable to find the requested theme configuration:');
		}

		if (!file_exists(VIEWPATH .'themes/'.$this->_theme.'/')) {
			show_error('Unable to locate the requested theme folder');
		}

		if (!file_exists(VIEWPATH .'themes/'.$this->_theme.'/'.$view.'.php')) {
			show_error('Unable to load the requested file: '.$view.'.php');
		}

		// Set whatever values are given. These will be available to all view files
		is_array($data) OR $data = (array) $data;

		// Merge in what we already have with the specific data
		$this->_data = array_merge($this->_data, $data);

		// We don't need you any more buddy
		unset($data);

		// Output template variables to the template
		$template['breadcrumbs'] 	= $this->breadcrumbs; //*** future reference

		foreach ($this->_partials as $partial) {
			$template[$partial] = $this->_loadPartials($partial, $this->_data);
		}

		if ($this->CI->config->item('cache_mode') == '1') {
			$this->CI->output->cache($this->CI->config->item('cache_time'));
		}
		// Want it returned or output to browser?
		//if ( ! $return) {

			//$this->CI->output->set_output($this->_data);
		//}

		$this->CI->load->view('themes/'.$this->_theme.'/'.$view, $this->_data + $template, $return);
	   	//return $this->getViews($this->_partials, $view, $data);
    }

	public function setTheme($theme = '') {
		$this->_theme = trim($theme, '/');

		foreach ($this->_theme_locations as $location) {
			if ($this->_theme AND file_exists($location.$this->_theme)) {
				$this->_theme_path = rtrim($location.$this->_theme.'/');
				$this->_theme_shortpath = APPDIR.'/views/themes/'.$this->_theme;
				break;
			}
		}

		return $this;
	}

	public function setPartials($partials = array()) {
		foreach ($partials as $partial) {
			if (!file_exists($this->_theme_path.$partial.'.php')) {
				show_error('Unable to load the requested partial file: '.$partial.'.php');
			}
		}

		$this->_partials = $partials;
		return $this;
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

	public function getCustomStyle($custom_path = '') {
		//return $this->_customStyle($custom_path);
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

	public function getBreadcrumb() {
		$out = $this->_breadcrumb_tag_open;

		foreach ($this->_breadcrumbs as $crumb) {
            $out .= str_replace('{link}', site_url(trim($crumb['uri'], '/')), $this->_breadcrumb_link_open);
			$out .= $crumb['name'];
			$out .= $this->_breadcrumb_link_close;
		}

		$out .= $this->_breadcrumb_tag_close;

		return $out;
	}

	public function setDocType($doctype = '') {
		$this->doctype = $doctype;
	}

	public function setMeta($metas) {
		$this->metas[] = $metas;
	}

	public function setLinkTag($href = '', $rel = 'stylesheet', $type = 'text/css') {
		if ($href != '') {
			$href = $this->_theme_shortpath .'/'. $href;
			$this->link_tags[] = link_tag(root_url($href), $rel, $type);
		}
	}

	public function setScriptTag($href = '') {
		if ($href != '') {
			$href = $this->_theme_shortpath .'/'. $href;
			$script_tag = '<script type="text/javascript" charset="'.strtolower($this->CI->config->item('charset')).'"';
			$script_tag .= ($href == '') ? '>' : ' src="'.root_url($href).'">';
			$script_tag .= '</script>';
			$this->script_tags[] = $script_tag;
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

	/**
	 * Helps build breadcrumb links
	 *
	 * @access	public
	 * @param	string	$name		What will appear as the link text
	 * @param	string	$url_ref	The URL segment
	 * @return	void
	 */
	public function setBreadcrumb($name, $uri = '') {
		$this->_breadcrumbs[] = array('name' => $name, 'uri' => $uri );
		return $this;
	}

	private function _loadPartials($view, $data = array()) {
		$partial_contents = array('content_top', 'content_bottom', 'content_right', 'content_left');
		if ( ! empty($this->_theme)) {
			$modules = array();

			foreach ($this->_theme_locations as $location) {
				$theme_view = 'themes/' . $this->_theme .'/'. $view;

				if (file_exists($location . $this->_theme .'/'. $view . '.php')) {
					if (in_array($view, $partial_contents)) {
						$this->CI->load->library('extension');

						$partial = explode('_', $view);
						$data['module_position'] = $position = isset($partial[1]) ? $partial[1] : '';

						$modules = $this->CI->Extensions_model->getModulesByPosition($position, $this->CI->uri->segment_array());

						if (!empty($modules)) {
							foreach ($modules as $module) {
								$data[$position.'_modules'][] = Modules::run($module['name'] .'/'. $module['name'] .'/index', $data + $module['ext_data']);
							}
						} else {
							return NULL;
						}
					}

					return $this->CI->load->view($theme_view, $data, TRUE);
				}
			}
		}
	}

	private function _customStyle($custom_path = '') {
		$href = $this->_theme_shortpath .'/'. $custom_path;

		if (file_exists($href) AND is_file($href)) {
			$active_style = (strtolower(APPDIR) === 'main') ? $this->CI->config->item('main_active_style') : $this->CI->config->item('admin_active_style');

			if (!empty($active_style) and is_array($active_style)) {
				//include($href);
				$custom_style_path = 'themes/' . $this->_theme .'/'. $custom_path;
				return $this->CI->load->view($custom_style_path, $active_style, TRUE);
			}
		}
	}
}

// END Template Class

/* End of file Template.php */
/* Location: ./system/tastyigniter/libraries/Template.php */