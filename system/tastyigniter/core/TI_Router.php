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
 */
defined('BASEPATH') or exit('No direct script access allowed');

/* load the core module and component class */
require_once IGNITEPATH . 'core/Modules.php';
require_once IGNITEPATH . 'core/Components.php';

/**
 * TastyIgniter Router Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\TI_Router.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Router extends CI_Router
{

//    private $routes =	array();
	private $reverseRoutes = array();
	public $module;
	private $located = 0;

	public function __construct($routing = NULL) {
		parent::__construct($routing);
		
		Modules::initialize();
	}

	// --------------------------------------------------------------------

	public function fetch_module() {
		return $this->module;
	}

	// --------------------------------------------------------------------

	/**
	 * Find the controller for the current request.
	 *
	 * @param  array $segments The URL segments to use to locate the controller.
	 *
	 * @return array The segments which indicate the location of the controller.
	 */
	public function _validate_request($segments)
	{
		if (count($segments) == 0) {
			return $segments;
		}

		// Locate module controller
		if ($located = $this->locate($segments)) {
			return $located;
		}

		// Use a default 404_override controller
		if (! empty($this->routes['404_override'])) {
			$segments = explode('/', $this->routes['404_override']);
			if ($located = $this->locate($segments)) {
				return $located;
			}
		}

		// No controller found
		show_404(implode('/', $segments));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set route mapping
	 *
	 * Determines what should be served based on the URI request,
	 * as well as any "routes" that have been set in the routing config file.
	 *
	 * @return    void
	 */
	protected function _set_routing() {
		// Load the routes.php file. It would be great if we could
		// skip this for enable_query_strings = TRUE, but then
		// default_controller would be empty ...
		if (file_exists(IGNITEPATH . 'config/routes.php')) {
			include(IGNITEPATH . 'config/routes.php');
		}

		if (file_exists(IGNITEPATH . 'config/' . ENVIRONMENT . '/routes.php')) {
			include(IGNITEPATH . 'config/' . ENVIRONMENT . '/routes.php');
		}

		// Validate & get reserved routes
		if (isset($route) AND is_array($route)) {
			isset($route['default_controller']) AND $this->default_controller = $route['default_controller'];
			isset($route['translate_uri_dashes']) AND $this->translate_uri_dashes = $route['translate_uri_dashes'];
			unset($route['default_controller'], $route['translate_uri_dashes']);
			$this->routes = $route;
		}

		// Are query strings enabled in the config file? Normally CI doesn't utilize query strings
		// since URI segments are more search-engine friendly, but they can optionally be used.
		// If this feature is enabled, we will gather the directory/class/method a little differently
		if ($this->enable_query_strings) {
			// If the directory is set at this time, it means an override exists, so skip the checks
			if (!isset($this->directory)) {
				$_d = $this->config->item('directory_trigger');
				$_d = isset($_GET[$_d]) ? trim($_GET[$_d], " \t\n\r\0\x0B/") : '';
				if ($_d !== '') {
					$this->uri->filter_uri($_d);
					$this->set_directory($_d);
				}
			}

			$_c = trim($this->config->item('controller_trigger'));
			if (!empty($_GET[$_c])) {
				$this->uri->filter_uri($_GET[$_c]);
				$this->set_class($_GET[$_c]);

				$_f = trim($this->config->item('function_trigger'));
				if (!empty($_GET[$_f])) {
					$this->uri->filter_uri($_GET[$_f]);
					$this->set_method($_GET[$_f]);
				}

				$this->uri->rsegments = array(
					1 => $this->class,
					2 => $this->method,
				);
			} else {
				$this->_set_default_controller();
			}

			// Routing rules don't apply to query strings and we don't need to detect
			// directories, so we're done here
			return;
		}

		// Is there anything to parse?
		if ($this->uri->uri_string !== '') {
			$this->_parse_routes();
		} else {
			$this->_set_default_controller();
		}
	}

	// --------------------------------------------------------------------

	public function _reverse_routing($uri = '') {
		$this->reverseRoutes = array_flip($this->routes);

		// $uri is expected to be a string, in the form of controller/function/param1
		// trim leading and trailing slashes, just in case
		$query = explode('?', $uri);
		$uri = trim($query[0], '/');

		// Is there a literal match?  If so we're done
		if ($uri !== '' AND $uri !== 'home' AND $uri !== 'pages') {
			if (isset($this->reverseRoutes[$uri])) {
				$uri = $this->reverseRoutes[$uri];
			} else {
				foreach ($this->routes as $key => $val) {
					if (!$key OR !$val OR $val === '$1') continue;

					preg_match_all('/\(.+?\)/', $key, $rules);
					preg_match_all('/\$.+?/', $val, $references);

					if (empty($rules[0]) OR empty($references[0])) continue;

					for ($i = 0; $i < count($rules[0]); $i++) {
						$key = substr_replace($key, $references[0][$i], strpos($key, $rules[0][$i]), 6);
						$val = substr_replace($val, $rules[0][$i], strpos($val, $references[0][$i]), 2);
					}

					$val = str_replace('(:any)', '(.+)', str_replace('(:num)', '([0-9]+)', $val));

					// Does the RegEx match?
					if (preg_match('#^' . $val . '$#', $uri)) {
						$uri = preg_replace('#^' . $val . '$#', $key, $uri);
					}
				}
			}
		}

		$uri = str_replace(array('/(:any)', '/(:num)', '/(.+)'), '', $uri);

		if (isset($query[1])) {
			$this->CI =& get_instance();

			if ($this->config->item('permalink') == '1') {
				$this->CI->load->library('permalink');

				if ($slug = $this->CI->permalink->getQuerySlug($query[1], $uri)) {
					return $slug;
				}
			}

			return $uri . '?' . $query[1];
		}

		return $uri;
	}

	// --------------------------------------------------------------------

	/** Locate the controller *
	 *
	 * @param array $segments
	 *
	 * @return array|mixed|void
	 */
	public function locate($segments) {
		$this->located = 0;
		$ext = $this->config->item('controller_suffix') . '.php';

		/* use module route if available */
		if (isset($segments[0]) AND $routes = Modules::parse_routes($segments[0], implode('/', $segments))) {
			$segments = $routes;
		}

		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, NULL);

		$where = 'controllers';

		/* check modules */
		foreach (Modules::$locations as $location => $offset) {
			/* module exists? check within components if main app is in use */
			$where = (APPDIR === MAINDIR AND is_dir($location . $module)) ? 'components' : 'controllers';

			/* module controller or component exists? */
			if (is_dir($source = $location . $module . '/'.$where.'/')) {
				$this->module = $module;
				$this->directory = $offset . $module . '/'.$where.'/';

				/* module sub-controller exists? */
				if ($directory) {
					/* module sub-directory exists? */
					if (is_dir($source . $directory . '/')) {
						$source .= $directory . '/';
						$this->directory .= $directory . '/';

						/* module sub-directory controller exists? */
						if ($controller) {
							if (is_file($source . ucfirst($controller) . $ext)) {
								$this->located = 3;

								return array_slice($segments, 2);
							} else $this->located = -1;
						}
					} else
						if (is_file($source . ucfirst($directory) . $ext)) {
							$this->located = 2;

							return array_slice($segments, 1);
						} else $this->located = -1;
				}

				/* module controller exists? */
				if (is_file($source . ucfirst($module) . $ext)) {
					$this->located = 1;

					return $segments;
				}
			}
		}

		if (!empty($this->directory)) return;

		/* application sub-directory controller exists? */
		if ($directory) {
			if (is_file(APPPATH . 'controllers/' . $module . '/' . ucfirst($directory) . $ext)) {
				$this->directory = $module . '/';

				return array_slice($segments, 1);
			}

			/* application sub-sub-directory controller exists? */
			if ($controller) {
				if (is_file(APPPATH . 'controllers/' . $module . '/' . $directory . '/' . ucfirst($controller) . $ext)) {
					$this->directory = $module . '/' . $directory . '/';

					return array_slice($segments, 2);
				}
			}
		}

		/* application controllers sub-directory exists? */
		if (is_dir(APPPATH . 'controllers/' . $module . '/')) {
			$this->directory = $module . '/';

			return array_slice($segments, 1);
		}

		/* application controller exists? */
		if (is_file(APPPATH . 'controllers/' . ucfirst($module) . $ext)) {
			return $segments;
		}

		$this->located = -1;
	}

	// --------------------------------------------------------------------

	/* set module path */
	protected function _set_module_path(&$_route) {
		if (!empty($_route)) {
			// Are module/directory/controller/method segments being specified?
			$sgs = sscanf($_route, '%[^/]/%[^/]/%[^/]/%s', $module, $directory, $class, $method);

			// set the module/controller directory location if found
			if ($this->locate(array($module, $directory, $class))) {
				//reset to class/method
				switch ($sgs) {
					case 1:
						$_route = $module . '/index';
						break;
					case 2:
						$_route = ($this->located < 2) ? $module . '/' . $directory : $directory . '/index';
						break;
					case 3:
						$_route = ($this->located == 2) ? $directory . '/' . $class : $class . '/index';
						break;
					case 4:
						$_route = ($this->located == 3) ? $class . '/' . $method : $method . '/index';
						break;
				}
			}
		}
	}

	// --------------------------------------------------------------------

	public function set_class($class) {
		$suffix = $this->config->item('controller_suffix');
		if (strpos($class, $suffix) === FALSE) {
			$class .= $suffix;
		}
		parent::set_class($class);
	}

}
