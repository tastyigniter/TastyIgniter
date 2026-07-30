<?php

declare(strict_types=1);

namespace Igniter\System\Traits;

use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

trait ConfigMaker
{
    /** Specifies a path to the config directory. */
    public array $configPath = [];

    protected string $configFileExtension = '.php';

    /**
     * Reads the contents of the supplied file and applies it to this object.
     */
    public function loadConfig(mixed $configFile = null, array $requiredConfig = [], $index = null): ?array
    {
        $config = $this->makeConfig($configFile, $requiredConfig);

        if (is_null($index)) {
            return $config;
        }

        return $config[$index] ?? null;
    }

    /**
     * Reads the contents of the supplied file and applies it to this object.
     */
    public function makeConfig(mixed $configFile, array $requiredConfig = []): ?array
    {
        if (!$configFile) {
            $configFile = [];
        }

        // Convert config to array
        if (is_object($configFile)) {
            $config = (array)$configFile;
        } // Embedded config
        elseif (is_array($configFile)) {
            $config = $configFile;
        } // Process config from file contents
        else {
            $configFile = $this->getConfigPath($configFile.$this->configFileExtension);

            if (!File::isFile($configFile)) {
                throw new SystemException(sprintf(
                    Lang::get('igniter::system.not_found.config'), $configFile, static::class,
                ));
            }

            $config = File::getRequire($configFile);
        }

        // Validate required configuration
        foreach ($requiredConfig as $property) {
            if (!is_array($config) || !array_key_exists($property, $config)) {
                throw new SystemException(sprintf(
                    Lang::get('igniter::system.required.config'), static::class, $property,
                ));
            }
        }

        return $config;
    }

    /**
     * Merges two configuration sources, either prepared or not, and returns
     * them as a single configuration object.
     *
     * @return array The config array
     */
    public function mergeConfig(array $configLeft, array $configRight): array
    {
        $configLeft = $this->makeConfig($configLeft);

        $configRight = $this->makeConfig($configRight);

        return array_merge($configLeft, $configRight);
    }

    /**
     * Locates a file based on it's definition. If the file starts with
     * the ~ symbol it will be returned in context of the application base path,
     * otherwise it will be returned in context of the config path.
     */
    public function getConfigPath(string $fileName, null|string|array $configPath = null): string
    {
        if (!$configPath) {
            $configPath = $this->configPath;
        }

        $fileName = File::symbolizePath($fileName);

        if (File::isLocalPath($fileName) || realpath($fileName) !== false) {
            return $fileName;
        }

        foreach ((array)$configPath as $path) {
            $path = File::symbolizePath($path);
            $_fileName = $path.'/'.$fileName;
            if (File::isFile($_fileName)) {
                return $_fileName;
            }
        }

        return $fileName;
    }
}
