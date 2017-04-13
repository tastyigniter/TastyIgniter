<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct access allowed');

/* load the MX_Router class */
require IGNITEPATH."third_party/MX/Config.php";

/**
 * TastyIgniter Config Class
 *
 * @category       Libraries
 * @package        Igniter\Core\TI_Config.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Config extends MX_Config
{

    protected $CI;
    public $_config_paths = [IGNITEPATH.'models/', ROOTPATH];
    public $cachePath;
    protected $_db_config_loaded;

    // -------------------------------------------------------------

    /**
     * Class constructor
     *
     * Sets the $config data from the primary config.php file as a class variable.
     *
     * @return    void
     */
    public function __construct()
    {
        $replaceConfig = $this->readDBConfigCache();

        $this->config =& get_config($replaceConfig);

        $this->config['time_reference'] = $this->config['timezone'] ?: $this->config['time_reference'];
        if ($this->config['time_reference']) {
            date_default_timezone_set($this->config['time_reference']);
        }

        // Set the base_url automatically if none was provided
        if (empty($this->config['base_url'])) {
            // The regular expression is only a basic validation for a valid "Host" header.
            // It's not exhaustive, only checks for valid characters.
            if (isset($_SERVER['HTTP_HOST']) && preg_match('/^((\[[0-9a-f:]+\])|(\d{1,3}(\.\d{1,3}){3})|[a-z0-9\-\.]+)(:\d+)?$/i', $_SERVER['HTTP_HOST'])) {
                $base_url = (is_https() ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST']
                    .substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
            } else {
                $base_url = 'http://localhost/';
            }

            $this->set_item('base_url', $base_url);
        }

        log_message('info', 'Config Class Initialized');
    }

    public function load($file = '', $use_sections = FALSE, $fail_gracefully = FALSE, $_module = '', $requiredConfig = [])
    {
        $config = $this->_mx_load($file, $use_sections, $fail_gracefully, $_module);

        $this->validate($config, $requiredConfig);

        return $config;
    }

    public function setBaseUrl($siteUrl = null)
    {
        $siteUrl = is_null($siteUrl) ? $this->config['site_url'] : $siteUrl;

        if ($siteUrl)
            $this->set_item('base_url', trim($siteUrl, '/').'/'.(APPDIR === MAINDIR ? '' : APPDIR));
    }

    // --------------------------------------------------------------------

    public function site_url($uri = '', $protocol = null)
    {
        $base_url = $this->slash_item('base_url');

        if (isset($protocol)) {
            // For protocol-relative links
            if ($protocol === '') {
                $base_url = substr($base_url, strpos($base_url, '//'));
            } else {
                $base_url = $protocol.substr($base_url, strpos($base_url, '://'));
            }
        }

        if (APPDIR === MAINDIR) {
            $uri = get_instance()->router->_reverse_routing($uri);
        } else {
            $uri = $this->_uri_string((!starts_with($uri, APPDIR) ? APPDIR.'/'.$uri : $uri));
        }

        if (empty($uri))
            return $base_url.$this->item('index_page');

        if ($this->item('enable_query_strings') === FALSE) {
            $suffix = isset($this->config['url_suffix']) ? $this->config['url_suffix'] : '';

            if ($suffix !== '') {
                if (($offset = strpos($uri, '?')) !== FALSE) {
                    $uri = substr($uri, 0, $offset).$suffix.substr($uri, $offset);
                } else {
                    $uri .= $suffix;
                }
            }

            return $base_url.$this->slash_item('index_page').$uri;
        } elseif (strpos($uri, '?') === FALSE) {
            $uri = '?'.$uri;
        }

        return $base_url.$this->item('index_page').$uri;
    }

    // --------------------------------------------------------------------

    public function restaurant_url($uri = '', $protocol = null)
    {
        if ($uri === '') $uri = 'menus';

        $query = explode('?', $uri);
        $uri = trim($query[0], '/');

        $query_arr = [];
        if (isset($query[1])) parse_str($query[1], $query_arr);

        if (!isset($query_arr['location_id'])) {
            $location_id = isset(get_instance()->location) ? get_instance()->location->getId() : null;
            if ($this->item('site_location_mode') === 'multiple' AND is_numeric($location_id)) {
                $query_arr['location_id'] = $location_id;
            }
        }

        if ($this->item('site_location_mode') === 'single') unset($query_arr['location_id']);

        $temp_uri = str_replace(['menus', 'info', 'reviews', 'gallery'], 'local', $query[0]);
        if (!empty($query_arr)) {
            $url = $this->site_url($temp_uri.'?'.http_build_query($query_arr), $protocol);
        } else {
            $url = $this->site_url($uri, $protocol);
        }

//        $url = str_replace(['setup/', ADMINDIR.'/'], '', $url);

        if (strpos($url, '/menus') === FALSE AND !empty($query_arr)) {
            $_query = explode('?', $url);
            $_uri = trim($_query[0], '/');

            $url = $_uri.'/'.(isset($_query[1]) ? $uri.'?'.$_query[1] : $uri);
        }

        return $url;
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
     * @param     bool $reserve_routing
     *
     * @return string
     */
    public function root_url($uri = '', $protocol = null, $reserve_routing = FALSE)
    {
//        $root_url = str_replace(['setup/', ADMINDIR.'/'], '', $this->slash_item('base_url'));
        $root_url = $this->slash_item('base_url');

        if (isset($protocol)) {
            // For protocol-relative links
            if ($protocol === '') {
                $root_url = substr($root_url, strpos($root_url, '//'));
            } else {
                $root_url = $protocol.substr($root_url, strpos($root_url, '://'));
            }
        }

        if ($reserve_routing) {
            $uri = get_instance()->router->_reverse_routing($uri);
        }

        return $root_url.ltrim($this->_uri_string($uri), '/');
    }

    // -------------------------------------------------------------

    /**
     * Theme URL
     *
     * Returns theme_url [. uri_string]
     *
     * @param    string|string[] $uri URI string or an array of segments
     * @param    string $protocol
     *
     * @return string
     */
    public function theme_url($uri = '', $protocol = null)
    {
        $themeCode = substr($uri, 0, strpos($uri, '/'));
        $themePath = THEMEPATH;
        if (!file_exists($themePath.$themeCode))
            $themePath = VIEWPATH;

        $themePath = substr($themePath, strlen(ROOTPATH));

        $root_url = $this->slash_item('base_url');

        if (isset($protocol)) {
            // For protocol-relative links
            if ($protocol === '') {
                $root_url = substr($root_url, strpos($root_url, '//'));
            } else {
                $root_url = $protocol.substr($root_url, strpos($root_url, '://'));
            }
        }

        return $root_url.$themePath.ltrim($this->_uri_string($uri), '/');
    }

    // -------------------------------------------------------------

    /**
     *
     */
    public function readDBConfigCache()
    {
        $cacheFilePath = $this->getCacheFilePath();

        if (!file_exists($cacheFilePath))
            $this->writeDBConfigCache();

        return unserialize(file_get_contents($cacheFilePath));
    }

    /**
     * Write the system config values into a cache file
     * to reduce initial database query
     *
     * @param array $config
     *
     * @return bool
     */
    public function writeDBConfigCache($config = [])
    {
        $cacheDir = dirname(($this->cachePath));
        if (!is_dir($cacheDir) OR !is_really_writable($cacheDir)) {
            log_message('error', 'Unable to write cache file: '.$this->cachePath);

            return FALSE;
        }

        $configArray = !empty($config) ? $config : $this->get_db_config();

        if (!is_array($configArray))
            return FALSE;

        $_configArray = [];
        foreach ($configArray as $item) {
            if (!in_array($item['sort'], ['prefs', 'config']))
                continue;

            $_configArray[$item['item']] = !empty($item['serialized']) ?
                unserialize($item['value']) : $item['value'];
        }

        $serializedConfigArray = serialize($_configArray);

        $cacheFilePath = $this->getCacheFilePath();
        if (!$fp = @fopen($cacheFilePath, FOPEN_WRITE_CREATE))
            return FALSE;

        flock($fp, LOCK_EX);
        fwrite($fp, $serializedConfigArray);
        flock($fp, LOCK_UN);
        fclose($fp);

        @chmod($cacheFilePath, FILE_READ_MODE);

        return TRUE;
    }

    /**
     * @param array $cacheArray
     *
     * @return string
     */
    public function getCacheFilePath()
    {
        $path = (($path = config_item('cache_path')) === '') ? TI_APPPATH.'cache/' : $path;
        $this->cachePath = $path.md5("{$this->item('base_url')}/system_config");

        return $this->cachePath;
    }

    /**
     * Load config from database
     *
     * Fetches the config values from the database and adds them to config array
     */
    public function get_db_config()
    {
        if ($this->_db_config_loaded === TRUE) {
            return;
        }

        require_once BASEPATH.'database/DB.php';
        $DB = DB('', null);

        // Make sure the database is connected and settings table exists
        if ($DB->conn_id !== FALSE AND $DB->table_exists('settings')) {
            $this->_db_config_loaded = TRUE;

            return $DB->get('settings')->result_array();
        }
    }

    /**
     * @param array $config
     * @param array $requiredConfig
     * @param bool $fail_gracefully
     *
     * @return bool|array
     */
    public function validate($config, $requiredConfig = null, $fail_gracefully = FALSE)
    {
        if (is_null($requiredConfig))
            return $config;

        foreach ($requiredConfig as $item) {
            if (!array_key_exists($item, $config)) {
                if ($fail_gracefully === FALSE)
                    return FALSE;

                show_error("Config must define array index '{$item}' used by ".get_called_class());
            }
        }

        return $config;
    }

    protected function _mx_load($file, $use_sections, $fail_gracefully, $_module)
    {
        if (in_array($file, $this->is_loaded, TRUE)) return $this->item($file);

        $_module OR $_module = CI::$APP->router->fetch_module();
        list($path, $_file) = Modules::find($file, $_module, 'config/');

        if ($path === FALSE) {
            $this->_ci_load($file, $use_sections, $fail_gracefully);

            return $this->item($file);
        }

        $file = $_file;
        if ($config = Modules::load_file($file, $path, 'config')) {
            /* reference to the config array */
            $current_config =& $this->config;

            if ($use_sections === TRUE) {
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

    protected function _ci_load($file, $use_sections, $fail_gracefully)
    {
        $file = ($file === '') ? 'config' : str_replace('.php', '', $file);
        $loaded = FALSE;

        foreach ($this->_config_paths as $path) {
            foreach ([$file, ENVIRONMENT.DIRECTORY_SEPARATOR.$file] as $location) {
                $file_path = $path.'config/'.$location.'.php';
                if (in_array($file_path, $this->is_loaded, TRUE)) {
                    return TRUE;
                }

                if (!file_exists($file_path)) {
                    continue;
                }

                include($file_path);

                if (!isset($config) OR !is_array($config)) {
                    if ($fail_gracefully === TRUE) {
                        return FALSE;
                    }

                    show_error('Your '.$file_path.' file does not appear to contain a valid configuration array.');
                }

                if ($use_sections === TRUE) {
                    $this->config[$file] = isset($this->config[$file])
                        ? array_merge($this->config[$file], $config)
                        : $config;
                } else {
                    $this->config = array_merge($this->config, $config);
                }

                $this->is_loaded[] = $file_path;
                $config = null;
                $loaded = TRUE;
                log_message('debug', 'Config file loaded: '.$file_path);
            }
        }

        if ($loaded === TRUE) {
            return TRUE;
        } elseif ($fail_gracefully === TRUE) {
            return FALSE;
        }

        show_error('The configuration file '.$file.'.php does not exist.');
    }

}