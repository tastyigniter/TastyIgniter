<?php defined('BASEPATH') or exit('No direct script access allowed');

/* load the HMVC_Router class */
require IGNITEPATH . 'third_party/MX/Router.php';

class TI_Router extends MX_Router {

	/**
	 * Set route mapping
	 *
	 * Determines what should be served based on the URI request,
	 * as well as any "routes" that have been set in the routing config file.
	 *
	 * @return	void
	 */
	protected function _set_routing()
	{
		// Are query strings enabled in the config file? Normally CI doesn't utilize query strings
		// since URI segments are more search-engine friendly, but they can optionally be used.
		// If this feature is enabled, we will gather the directory/class/method a little differently
		if ($this->enable_query_strings)
		{
			$_d = $this->config->item('directory_trigger');
			$_d = isset($_GET[$_d]) ? trim($_GET[$_d], " \t\n\r\0\x0B/") : '';
			if ($_d !== '')
			{
				$this->set_directory($this->uri->filter_uri($_d));
			}

			$_c = $this->config->item('controller_trigger');
			if ( ! empty($_GET[$_c]))
			{
				$this->set_class(trim($this->uri->filter_uri(trim($_GET[$_c]))));

				$_f = $this->config->item('function_trigger');
				if ( ! empty($_GET[$_f]))
				{
					$this->set_method(trim($this->uri->filter_uri($_GET[$_f])));
				}

				$this->uri->rsegments = array(
					1 => $this->class,
					2 => $this->method
				);
			}
			else
			{
				$this->_set_default_controller();
			}

			// Routing rules don't apply to query strings and we don't need to detect
			// directories, so we're done here
			return;
		}

		$route_file = APPDIR === 'admin' ? 'admin_routes' : 'routes';

		// Load the routes.php file.
		if (file_exists(IGNITEPATH.'config/'.$route_file.'.php'))
		{
			include(IGNITEPATH.'config/'.$route_file.'.php');
		}

		if (file_exists(IGNITEPATH.'config/'.ENVIRONMENT.'/'.$route_file.'.php'))
		{
			include(IGNITEPATH.'config/'.ENVIRONMENT.'/'.$route_file.'.php');
		}

		// Validate & get reserved routes
		if (isset($route) && is_array($route))
		{
			isset($route['default_controller']) && $this->default_controller = $route['default_controller'];
			isset($route['translate_uri_dashes']) && $this->translate_uri_dashes = $route['translate_uri_dashes'];
			unset($route['default_controller'], $route['translate_uri_dashes']);
			$this->routes = $route;
		}

		// Is there anything to parse?
		if ($this->uri->uri_string !== '')
		{
			$this->_parse_routes();
		}
		else
		{
			$this->_set_default_controller();
		}
	}

	// --------------------------------------------------------------------
}

/* End of file TI_Router.php */
/* Location: ./system/tastyigniter/core/TI_Router.php */