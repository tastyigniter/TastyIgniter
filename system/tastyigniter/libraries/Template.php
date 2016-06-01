<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Template.php
 * @link           http://docs.tastyigniter.com
 */
class Template {

	private $_module = '';
	private $_controller = '';
	private $_method = '';
	private $_parent_theme = NULL;
	private $_theme = NULL;
	private $_theme_path = NULL;
	private $_theme_shortpath = NULL;
	private $_theme_locations = array();
	private $_partial_areas = array();
	private $_layouts = array();
	private $_partials = array();
	private $_modules = array();
	private $_title_separator = ' | ';
	private $_data = array();
	private $_head_tags = array();
	private $_active_styles = '';
	private $_breadcrumbs = array();
	private $_theme_config = array();

	private $CI;

	/**
	 * Constructor - Sets Preferences
	 *
	 * The constructor can be passed an array of config values
	 * @param array $config
	 */
	public function __construct($config = array()) {
		$this->CI =& get_instance();
		$this->CI->load->helper('html');
		$this->CI->load->helper('string');

		if ( ! empty($config)) {
			$this->initialize($config);
		}

		log_message('info', 'Template Class Initialized');
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
			$this->_theme_locations = array(THEMEPATH);
		}

		// Set default theme
		if ($default_theme = $this->CI->config->item(APPDIR, 'default_themes')) {
			$this->setTheme($default_theme);
		}

		// Load the theme config and store array in $this->_theme_config
		$this->_theme_config = load_theme_config($this->_theme, APPDIR);

		// Set the parent theme if theme is child
		$this->_parent_theme = (isset($this->_theme_config['parent'])) ? $this->_theme_config['parent'] : '';

		// Modular Separation / Modular Extensions has been detected
		if (method_exists( $this->CI->router, 'fetch_module' )) {
			$this->_module 	= $this->CI->router->fetch_module();
		}

		// What controllers or methods are in use
		$this->_controller	= $this->CI->router->fetch_class();
		$this->_method 		= $this->CI->router->fetch_method();

		if (!empty($this->_theme_config['head_tags'])) {
			$this->setHeadTags($this->_theme_config['head_tags']);
		}

		$this->setPartialArea();

		// Set the modules for this layout using the current URI segments
		!empty($this->_modules) OR $this->_modules = $this->getLayoutModules();

