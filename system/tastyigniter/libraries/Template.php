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

	protected $_module = '';
	protected $_controller = '';
	protected $_method = '';

	protected $parent_theme = NULL;
	protected $theme = NULL;
	protected $theme_path = NULL;
	protected $theme_shortpath = NULL;
	protected $theme_locations = array();
	protected $partial_areas = array();
	protected $layouts = array();
	protected $partials = array();
	protected $components = array();
	protected $title_separator = ' | ';
	protected $data = array();
	protected $theme_config = array();

	private $CI;

	/**
	 * Constructor - Sets Preferences
	 *
	 * The constructor can be passed an array of config values
	 * @param array $config
	 */
	public function __construct($config = array()) {
		$this->CI =& get_instance();
		
		// Load assets library
		$this->CI->load->library('assets');

		$this->CI->load->helper('template');
		$this->CI->load->helper('assets');
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
		if ($this->theme_locations === array()) {
			// Let's use this obvious default
			$this->theme_locations = array(THEMEPATH);
		}

		// Set default theme
		if ($default_theme = $this->CI->config->item(APPDIR, 'default_themes')) {
			$this->setTheme($default_theme);
		}

		// Load the theme config and store array in $this->theme_config
		$this->theme_config = load_theme_config($this->theme, APPDIR);

		// Set the parent theme if theme is child
		$this->parent_theme = (isset($this->theme_config['parent'])) ? $this->theme_config['parent'] : '';

		// Modular Separation / Modular Extensions has been detected
		if (method_exists( $this->CI->router, 'fetch_module' )) {
			$this->_module 	= $this->CI->router->fetch_module();
		}

		// What controllers or methods are in use
		$this->_controller	= $this->CI->router->fetch_class();
		$this->_method 		= $this->CI->router->fetch_method();

		if (!empty($this->theme_config['head_tags'])) {
			$this->CI->assets->setHeadTags($this->theme_config['head_tags']);
		}

		$this->setPartialAreas();

		// Set the modules for this layout using the current URI segments
		!empty($this->components) OR $this->components = $this->getLayoutComponents();

		// Load user agent library if not loaded
		$this->CI->load->library('user_agent');
	}

	public function render($view, $data = array(), $return = FALSE) {
		// Set whatever values are given. These will be available to all view files
		is_array($data) OR $data = (array) $data;

		// Merge in what we already have with the specific data
		$this->data = array_merge($data, $this->data);

		// We don't need you any more buddy
		unset($data);

		// Load the layouts and partials variables
		$this->loadPartials();

		// Lets do the caching instead of the browser
		if ($this->CI->config->item('cache_mode') === '1') {
//			$this->CI->output->cache($this->CI->config->item('cache_time'));
		}

		// Want it returned or output to browser?
		if ( ! $return) {
			$this->load_view($view, $this->data, NULL, FALSE);
		} else {
			return $this->load_view($view, $this->data, NULL);
		}
	}

	//--------------------------------------------------------------------------
	// GETTER METHODS
	//--------------------------------------------------------------------------

	public function getTitle() {
		return isset($this->data['title']) ? $this->data['title'] : '';
	}

	public function getHeading() {
		$heading = '';
		if (isset($this->data['heading'])) {
			if (count($heading_array = explode(':', $this->data['heading'])) === 2) {
				$heading = $heading_array[0] . '&nbsp;&nbsp;<small>' . $heading_array[1] . '</small>';
			} else {
				$heading = $this->data['heading'];
			}
		}

		return $heading;
	}

	public function getButtonList() {
		return is_array($this->data['buttons']) ? implode("\n\t\t", $this->data['buttons']) : '';
	}

	public function getIconList() {
		return isset($this->data['icons']) AND is_array($this->data['icons']) ? implode("\n\t\t", $this->data['icons']) : '';
	}

	public function getBreadcrumb($tag_open = '<li class="{class}">', $link_open = '<a href="{link}">', $link_close = ' </a>', $tag_close = '</li>') {
		$crumbs = '';

		if (isset($this->data['breadcrumbs'])) {
			foreach ($this->data['breadcrumbs'] as $crumb) {
				if (!empty($crumb['uri'])) {
					$crumbs .= str_replace('{class}', '', $tag_open) . str_replace('{link}', site_url(trim($crumb['uri'], '/')), $link_open) . $crumb['name'] . $link_close;
				} else {
					$crumbs .= str_replace('{class}', 'active', $tag_open) . '<span>' . $crumb['name'] . ' </span>';
				}

				$crumbs .= $tag_close;
			}
		}

		return (!empty($crumbs)) ? '<ol class="breadcrumb">' .  $crumbs . '</ol>' : $crumbs;
	}

	public function getThemeLocation($theme = NULL) {
		$theme OR $theme = $this->theme;

		foreach ($this->theme_locations as $location) {
			if (is_dir($location . $theme)) {
				return $location;
			}
		}

		return FALSE;
	}

	//--------------------------------------------------------------------------
	// SETTER METHODS
	//--------------------------------------------------------------------------

	public function setTheme($theme = '') {
		$this->theme = trim($theme, '/');

		if ($theme_location = $this->getThemeLocation($this->theme)) {
			$this->theme_path = rtrim($theme_location . $this->theme);
			$this->theme_shortpath = APPDIR . '/views/themes/' . $this->theme;
		} else {
			show_error('Unable to locate the active theme: '.APPDIR . '/views/themes/' . $this->theme);
		}
	}

	public function setPartialAreas() {
		$partial_areas = isset($this->theme_config['partial_area']) ? $this->theme_config['partial_area'] : $this->partial_areas;

		foreach ($partial_areas as $partial_area) {
			$id = isset($partial_area['id']) ? $partial_area['id'] : $partial_area;
			$this->partial_areas[$id] = $partial_area;
		}

		$this->layouts = array('header' => array(), 'footer' => array());

		return $this;
	}

	public function setTitle() {
		if (func_num_args() >= 1) {
			$this->data['title'] = implode($this->title_separator, func_get_args());
		}
	}

	public function setHeading($heading = '') {
		$this->data['heading'] = $heading;
	}

	public function setButton($name, $attributes = array()) {
		$attr = '';
		foreach ($attributes as $key => $value) {
			$attr .= ' '. $key .'="'. $value .'"';
		}

		$this->data['buttons'][] = '<a'.$attr.'>'.$name.'</a>';
	}

	public function setIcon($icon) {
		$this->data['icons'][] = $icon;
	}

	public function setBreadcrumb($name, $uri = '') {
		$this->data['breadcrumbs'][] = array('name' => $name, 'uri' => $uri );
		return $this;
	}

	//--------------------------------------------------------------------------
	// NAVIGATION MENU
	//--------------------------------------------------------------------------

	public function addNavMenuItem($item, $options = array(), $parent = NULL) {
		if (!empty($parent)) {
			$this->theme_config['nav_menu'][$parent]['child'][$item] = $options;
		} else {
			$this->theme_config['nav_menu'][$item] = $options;
		}

	}

	public function removeNavMenuItem($item, $parent = NULL) {
		if (!empty($parent)) {
			unset($this->theme_config['nav_menu'][$parent]['child'][$item]);
		} else {
			unset($this->theme_config['nav_menu'][$item]);
		}
	}

	public function navMenu($prefs = array()) {
		$container_open = '<ul class="nav" id="side-menu">';
		$container_close = '</ul>';

		extract($prefs);

		// Bail out if nav_menu theme config item is missing or not an array
		if ( ! is_array($this->theme_config['nav_menu'])) {
			return NULL;
		}


		return $container_open . $this->_buildNavMenu($this->theme_config['nav_menu']) . $container_close;
	}

	protected function _buildNavMenu($nav_menu = array(), $has_child = 0) {
		$levels = array('', 'nav-second-level', 'nav-third-level');

		foreach ($nav_menu as $key => $value) {
			$sort_array[$key] = isset($value['priority']) ? $value['priority'] : '1111';
		}

		array_multisort($sort_array, SORT_ASC, $nav_menu);

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

	//--------------------------------------------------------------------------
	// PARTIALS
	//--------------------------------------------------------------------------

	public function partial_exists($view = '') {
		return isset($this->partials[$view]);
	}

	public function get_partial($view = '', $replace = array()) {
		$partial = empty($this->partials[$view]) ? $this->getPartial($view) : $this->partials[$view];

		$partial_class = !empty($partial['data']['class']) ? $partial['data']['class'] : '';
		$partial_class = !empty($replace['class']) ? $replace['class'] : $partial_class;

		$partial_data = isset($partial['data']['open_tag']) ? str_replace('{id}', str_replace('_', '-', $view), str_replace('{class}', $partial_class, $partial['data']['open_tag'])) : '';
		$partial_data .= empty($partial['view']) ? '' : $partial['view'];
		$partial_data .= isset($partial['data']['close_tag']) ? $partial['data']['close_tag'] : '';

		return $partial_data;
	}

	public function find_path($view = '') {
		if ( ! empty($this->theme)) {
			$theme_views = array('/', '/layouts/', '/partials/');

			foreach ($this->theme_locations as $location) {
				foreach (array($this->theme, $this->parent_theme) as $theme) {
					if ($theme) foreach ($theme_views as $theme_view) {
						$t_view = (pathinfo($view, PATHINFO_EXTENSION)) ? $view : $view.'.php';

						if (file_exists($location . $theme . $theme_view . $t_view)) {
							return array($theme . $theme_view . $view, $location);
						}
					}
				}

			}
		}

		// Not found it yet?
		return array($view, NULL);
	}

	protected function loadPartials() {
		$partial_areas = array_merge($this->partial_areas, $this->layouts);

		foreach ($partial_areas as $partial_name => $partial_data) {
			if (!is_string($partial_name)) continue;

			if ($partial_view = $this->load_partial($partial_name, $partial_data)) {
				$this->partials[$partial_name] = array('data' => $partial_data, 'view' => $partial_view);
			}
		}
	}

	protected function getPartial($partial = '') {
		list($name, $data) = array($partial, array());

		if (!is_string($name)) return NULL;

		$view = $this->load_partial($name, $data);

		return array('data' => $data, 'view' => $view);
	}

	protected function getLayoutComponents() {
		list($uri_route, $layout_modules) = $this->getLayoutComponentsByRoute();

		$components = array();
		$_components = Components::list_components();
		foreach ($layout_modules as $partial => $partial_modules) {
			foreach ($partial_modules as $layout_module) {
				if (isset($layout_module['module_code']) AND !empty($_components[$layout_module['module_code']])) {
					$component = $_components[$layout_module['module_code']];

					if ($component['code'] === $layout_module['module_code'] AND $layout_module['status'] === '1') {
						$partial = $layout_module['partial'];
						if (in_array($layout_module['partial'], array('top', 'left', 'right', 'bottom'))) {
							$partial = 'content_' . $layout_module['partial'];
						}

						unset($layout_module['options']);
						$components[$partial][] = array(
							'code'                => $component['code'],
							'name'                => $component['name'],
							'layout_id'		      => $layout_module['layout_id'],
							'uri_route'           => $uri_route,
							'partial'             => $partial,
							'priority'            => $layout_module['priority'],
							'title'               => $layout_module['title'],
							'fixed'               => $layout_module['fixed'],
							'fixed_top_offset'    => $layout_module['fixed_top_offset'],
							'fixed_bottom_offset' => $layout_module['fixed_bottom_offset'],
						);
					}

				}
			}
		}

		return $components;
	}

	protected function getLayoutComponentsByRoute() {
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

	protected function sortComponents($partial_name) {
		if (!empty($partial_name)) {
			foreach ($this->components[$partial_name] as $key => $module) {
				$components[$key] = $module['priority'];
			}

			array_multisort($components, SORT_ASC, $this->components[$partial_name]);
		}
	}

	//--------------------------------------------------------------------------
	// VIEWS LOADER
	//--------------------------------------------------------------------------

	public function load_view($view, array $data, $override_view_path = NULL, $return = TRUE) {
		list($view, $location) = $this->find_path($view);

		if (!empty($location)) $override_view_path = $location;

		if (!empty($override_view_path)) {
			$this->CI->load->vars($data);

			// Load it directly, bypassing $this->load->view() as MX resets _ci_view
			$content = $this->CI->load->file($override_view_path . $view . '.php', $return);

		} else {
			// Can just run as usual
			// Grab the content of the view
			$content = $this->CI->load->view($view, $data, $return);
		}

		return $content;
	}

	public function load_partial($name, $data = array()) {
		$view = NULL;

		if (isset($this->layouts[$name])) {
			$view = $this->load_view($name, $this->data + $data);
		} else if (!empty($this->partial_areas[$name])) {
			// We stop here if no module was found.
			if (empty($this->components[$name])) return $view;

			$count = 1;
			$this->sortComponents($name);
			foreach ($this->components[$name] as $module) {
				$view .= $this->buildPartialComponent($module, $data, $count++);
			}
		}

		return $view;
	}

	protected function buildPartialComponent($module, $partial_data, $count) {
		$module_view = Components::run($module['code'] .'/index', $this->_controller, $module);

		if (!empty($module['title'])) {
			$module_view = ($module['title'] != strip_tags($module['title'])) ? $module['title'].$module_view : "<h3 class=\"module-title\">{$module['title']}</h3>".$module_view;
		}

		$module_class = 'module-' . $module['code'] . '';
		if ($module['fixed'] === '1') {
			$top_offset = isset($module['fixed_top_offset']) ? $module['fixed_top_offset'] : '';
			$bottom_offset = isset($module['fixed_bottom_offset']) ? $module['fixed_bottom_offset'] : '';
			$fixed_tag = '<div data-spy="affix" data-offset-top="' . $top_offset . '" data-offset-bottom="' . $bottom_offset . '">';
			$module_view = $fixed_tag . $module_view . '</div>';
			$module_class .= ' affix-module';
		}

		(!empty($partial_data['module_html'])) OR $partial_data['module_html'] = '<div id="{id}" class="{class}">{module}</div>';

		$module_view = str_replace('{id}', 'module-' . str_replace('_', '-', $module['code']) . '-' . $count,
			str_replace('{class}', $module_class, str_replace('{module}', $module_view, $partial_data['module_html'])));

		return $module_view;
	}
}

// END Template Class

/* End of file Template.php */
/* Location: ./system/tastyigniter/libraries/Template.php */