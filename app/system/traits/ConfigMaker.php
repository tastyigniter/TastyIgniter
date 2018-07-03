<?php

namespace System\Traits;

use File;
use Lang;
use SystemException;

trait ConfigMaker
{
    /**
     * @var string Specifies a path to the config directory.
     */
    public $configPath;

    protected $configFileExtension = ".php";

    /**
     * Reads the contents of the supplied file and applies it to this object.
     *
     * @param array $configFile
     * @param array $requiredConfig
     * @param null $index
     *
     * @return array
     */
    public function loadConfig($configFile = [], $requiredConfig = [], $index = null)
    {
        $config = $this->makeConfig($configFile, $requiredConfig);

        if (is_null($index))
            return $config;

        return isset($config[$index]) ? $config[$index] : null;
    }

    /**
     * Reads the contents of the supplied file and applies it to this object.
     *
     * @param string|array $configFile
     * @param array $requiredConfig
     *
     * @return array
     * @throws \SystemException
     */
    public function makeConfig($configFile, $requiredConfig = [])
    {
        if (!$configFile) {
            $configFile = [];
        }

        // Convert config to array
        if (is_object($configFile)) {
            $config = (array)$configFile;
        }
        // Embedded config
        elseif (is_array($configFile)) {
            $config = $configFile;
        }
        // Process config from file contents
        else {

            $configFile = $this->getConfigPath($configFile.$this->configFileExtension);

            if (!File::isFile($configFile)) {
                throw new SystemException(sprintf(
                    Lang::get('system::lang.not_found.config'),
                    $configFile, get_called_class()
                ));
            }

            $config = File::getRequire($configFile);
        }

        // Validate required configuration
        foreach ($requiredConfig as $property) {
            if (!is_array($config) OR !array_key_exists($property, $config)) {
                throw new SystemException(sprintf(
                    Lang::get('system::lang.required.config'),
                    get_called_class(), $property
                ));
            }
        }

        return $config;
    }

    /**
     * Merges two configuration sources, either prepared or not, and returns
     * them as a single configuration object.
     *
     * @param $configLeft
     * @param $configRight
     *
     * @return array The config array
     */
    public function mergeConfig($configLeft, $configRight)
    {
        $configLeft = $this->makeConfig($configLeft);

        $configRight = $this->makeConfig($configRight);

        return array_merge($configLeft, $configRight);
    }

    /**
     * Locates a file based on it's definition. If the file starts with
     * the ~ symbol it will be returned in context of the application base path,
     * otherwise it will be returned in context of the config path.
     *
     * @param string $fileName File to load.
     * @param mixed $configPath Explicitly define a config path.
     *
     * @return string Full path to the config file.
     */
    public function getConfigPath($fileName, $configPath = null)
    {
        if (!isset($this->configPath)) {
            $this->configPath = $this->guessConfigPath();
        }

        if (!$configPath) {
            $configPath = $this->configPath;
        }

        $fileName = File::symbolizePath($fileName);

        if (File::isLocalPath($fileName) OR realpath($fileName) !== FALSE) {
            return $fileName;
        }

        if (!is_array($configPath)) {
            $configPath = [$configPath];
        }

        foreach ($configPath as $path) {
            $path = File::symbolizePath($path);
            $_fileName = $path.'/'.$fileName;
            if (File::isFile($_fileName)) {
                return $_fileName;
            }
        }

        return $fileName;
    }

    /**
     * Guess the package path for the called class.
     *
     * @param string $suffix An extra path to attach to the end
     *
     * @return string
     */
    public function guessConfigPath($suffix = '')
    {
        $class = get_called_class();

        return $this->guessConfigPathFrom($class, $suffix);
    }

    /**
     * Guess the package path from a specified class.
     *
     * @param string $class Class to guess path from.
     * @param string $suffix An extra path to attach to the end
     *
     * @return string
     */
    public function guessConfigPathFrom($class, $suffix = '')
    {
        $classFolder = strtolower(class_basename($class));
        $classFile = realpath(dirname(File::fromClass($class)));
        $guessedPath = $classFile ? $classFile.'/'.$classFolder.$suffix : null;

        return $guessedPath;
    }
}