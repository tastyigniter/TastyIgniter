<?php (defined('BASEPATH')) OR exit('No direct access allowed');

/* load the MX_Router class */
require IGNITEPATH."third_party/MX/Config.php";

class TI_Config extends MX_Config {

	private $routes =	array();
	private $reverseRoutes =	array();

	/**
	 * Site URL
	 * Returns base_url . index_page [. uri_string]
	 *
	 * @access	public
	 * @param	string	the URI string
	 * @return	string
	 */
	public function site_url($uri = '', $protocol = NULL)
	{
		$base_url = $this->slash_item('base_url');

		if (isset($protocol))
		{
			$base_url = $protocol.substr($base_url, strpos($base_url, '://'));
		}

		if (empty($uri))
		{
			return $base_url.$this->item('index_page');
		}

		if (APPDIR === 'admin') {
			$uri = $this->_uri_string($uri);
		} else {
			$uri = $this->_reverse_routing($uri);
		}

		if ($this->item('enable_query_strings') === FALSE)
		{
			$suffix = isset($this->config['url_suffix']) ? $this->config['url_suffix'] : '';

			if ($suffix !== '')
			{
				if (($offset = strpos($uri, '?')) !== FALSE)
				{
					$uri = substr($uri, 0, $offset).$suffix.substr($uri, $offset);
				}
				else
				{
					$uri .= $suffix;
				}
			}

			return $base_url.$this->slash_item('index_page').$uri;
		}
		elseif (strpos($uri, '?') === FALSE)
		{
			$uri = '?'.$uri;
		}

		return $base_url.$this->item('index_page').$uri;
	}

	/*function site_url($uri = '', $protocol = NULL)
	{
		if ($uri == '')
		{
			return $this->slash_item('base_url').$this->item('index_page');
		}

		$uri = $this->_reverse_routing($uri);

		if ($this->item('enable_query_strings') == FALSE)
		{
			$suffix = ($this->item('url_suffix') == FALSE) ? '' : $this->item('url_suffix');
			return $this->slash_item('base_url').$this->slash_item('index_page').$this->_uri_string($uri).$suffix;
		}
		else
		{
			return $this->slash_item('base_url').$this->item('index_page').'?'.$this->_uri_string($uri);
		}
	}*/

    function _reverse_routing($uri = '')
    {
        // Load the routes.php file.
        $route_file = APPDIR === 'admin' ? 'admin_routes' : 'routes';

        // Load the routes.php file.
        if (file_exists(IGNITEPATH . 'config/' . $route_file . '.php'))
        {
            include(IGNITEPATH . 'config/' . $route_file . '.php');
        }

        if (file_exists(IGNITEPATH . 'config/' . ENVIRONMENT . '/' . $route_file . '.php'))
        {
            include(IGNITEPATH . 'config/' . ENVIRONMENT . '/' . $route_file . '.php');
        }

        $this->routes = (!isset($route) OR !is_array($route)) ? array() : $route;
        unset($route);
        unset($this->routes['translate_uri_dashes']);

        $this->reverseRoutes = array_flip($this->routes);

        // $uri is expected to be a string, in the form of controller/function/param1
        // trim leading and trailing slashes, just in case
        $query = explode('?', $uri);
        $uri = trim($query[0], '/');

        // Is there a literal match?  If so we're done
        if ($uri !== 'home' AND $uri !== '')
        {
            if (isset($this->reverseRoutes[$uri]))
            {
                $uri = $this->reverseRoutes[$uri];
            } else
            {
                foreach ($this->routes as $key => $val)
                {
                    if (!$key or !$val) continue;

                    preg_match_all('/\(.+?\)/', $key, $rules);
                    preg_match_all('/\$.+?/', $val, $references);

                    if (empty($rules[0]) or empty($references[0])) continue;

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

		$uri = str_replace('/(:any)', '', str_replace('/(:num)', '', $uri));

		if (isset($query[1])) {
			$this->CI =& get_instance();

			if ($this->CI->config->item('permalink') == '1') {
				$this->CI->load->library('permalink');

				if ($permalink = $this->CI->permalink->setPermalink($query[1])) {
					return $uri.'/'.$permalink;
				}
			}

			return $uri.'?'.$query[1];
		}

        return $uri;
    }
}

/* End of file TI_Config.php */
/* Location: ./system/tastyigniter/core/TI_Config.php */