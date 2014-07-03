<?php (defined('BASEPATH')) OR exit('No direct access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Config.php";

class TI_Config extends MX_Config {

    function _reverse_routing($uri = '')
    {
		// Load the routes.php file.
		if (defined('ENVIRONMENT') AND is_file(APPPATH.'config/'.ENVIRONMENT.'/routes.php'))
		{
			include(APPPATH.'config/'.ENVIRONMENT.'/routes.php');
		}
		elseif (is_file(APPPATH.'config/routes.php'))
		{
			include(APPPATH.'config/routes.php');
		}

		$this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
		unset($route);
        $this->reverseRoutes = array_flip($this->routes);
		
        // $uri is expected to be a string, in the form of controller/function/param1
        // trim leading and trailing slashes, just in case
        $query = explode('?', $uri);
        $uri = trim($query[0], '/');

		// Is there a literal match?  If so we're done
		if (isset($this->reverseRoutes[$uri]))
		{
			$uri = $this->reverseRoutes[$uri];
		} 
		else
		{ 
			foreach ($this->routes as $key => $val)
			{                        
				if (!$key or !$val) continue;
			
				preg_match_all('/\(.+?\)/', $key, $rules);
				preg_match_all('/\$.+?/', $val, $references);
			
				if (empty($rules[0]) or empty($references[0])) continue;
			
				for ($i = 0; $i < count($rules[0]); $i++)
				{
					$key = substr_replace($key, $references[0][$i], strpos($key, $rules[0][$i]), 6);
					$val = substr_replace($val, $rules[0][$i], strpos($val, $references[0][$i]), 2);
				}
			
				$val = str_replace('(:any)', '(.+)', str_replace('(:num)', '([0-9]+)', $val));
			
				// Does the RegEx match?
				if (preg_match('#^'.$val.'$#', $uri))
				{
					$uri = preg_replace('#^'.$val.'$#', $key, $uri);
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
/* Location: ./application/core/TI_Config.php */