		// Load user agent library if not loaded
		$this->CI->load->library('user_agent');
	}

	public function render($view, $data = array(), $return = FALSE) {
		// Set whatever values are given. These will be available to all view files
		is_array($data) OR $data = (array) $data;

		// Merge in what we already have with the specific data
		$this->_data = array_merge($this->_data, $data);

		// We don't need you any more buddy
		unset($data);

		// Output template variables to the template
		$template['title'] 	        = $this->_head_tags['title'];
		$template['breadcrumbs'] 	= $this->_breadcrumbs;              //*** future reference

		// Assign by reference, as all loaded views will need access to partials
		$this->_data['template'] =& $template;
		$this->_data['controller'] = $this->_controller;

		// Load the layouts and partials variables
		$this->fetchPartials();

		// Lets do the caching instead of the browser
		if ($this->CI->config->item('cache_mode') === '1') {
//			$this->CI->output->cache($this->CI->config->item('cache_time'));
		}

		// Want it returned or output to browser?
		if ( ! $return) {
			self::_load_view($view, $this->_data, NULL, FALSE);
		} else {
			return self::_load_view($view, $this->_data, NULL);
		}
	}

	public function navMenu($prefs = array()) {
		$container_open = '<ul class="nav" id="side-menu">';
		$container_close = '</ul>';

		extract($prefs);

		// Bail out if nav_menu theme config item is missing or not an array
		if ( ! is_array($this->_theme_config['nav_menu'])) {
			return NULL;
		}

		return $container_open . $this->_buildNavMenu($this->_theme_config['nav_menu']) . $container_close;
	}

	protected function _buildNavMenu($nav_menu = array(), $has_child = 0) {
		$levels = array('', 'nav-second-level', 'nav-third-level');

		$out = '';
		foreach ($nav_menu as $menu) {
			if (isset($menu['permission'])) {
				$permission = (strpos($menu['permission'], '|') !== FALSE) ? explode('|', $menu['permission']) : array($menu['permission']);

				$permitted = array();
				foreach ($permission as $perm) {
					$permitted[strtolower($perm)] = ( ! $this->CI->user->hasPermission($perm.'.Access')) ? FALSE : TRUE;
				}

				if (!($permitted = array_filter($permitted))) continue;
			}

			$out .= '<li>'.$this->_buildNavMenuLink($menu);

			if (isset($menu['child']) AND is_array($menu['child'])) {
				$has_child += 1;

				$child_links = $this->_buildNavMenu($menu['child'], $has_child);
				$out .= '<ul class="nav '. $levels[$has_child] .'">' . $child_links . '</ul>';

				$has_child = 0;
			}

			$out .= '</li>';
		}

		return $out;
	}

	protected function _buildNavMenuLink($menu_link = array()) {
		$out = '<a';

		if (isset($menu_link['class'])) {
			$out .= ' class="'.$menu_link['class'].'"';
		}

		if (isset($menu_link['href'])) {
			$out .= ' href="'.$menu_link['href'].'"';
		}

		$out .= '>';
		if (isset($menu_link['icon'])) {
			$out .= '<i class="fa '.$menu_link['icon'].' fa-fw"></i>';
		} else {
			$out .= '<i class="fa fa-square-o fa-fw"></i>';
		}

		if (isset($menu_link['icon']) AND isset($menu_link['title'])) {
			$out .= '<span class="content">'.$menu_link['title'].'</span>';
		} else {
			$out .= $menu_link['title'];
		}

		if (isset($menu_link['child'])) {
			$out .= '<span class="fa arrow"></span>';
		}

		$out .= '</a>';

		return $out;
	}

	public function setTheme($theme = '') {
		$this->_theme = trim($theme, '/');

		if ($theme_location = $this->getThemeLocation($this->_theme)) {
			$this->_theme_path = rtrim($theme_location . $this->_theme);
			$this->_theme_shortpath = APPDIR . '/views/themes/' . $this->_theme;
		} else {
			show_error('Unable to locate the active theme: '.APPDIR . '/views/themes/' . $this->_theme);
		}
	}

	public function setPartialArea() {
		$partial_areas = isset($this->_theme_config['partial_area']) ? $this->_theme_config['partial_area'] : $this->_partial_areas;

		foreach ($partial_areas as $partial_area) {
			$id = isset($partial_area['id']) ? $partial_area['id'] : $partial_area;
			$this->_partial_areas[$id] = $partial_area;
		}

		$this->_layouts = array('header' => array(), 'footer' => array());

		return $this;
	}

	private function setHeadTags($head_tags = array()) {
		$head_tags['meta'][] = array('name' => 'description', 'content' => config_item('meta_description'));
		$head_tags['meta'][] = array('name' => 'keywords', 'content' => config_item('meta_keywords'));

		if (!empty($head_tags)) {
			foreach ($head_tags as $type => $value) {
				if ($type) {
					$this->setHeadTag($type, $value);
				}
			}
		}
	}

	public function getPartialView($view = '', $replace = array()) {
		$partial = empty($this->_partials[$view]) ? $this->fetchPartials($view) : $this->_partials[$view];

		$partial_class = !empty($partial['data']['class']) ? $partial['data']['class'] : '';
		$partial_class = !empty($replace['class']) ? $replace['class'] : $partial_class;

		$partial_data = isset($partial['data']['open_tag']) ? str_replace('{id}', str_replace('_', '-', $view), str_replace('{class}', $partial_class, $partial['data']['open_tag'])) : '';
		$partial_data .= empty($partial['view']) ? '' : $partial['view'];
		$partial_data .= isset($partial['data']['close_tag']) ? $partial['data']['close_tag'] : '';

		return $partial_data;
	}

	public function getDocType() {
		return isset($this->_head_tags['doctype']) ? $this->_head_tags['doctype'] : '';
	}

	public function getFavIcon() {
		return isset($this->_head_tags['favicon']) ? $this->_head_tags['favicon'] : '';
	}

	public function getMetas() {
		return is_array($this->_head_tags['meta']) ? implode("\t\t", $this->_head_tags['meta']) : '';
	}

	public function getTitle() {
		return isset($this->_head_tags['title']) ? $this->_head_tags['title'] : '';
	}

	public function getHeading() {
		$heading = '';
		if (isset($this->_head_tags['heading'])) {
			if (count($heading_array = explode(':', $this->_head_tags['heading'])) === 2) {
				$heading = $heading_array[0] . '&nbsp;&nbsp;<small>' . $heading_array[1] . '</small>';
			} else {
				$heading = $this->_head_tags['heading'];
			}
		}

		return $heading;
	}

	public function getButtonList() {
		return is_array($this->_head_tags['buttons']) ? implode("\n\t\t", $this->_head_tags['buttons']) : '';
	}

	public function getIconList() {
		return is_array($this->_head_tags['icons']) ? implode("\n\t\t", $this->_head_tags['icons']) : '';
	}

	public function getStyleTags() {
		return is_array($this->_head_tags['style']) ? implode("\t\t", $this->_head_tags['style']) : '';
	}

	public function getScriptTags() {
		return is_array($this->_head_tags['script']) ? implode("\n\t\t", $this->_head_tags['script']) : '';
	}

	public function getBreadcrumb($tag_open = '<li class="{class}">', $link_open = '<a href="{link}">', $link_close = ' </a>', $tag_close = '</li>') {
		$crumbs = '';

		foreach ($this->_breadcrumbs as $crumb) {
			if (!empty($crumb['uri'])) {
				$crumbs .= str_replace('{class}', '', $tag_open) . str_replace('{link}', site_url(trim($crumb['uri'], '/')), $link_open) . $crumb['name'] . $link_close;
			} else {
				$crumbs .= str_replace('{class}', 'active', $tag_open) . '<span>'.$crumb['name'].' </span>';
			}

			$crumbs .= $tag_close;
		}

		return (!empty($crumbs)) ? '<ol class="breadcrumb">' .  $crumbs . '</ol>' : $crumbs;
	}

	public function getActiveStyle() {
		// Compile the customizer styles
		$this->_active_styles = $this->_compileActiveStyle();

		return $this->_active_styles . "\n\t\t";
	}

	public function getActiveThemeOptions($item = NULL) {
		if ($this->CI->config->item(strtolower(APPDIR), 'active_theme_options')) {
			$active_theme_options = $this->CI->config->item(strtolower(APPDIR), 'active_theme_options');
		} else if ($this->CI->config->item(strtolower(APPDIR), 'customizer_active_style')) {
			$active_theme_options = $this->CI->config->item(strtolower(APPDIR), 'customizer_active_style');
		}

		if (empty($active_theme_options) OR !isset($active_theme_options[0]) OR !isset($active_theme_options[1])) {
			return NULL;
		}

		if ($active_theme_options[0] !== $this->_theme) {
			return NULL;
		}

		$theme_options = NULL;
		if (is_array($active_theme_options[1])) {
			$theme_options = $active_theme_options[1];
		}

		if ($item === NULL) {
			return $theme_options;
		} else if (isset($theme_options[$item])) {
			return $theme_options[$item];
		} else {
			return NULL;
		}
	}

	public function setHeadTag($type = '', $tag = '') {
		if ($type) switch ($type) {
			case 'doctype':
				$this->setDocType($tag);
				break;
			case 'favicon':
				$this->setFavIcon($tag);
				break;
			case 'meta':
				$this->setMeta($tag);
				break;
			case 'style':
				$this->setStyleTag($tag);
				break;
			case 'script':
				$this->setScriptTag($tag);
				break;
			default :
				$this->_head_tags[$type] = $tag;
		}
	}

	public function setDocType($doctype = '') {
		$this->_head_tags['doctype'] = doctype($doctype). PHP_EOL;
	}

	public function setFavIcon($href = '') {
		if ($href != '' AND is_string($href)) {
			$this->_head_tags['favicon'] = link_tag($this->prepUrl($href), 'shortcut icon', 'image/ico');
		}
	}

	public function setMeta($metas = array()) {
		$metas = meta($metas);
		array_unshift($this->_head_tags['meta'], $metas);
	}

	public function setTitle() {
		if (func_num_args() >= 1) {
			$this->_head_tags['title'] = implode($this->_title_separator, func_get_args());
		}
	}

	public function setHeading($heading = '') {
		$this->_head_tags['heading'] = $heading;
	}

	public function setButton($name, $attributes = array()) {
		$attr = '';
		foreach ($attributes as $key => $value) {
			$attr .= ' '. $key .'="'. $value .'"';
		}

		$this->_head_tags['buttons'][] = '<a'.$attr.'>'.$name.'</a>';
	}

	public function setIcon($icon) {
		$this->_head_tags['icons'][] = $icon;
	}

	public function setStyleTag($href = '', $name = '', $priority = NULL, $suffix = '') {
		if ( ! is_array($href)) {
			$href = array($priority => array('href' => $href, 'name' => $name, 'rel' => 'stylesheet', 'type' => 'text/css'));
		} else if (isset($href[0]) AND is_string($href[0])) {
			$name = (isset($href[1])) ? $href[1] : '';
			$priority = (isset($href[2])) ? $href[2] : '';

			$href = array($priority => array('href' => $href[0], 'name' => $name, 'rel' => 'stylesheet', 'type' => 'text/css'));
		} else if (isset($href['href'])) {
			$priority = (isset($href['priority'])) ? $href['priority'] : '';
			unset($href['priority']);
			$href = array($priority => $href);
		}

		foreach ($href as $priority => $tag) {
			if (isset($tag['href'])) {
				!empty($suffix) OR $suffix = 'ver='.TI_VERSION;

				$tag['href'] = $this->prepUrl($tag['href'], $suffix);
				if (!empty($tag['name'])) {
					$tag['id'] = $tag['name'];
				}

				unset($tag['name']);
				$priority = (empty($priority)) ? random_string('numeric', 4) : $priority;
				$this->_head_tags['style'][$priority] = link_tag($tag);
				ksort($this->_head_tags['style']);
			} else {
				$this->setStyleTag($tag);
			}
		}
	}

	public function setScriptTag($href = '', $name = '', $priority = NULL, $suffix = '') {
		$charset = strtolower($this->CI->config->item('charset'));

		if ( ! is_array($href)) {
			$href = array($priority => array('src' => $href, 'name' => $name, 'charset' => $charset, 'type' => 'text/javascript'));
		} else if (isset($href[0]) AND is_string($href[0])) {
			$href[1] = (isset($href[1])) ? $href[1] : '';
			$priority = (isset($href[2])) ? $href[2] : '';

			$href = array($priority => array('src' => $href[0], 'name' => $href[1], 'charset' => $charset, 'type' => 'text/javascript'));
		} else if (isset($href['src'])) {
			$priority = (isset($href['priority'])) ? $href['priority'] : '';
			unset($href['priority']);
			$href = array($priority => $href);
		}

		foreach ($href as $priority => $tag) {
			if (isset($tag['src'])) {
				!empty($suffix) OR $suffix = 'ver='.TI_VERSION;

				$tag['src'] = $this->prepUrl($tag['src'], $suffix);

				if (!empty($tag['name'])) {
					$tag['id'] = $tag['name'];
				}
				unset($tag['name']);

				$script_tag = '';
				foreach ($tag as $k => $v) {
					$script_tag .= $k.'="'.$v.'" ';
				}

				$priority = (empty($priority)) ? random_string('numeric', 4) : $priority;
				$this->_head_tags['script'][$priority] = '<script ' . $script_tag . '></script>';
				ksort($this->_head_tags['script']);
			} else {
				$this->setScriptTag($tag);
			}
		}
	}

	public function setBreadcrumb($name, $uri = '') {
		$this->_breadcrumbs[] = array('name' => $name, 'uri' => $uri );
		return $this;
	}

	public function getThemeLocation($theme = NULL) {
		$theme OR $theme = $this->_theme;

		foreach ($this->_theme_locations as $location) {
			if (is_dir($location . $theme)) {
				return $location;
			}
		}

		return FALSE;
	}

	public function getLayoutModules() {
		list($uri_route, $layout_modules) = $this->_getLayoutModules();

		$modules = $this->CI->extension->getModules();

		$_modules = array();
		foreach ($layout_modules as $partial => $partial_modules) {
			foreach ($partial_modules as $layout_module) {
				if (isset($layout_module['module_code']) AND !empty($modules[$layout_module['module_code']])) {
					$module = $modules[$layout_module['module_code']];

					if ($module['name'] === $layout_module['module_code'] AND $layout_module['status'] === '1') {

						$partial = in_array($layout_module['partial'], array('top', 'left', 'right', 'bottom')) ? 'content_'.$layout_module['partial'] : $layout_module['partial'];

						$_modules[$partial][] = array(
							'name'                => $module['name'],
							'layout_id'		      => $layout_module['layout_id'],
							'uri_route'           => $uri_route,
							'partial'             => $partial,
							'priority'            => $layout_module['priority'],
							'status'              => $module['status'],
							'data'                => $module['ext_data'],
							'title'               => $layout_module['title'],
							'fixed'               => $layout_module['fixed'],
							'fixed_top_offset'    => $layout_module['fixed_top_offset'],
							'fixed_bottom_offset' => $layout_module['fixed_bottom_offset'],
						);
					}

				}
			}
		}

		return $_modules;
	}

	public function loadView($view, $data = array()) {
		if (is_string($view)) {
			return $this->_load_view($view, (array) $data);
		}
	}

	private function fetchPartials($partial = '') {
		$partial_areas = array_merge($this->_partial_areas, $this->_layouts);

		if (!empty($partial)) $partial_areas = array($partial => isset($partial_areas[$partial]) ? $partial_areas[$partial] : array());

		if (empty($partial_areas)) return NULL;

		foreach ($partial_areas as $partial_name => $partial_data) {
			$partial_view = NULL;

			if (!is_string($partial_name)) continue;

			if (isset($this->_layouts[$partial_name])) {
				$partial_view = $this->_load_view($partial_name, $partial_data);
			} else {
				// We stop here if no module was found.
				if (empty($this->_modules[$partial_name])) continue;

				$this->sortModules($partial_name);
				$count = 1;
				foreach ($this->_modules[$partial_name] as $module) {
					$partial_view .= $this->buildPartialModule($module, $this->_data, $partial_data, $count);
					$count++;
				}
			}

			$this->_partials[$partial_name] = array('data' => $partial_data, 'view' => $partial_view);
		}

		if (empty($partial)) {
			return $this->_partials;
		} else if (isset($this->_partials[$partial])) {
			return $this->_partials[$partial];
		} else {
			return array('data' => NULL, 'view' => NULL);
		}
	}

	private function _getLayoutModules() {
		$routes = array($this->CI->uri->segment_array(), $this->CI->uri->uri_string(),
			$this->CI->uri->rsegment_array(), $this->CI->uri->ruri_string());

		if (!$this->CI->uri->segment(2) AND in_array('index', $this->CI->uri->rsegment_array())) {
			array_push($routes, $this->CI->uri->rsegment(1) . '/' . $this->CI->uri->rsegment(1));
		}

		if (APPDIR === ADMINDIR OR empty($routes)) return array(NULL, array());

		$segments = array();
		foreach ($routes as $key => $route) {
			if ($route === 'pages') {
				$segments[] = (int)$this->CI->input->get('page_id');
			} else if (is_array($route)) {
				$val = '';
				foreach ($route as $value) {
					if ($value === 'index') continue;

					$val = $val .'/'. $value;
					$segments[] .= trim($val, '/');
				}
			} else if ($route !== 'index') {
				$segments[] = $route;
			}
		}

		$this->CI->load->model('Layouts_model');
		$layout_modules = $this->CI->Layouts_model->getRouteLayoutModules($segments);

		// Lets break the look if a layout was found.
		$uri_route = isset($layout_modules['uri_route']) ? $layout_modules['uri_route'] : '';
		if (!empty($layout_modules)) {
			return array($uri_route, $layout_modules);
		}

		// We return null if no layout was found.
		return array(NULL, array());
	}

	private function _find_view_path($view = '') {
		if ( ! empty($this->_theme)) {
			$theme_views = array('/', '/layouts/', '/partials/');

			foreach ($this->_theme_locations as $location) {
				foreach (array($this->_theme, $this->_parent_theme) as $theme) {
					if ($theme) foreach ($theme_views as $theme_view) {
						$t_view = (pathinfo($view, PATHINFO_EXTENSION)) ? $view : $view.'.php';

						if (file_exists($location . $theme . $theme_view . $t_view)) {
							return array($theme . $theme_view . $view, $location);
						}
					}
				}

			}
		}

		// Not found it yet? Just load, its either in the module or root view
		return array($view, NULL);
	}

	private function _load_view($view, array $data, $override_view_path = NULL, $return = TRUE) {
		list($view, $location) = self::_find_view_path($view);

		if (!empty($location)) $override_view_path = $location;

		if (!empty($override_view_path)) {
			$this->CI->load->vars($data);

			// Load it directly, bypassing $this->load->view() as ME resets _ci_view
			$content = $this->CI->load->file($override_view_path . $view . '.php', $return);

		} else {
			// Can just run as usual
			// Grab the content of the view
			$content = $this->CI->load->view($view, $data, $return);
		}

		return $content;
	}

	private function _compileActiveStyle($content = '') {
		if ($this->CI->config->item(strtolower(APPDIR), 'active_theme_options')) {
			$active_theme_options = $this->CI->config->item(strtolower(APPDIR), 'active_theme_options');
		} else if ($this->CI->config->item(strtolower(APPDIR), 'customizer_active_style')) {
			$active_theme_options = $this->CI->config->item(strtolower(APPDIR), 'customizer_active_style');
		}

		if (!empty($active_theme_options) AND isset($active_theme_options[0]) AND $active_theme_options[0] === $this->_theme) {
			$data = (isset($active_theme_options[1]) AND is_array($active_theme_options[1])) ? $active_theme_options[1] : array();
			$content = self::_load_view('stylesheet', $data);
		}

		return $content;
	}

	private function prepUrl($href, $suffix = '') {
		if (!preg_match('#^(\w+:)?//#i', $href)) {
			list($href, $location) = self::_find_view_path($href);
			$href = theme_url($href);
		}

		if (!empty($suffix)) {
			$suffix = (strpos($href, '?') === FALSE) ? '?'. $suffix : '&'. $suffix;
		}

		return $href . $suffix;
	}

	public function __get($name) {
		return isset($this->_data[$name]) ? $this->_data[$name] : NULL;
	}

	private function sortModules($partial_name) {
		if (!empty($partial_name)) {
			foreach ($this->_modules[$partial_name] as $key => $module) {
				$modules[$key] = $module['priority'];
			}

			array_multisort($modules, SORT_ASC, $this->_modules[$partial_name]);
		}
	}

	protected function buildPartialModule($module, $view_data, $partial_data, $count) {
		$module_view = Modules::run($module['name'] .'/index', $module, $view_data);

		if (!empty($module['title'])) {
			$module_view = ($module['title'] != strip_tags($module['title'])) ? $module['title'].$module_view : "<h3 class=\"module-title\">{$module['title']}</h3>".$module_view;
		}

		$module_class = 'module-' . $module['name'] . '';
		if ($module['fixed'] === '1') {
			$top_offset = isset($module['fixed_top_offset']) ? $module['fixed_top_offset'] : '';
			$bottom_offset = isset($module['fixed_bottom_offset']) ? $module['fixed_bottom_offset'] : '';
			$fixed_tag = '<div data-spy="affix" data-offset-top="' . $top_offset . '" data-offset-bottom="' . $bottom_offset . '">';
			$module_view = $fixed_tag . $module_view . '</div>';
			$module_class .= ' affix-module';
		}

		(!empty($partial_data['module_html'])) OR $partial_data['module_html'] = '<div id="{id}" class="{class}">{module}</div>';

		$module_view = str_replace('{id}', 'module-' . str_replace('_', '-', $module['name']) . '-' . $count,
			str_replace('{class}', $module_class, str_replace('{module}', $module_view, $partial_data['module_html'])));

		return $module_view;
	}
}

// END Template Class

/* End of file Template.php */
/* Location: ./system/tastyigniter/libraries/Template.php */