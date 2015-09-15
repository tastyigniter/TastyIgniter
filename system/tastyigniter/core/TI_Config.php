<?php (defined('BASEPATH')) OR exit('No direct access allowed');

/* load the MX_Router class */
require IGNITEPATH."third_party/MX/Config.php";

class TI_Config extends MX_Config {

    public $_config_paths =	array(IGNITEPATH, APPPATH);

    private $settings =	array();

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

    /**
     * Root URL
     *
     * Returns root_url [. uri_string]
     *
     * @uses	CI_Config::_uri_string()
     *
     * @param	string|string[]	$uri	URI string or an array of segments
     * @param	string	$protocol
     * @return	string
     */
    public function root_url($uri = '', $protocol = NULL)
    {
        $root_url = str_replace(array('setup/', ADMINDIR.'/'), '', $this->slash_item('base_url'));

        if (isset($protocol))
        {
            $root_url = $protocol.substr($root_url, strpos($root_url, '://'));
        }

        return $root_url.ltrim($this->_uri_string($uri), '/');
    }

    // -------------------------------------------------------------

    public function load_db_config() {
        $CI =& get_instance();

        // Make sure the database is connected and settings table exists
        if ($CI->db->conn_id !== FALSE AND $CI->db->table_exists('settings')) {
            $CI->load->model('Settings_model');

            ! empty($this->settings) OR $this->settings = $CI->Settings_model->getAll();

            if ( ! empty($this->settings)) {
                foreach ($this->settings as $setting) {
                    if ( ! empty($setting['serialized'])) {
                        $this->set_item($setting['item'], unserialize($setting['value']));
                    } else {
                        $this->set_item($setting['item'], $setting['value']);
                    }
                }
            }

            if (isset($this->config['timezone'])) {
                date_default_timezone_set($this->config['timezone']);
            }
        }
    }
}

/* End of file TI_Config.php */
/* Location: ./system/tastyigniter/core/TI_Config.php */