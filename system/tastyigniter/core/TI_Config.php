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
defined('BASEPATH') OR exit('No direct access allowed');

/* load the MX_Router class */
require IGNITEPATH."third_party/MX/Config.php";

/**
 * TastyIgniter Config Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\TI_Config.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Config extends MX_Config {

    public $_config_paths =	array(IGNITEPATH, APPPATH);

	// -------------------------------------------------------------

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

        if (APPDIR === MAINDIR) {
            $uri = get_instance()->router->_reverse_routing($uri);
            $base_url = str_replace(ADMINDIR.'/', '', $base_url);
        } else {
            $uri = $this->_uri_string($uri);
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

	// -------------------------------------------------------------

	/**
	 * Root URL
	 *
	 * Returns root_url [. uri_string]
	 *
	 * @uses    CI_Config::_uri_string()
	 *
	 * @param    string|string[] $uri URI string or an array of segments
	 * @param    string $protocol
	 * @param 	 bool $reserve_routing
	 * @return string
	 */
    public function root_url($uri = '', $protocol = NULL, $reserve_routing = FALSE)
    {
        $root_url = str_replace(array('setup/', ADMINDIR.'/'), '', $this->slash_item('base_url'));

        if (isset($protocol))
        {
            $root_url = $protocol.substr($root_url, strpos($root_url, '://'));
        }

		if ($reserve_routing) {
			$uri = get_instance()->router->_reverse_routing($uri);
		}

		return $root_url.ltrim($this->_uri_string($uri), '/');
    }

    // -------------------------------------------------------------

}

/* End of file TI_Config.php */
/* Location: ./system/tastyigniter/core/TI_Config.php */