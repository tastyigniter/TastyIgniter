<?php

namespace System\Classes;

use Exception;
use File;
use Illuminate\Support\ServiceProvider;
use Lang;
use SystemException;

/**
 * Base Extension Class
 * @package System
 */
class BaseExtension extends ServiceProvider
{
    /**
     * @var array
     */
    protected $config;

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
     */
    public function register()
    {
    }

    /**
     * Initialize method, called right before the request route.
     */
    public function initialize()
    {
    }

    /**
     * Returns information about this extension
     * @return array
     */
    public function extensionMeta()
    {
        $_module = get_class($this);

        $config = $this->getConfigFromFile(sprintf("The configuration file for extension <b>%s</b> does not exist. ".
            "Create the file or override extensionMeta() method in the extension class.", $_module));

        return $config;
    }

    /**
     * Registers any front-end components implemented in this extension.
     * The components must be returned in the following format:
     * ['path/to/class' => ['code' => 'component_code']]
     * @return array
     */
    public function registerComponents()
    {
        return [];
    }

    /**
     * Registers any payment gateway implemented in this extension.
     * The payment gateway must be returned in the following format:
     * ['path/to/class' => 'alias']
     * @return array
     */
    public function registerPaymentGateways()
    {
        return [];
    }

    /**
     * Registers back-end navigation menu items for this extension.
     * @return array
     */
    public function registerNavigation()
    {
        return [];
    }

    /**
     * Registers any back-end permissions used by this extension.
     * @return array
     */
    public function registerPermissions()
    {
        $config = $this->getConfigFromFile();
        if (is_array($config) AND array_key_exists('extension_permission', $config)) {
            return [
                $config['extension_permission']['name'] => $config['extension_permission'],
            ];
        }

        return [];
    }

    /**
     * Registers the back-end setting links used by this extension.
     * @return array
     */
    public function registerSettings()
    {
        return [];
    }

    /**
     * Registers any report widgets provided by this extension.
     * @return array
     */
    public function registerReportWidgets()
    {
        return [];
    }

    /**
     * Registers any form widgets implemented in this plugin.
     * The widgets must be returned in the following format:
     * ['className1' => 'alias'],
     * ['className2' => 'anotherAlias']
     * @return array
     */
    public function registerFormWidgets()
    {
        return [];
    }

    /**
     * Registers any mail templates implemented by this extension.
     * The templates must be returned in the following format:
     * [
     *  'igniter.demo::mail.registration' => 'Registration email to customer.',
     * ]
     * The array key will be used as the template code
     * @return array
     */
    public function registerMailTemplates()
    {
        return [];
    }

    /**
     * Read configuration from Config file
     *
     * @param bool|null $throwException
     *
     * @return array|bool
     */
    protected function getConfigFromFile($throwException = FALSE)
    {
        if (isset($this->config)) {
            return $this->config;
        }

        list($extension,) = explode('\\', get_class($this));

        $this->config = $this->loadConfig($extension, $throwException);

        return $this->config;
    }

    public function loadConfig($name, $throwException = FALSE)
    {
        $config = null;

        try {
            $configPath = realpath(dirname(File::fromClass(get_called_class())));

            $configFile = $configPath.'/extension.json';
            $config = json_decode(File::get($configFile), TRUE);

            foreach ([
                         'code',
                         'name',
                         'description',
                         'version',
                         'author',
                         'icon',
                         'tags',
                     ] as $item) {

                if (!array_key_exists($item, $config)) {
                    if (!$throwException) return FALSE;

                    throw new SystemException(sprintf(
                        Lang::get('system::lang.missing.config_key'),
                        $item, $configFile
                    ));
                }
            }
        } catch (Exception $ex) {
            if (!$throwException) return FALSE;

            throw new SystemException(sprintf(
                "The registration file for extension <b>%s</b> does not appear to contain a valid array."
                , $name
            ));
        }

        return $config;
    }
}
