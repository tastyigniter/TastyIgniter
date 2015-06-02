<?php (defined('BASEPATH')) OR exit('No direct access allowed');

/* load the MX_Router class */
require IGNITEPATH."third_party/MX/Config.php";

class TI_Config extends MX_Config {

    public $_config_paths =	array(IGNITEPATH, APPPATH);

    private $settings =	array();

    public function __construct() {
        parent::__construct();
    }

    public function load($file = 'config', $use_sections = FALSE, $fail_gracefully = FALSE, $_module = '') {

        if (in_array($file, $this->is_loaded, TRUE)) return $this->item($file);

        $_module OR $_module = CI::$APP->router->fetch_module();
        list($path, $file) = Modules::find($file, $_module, 'config/');

        if ($path === FALSE) {
            parent::load($file, $use_sections, $fail_gracefully);
            return $this->item($file);
        }

        if ($config = Modules::load_file($file, $path, 'config', $fail_gracefully)) {

            /* reference to the config array */
            $current_config =& $this->config;

            if ($use_sections === TRUE)	{

                if (isset($current_config[$file])) {
                    $current_config[$file] = array_merge($current_config[$file], $config);
                } else {
                    $current_config[$file] = $config;
                }

            } else {
                $current_config = array_merge($current_config, $config);
            }
            $this->is_loaded[] = $file;
            unset($config);
            return $this->item($file);
        }
    }

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

    public function load_db_config() {
        $CI =& get_instance();
        $CI->load->model('Settings_model');

        !empty($this->settings) OR $this->settings = $CI->Settings_model->getAll();

        if (!empty($this->settings)) {
            foreach ($this->settings as $setting) {
                if (!empty($setting['serialized'])) {
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

/* End of file TI_Config.php */
/* Location: ./system/tastyigniter/core/TI_Config.php */