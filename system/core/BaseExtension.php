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
namespace Igniter\Core;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Extension Class
 *
 * @category       Core
 * @package        Igniter\Core\BaseExtension.php
 * @link           http://docs.tastyigniter.com
 */
class BaseExtension
{
    /**
     * @var boolean
     */
    protected $loaded_config = FALSE;

    /**
     * @todo: link with controller autoload property
     * @var array Autoload libraries, models, helpers, and languages
     */
    public $autoload = [];

    /**
     * @var array Extension dependencies
     */
    public $require = [];

    /**
     * @var boolean Determine if this extension should be loaded (false) or not (true).
     */
    public $disabled = FALSE;

    /**
     * Register method called when the extension is first installed.
     * Use migrations to manage database updates instead...
     *
     * @return array
     */
    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function initialize()
    {
    }

    /**
     * Returns information about this extension
     *
     * @return array
     */
    public function extensionMeta()
    {
        $_module = get_class($this);

        $config = $this->getConfigFromFile(sprintf("The configuration file for extension <b>%s</b> does not exist. " .
            "Create the file or override extensionMeta() method in the extension class.", $_module));

        return $config;
    }

    /**
     * Registers any front-end components implemented in this extension.
     *
     * The components must be returned in the following format:
     * ['path/to/class' => 'class']
     *
     * @return array
     */
    public function registerComponents()
    {
        $config = $this->getConfigFromFile();

        if (isset($config['layout_ready']) AND !empty($config['extension_meta']['type']) AND $config['extension_meta']['type'] == 'module') {
            $reflection = new ReflectionClass(get_class($this));
            $_module = basename(dirname($reflection->getFileName()));
            $_class = ucfirst($_module);

            return ["{$_module}/components/{$_class}" => $_module];
        }
    }

    /**
     * Registers any payment gateway implemented in this extension.
     *
     * The payment gateway must be returned in the following format:
     * ['path/to/class' => 'alias']
     *
     * @return array
     */
    public function registerPaymentGateways()
    {
        $config = $this->getConfigFromFile();

        if (isset($config['layout_ready']) AND !empty($config['extension_meta']['type']) AND $config['extension_meta']['type'] == 'payment') {
            $reflection = new ReflectionClass(get_class($this));
            $_module = dirname($reflection->getFileName());
            $_class = ucfirst($_module);

            return ["{$_module}/components/{$_class}" => $_module];
        }
    }

    /**
     * Registers back-end navigation menu items for this extension.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [];
    }

    /**
     * Registers any back-end permissions used by this extension.
     *
     * @return array
     */
    public function registerPermissions()
    {
        $config = $this->getConfigFromFile();
        if (is_array($config) AND array_key_exists('extension_permission', $config)) {
            return $config['extension_permission'];
        }
    }

    /**
     * Registers the back-end setting links used by this extension.
     *
     * @return array
     */
    public function registerSettings()
    {
        $config = $this->getConfigFromFile();

        if (!empty($config['extension_meta']['settings'])) {
            $reflection = new ReflectionClass(get_class($this));
            $_module = basename(dirname($reflection->getFileName()));

            return admin_url($_module . '/settings');
        }
    }

    /**
     * Registers any mail templates implemented by this extension.
     * The templates must be returned in the following format:
     * [
     *  'extension_code/mail/registration' => [
     *      'label' => 'Registration email to customer.',
     *      'subject => 'Welcome to {site_name}'
     *  ]
     * ]
     *
     * The array key last segment will be used as the template code
     *
     * @return array
     */
    public function registerMailTemplates()
    {
        return [];
    }

    /**
     * Read configuration from Config file
     *
     * @param string|null $error_message
     *
     * @return array|bool
     */
    protected function getConfigFromFile($error_message = null)
    {
        if ($this->loaded_config !== FALSE) {
            return $this->loaded_config;
        }

        $config = null;

        list($_module,) = explode('\\', get_class($this));

        $this->loaded_config = \Modules::check_config($_module, $error_message);

        return $this->loaded_config;
    }
}

/* End of file BaseExtension.php */
/* Location: ./system/tastyigniter/core/BaseExtension.php */
