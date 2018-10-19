<?php

namespace System\Classes;

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
     * Boot method, called right before the request route.
     */
    public function boot()
    {
    }

    /**
     * Returns information about this extension
     * @return array
     */
    public function extensionMeta()
    {
        return $this->getConfigFromFile();
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
     * Registers any dashboard widgets provided by this extension.
     * @return array
     */
    public function registerDashboardWidgets()
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
     * Registers a new console (artisan) command
     *
     * @param string $key The command name
     * @param string $class The command class
     * @return void
     */
    public function registerConsoleCommand($key, $class)
    {
        $key = 'command.'.$key;

        $this->app->singleton($key, $class);

        $this->commands($key);
    }

    /**
     * Read configuration from Config file
     *
     * @return array|bool
     * @throws SystemException
     */
    protected function getConfigFromFile()
    {
        if (isset($this->config)) {
            return $this->config;
        }

        $className = get_class($this);
        $configPath = realpath(dirname(File::fromClass($className)));
        $configFile = $configPath.'/extension.json';

        if (!File::exists($configFile))
            throw new SystemException("The configuration file for extension <b>{$className}</b> does not exist. ".
                'Create the file or override extensionMeta() method in the extension class.');

        $config = json_decode(File::get($configFile), TRUE) ?? [];
        foreach ([
                     'code',
                     'name',
                     'description',
                     'version',
                     'author',
                     'icon',
                 ] as $item) {

            if (!array_key_exists($item, $config)) {
                throw new SystemException(sprintf(
                    Lang::get('system::lang.missing.config_key'),
                    $item, File::localToPublic($configFile)
                ));
            }
        }

        return $this->config = $config;
    }
}
