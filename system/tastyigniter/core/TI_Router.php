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

/* load the HMVC_Router class */
require IGNITEPATH . 'third_party/MX/Router.php';

/**
 * TastyIgniter Router Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\TI_Router.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Router extends MX_Router {

//    private $routes =	array();
    private $reverseRoutes =	array();

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
		if (isset($route) && is_array($route)) {
			isset($route['default_controller']) && $this->default_controller = $route['default_controller'];
			isset($route['translate_uri_dashes']) && $this->translate_uri_dashes = $route['translate_uri_dashes'];
			unset($route['default_controller'], $route['translate_uri_dashes']);
			$this->routes = $route;
		}

		// Are query strings enabled in the config file? Normally CI doesn't utilize query strings
		// since URI segments are more search-engine friendly, but they can optionally be used.
		// If this feature is enabled, we will gather the directory/class/method a little differently
		if ($this->enable_query_strings)
		{
			// If the directory is set at this time, it means an override exists, so skip the checks
			if (!isset($this->directory))
			{
				$_d = $this->config->item('directory_trigger');
				$_d = isset($_GET[$_d]) ? trim($_GET[$_d], " \t\n\r\0\x0B/") : '';
				if ($_d !== '') {
					$this->uri->filter_uri($_d);
					$this->set_directory($_d);
				}
			}

			$_c = trim($this->config->item('controller_trigger'));
			if ( ! empty($_GET[$_c]))
			{
				$this->uri->filter_uri($_GET[$_c]);
				$this->set_class($_GET[$_c]);

				$_f = trim($this->config->item('function_trigger'));
				if ( ! empty($_GET[$_f]))
				{
					$this->uri->filter_uri($_GET[$_f]);
					$this->set_method($_GET[$_f]);
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

    public function _reverse_routing($uri = '')
    {
        $this->reverseRoutes = array_flip($this->routes);

        // $uri is expected to be a string, in the form of controller/function/param1
        // trim leading and trailing slashes, just in case
        $query = explode('?', $uri);
        $uri = trim($query[0], '/');

        // Is there a literal match?  If so we're done
        if ( $uri !== '' AND $uri !== 'home' AND $uri !== 'pages')
        {
            if (isset($this->reverseRoutes[$uri]))
            {
                $uri = $this->reverseRoutes[$uri];
            } else
            {
                foreach ($this->routes as $key => $val)
                {
                    if (!$key OR !$val OR $val === '$1') continue;

                    preg_match_all('/\(.+?\)/', $key, $rules);
                    preg_match_all('/\$.+?/', $val, $references);

                    if (empty($rules[0]) OR empty($references[0])) continue;

                    for ($i = 0; $i < count($rules[0]); $i ++)
                    {
                        $key = substr_replace($key, $references[0][$i], strpos($key, $rules[0][$i]), 6);
                        $val = substr_replace($val, $rules[0][$i], strpos($val, $references[0][$i]), 2);
                    }

                    $val = str_replace('(:any)', '(.+)', str_replace('(:num)', '([0-9]+)', $val));

                    // Does the RegEx match?
                    if (preg_match('#^' . $val . '$#', $uri))
                    {
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

            return $uri.'?'.$query[1];
        }

        return $uri;
    }

    // --------------------------------------------------------------------

}
