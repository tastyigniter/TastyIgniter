<?php

namespace Stevebauman\Purify;

use HTMLPurifier_Config;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Manager;
use InvalidArgumentException;
use Stevebauman\Purify\Definitions\CssDefinition;
use Stevebauman\Purify\Definitions\Definition;

class PurifyManager extends Manager
{
    /**
     * The filesystem manager instance.
     *
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    protected $filesystem;

    /**
     * Constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);

        $this->filesystem = $container->make('filesystem');
    }

    /**
     * Convenience alias for driver().
     *
     * @param string|array|null $config
     *
     * @return Purify
     *
     * @throws \InvalidArgumentException
     */
    public function config($config = null)
    {
        return $this->driver($config);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('purify.default');
    }

    /**
     * Get a driver instance.
     *
     * @param string|array|null $driver
     *
     * @return Purify
     *
     * @throws \InvalidArgumentException
     */
    public function driver($driver = null)
    {
        // First, we will check if the provided "driver" is an array. If so,
        // we're dealing with an inline defined config. We'll serialize it
        // into a string to dynamically define and set its configuration.
        if (is_array($driver)) {
            $config = $driver;

            $driver = md5(serialize($driver));

            $this->config->set("purify.configs.$driver", $config);
        }

        return parent::driver($driver);
    }

    /**
     * Create a new driver instance.
     *
     * @param string|array $driver
     *
     * @return Purify
     *
     * @throws \InvalidArgumentException
     */
    protected function createDriver($driver)
    {
        // First, we will determine if a custom driver creator exists for the given driver and
        // if it does not we will check for a creator method for the driver. Custom creator
        // callbacks allow developers to build their own "drivers" easily using Closures.
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        }

        if ($config = $this->resolveConfig($driver)) {
            return $this->createInstance($driver, $config);
        }

        throw new InvalidArgumentException("Purify config [$driver] not defined.");
    }

    /**
     * Resolve the configuration for the given config name.
     *
     * @param string $name
     *
     * @return array
     */
    protected function resolveConfig($name)
    {
        return $this->config->get("purify.configs.$name");
    }

    /**
     * Resolve the serializer filepath the given config name.
     *
     * @param string $name
     *
     * @return string|false
     */
    protected function resolveSerializerPath($name)
    {
        $path = $this->config->get('purify.serializer.path');

        if (empty($path)) {
            return false;
        }

        return implode(DIRECTORY_SEPARATOR, [$path, $name]);
    }

    /**
     * Create a new Purify instance with the given config.
     *
     * @param string $name
     * @param array  $config
     *
     * @return Purify
     */
    protected function createInstance(string $name, array $config)
    {
        $serializerPath = $this->resolveSerializerPath($name);

        if (! empty($serializerPath)) {
            $this->prepareFilesystemStorage($serializerPath);
        }

        return new Purify(
            $this->createHtmlConfig(array_merge(array_filter([
                'Cache.SerializerPath' => $serializerPath,
            ]), $config))
        );
    }

    /**
     * Prepare the serializer path in the filesystem storage.
     *
     * @param string $serializerPath
     *
     * @return void
     */
    protected function prepareFilesystemStorage(string $serializerPath)
    {
        $disk = $this->config->get('purify.serializer.disk');

        if (empty($disk)) {
            return;
        }

        $storage = $this->filesystem->disk($disk);

        if (! $storage->exists($serializerPath)) {
            $storage->makeDirectory($serializerPath);
        }
    }

    /**
     * Create an HTML purifier configuration instance.
     *
     * @param array $config
     *
     * @return HTMLPurifier_Config
     */
    protected function createHtmlConfig($config)
    {
        $htmlConfig = HTMLPurifier_Config::create($config);

        $htmlConfig->set('HTML.DefinitionID', 'HTML-purify');
        $htmlConfig->set('HTML.DefinitionRev', 1);
        $htmlConfig->set('Cache.DefinitionImpl', config('purify.serializer.cache'));

        if ($definition = $htmlConfig->maybeGetRawHTMLDefinition()) {
            $definitionsClass = $this->config->get('purify.definitions');

            if ($definitionsClass && is_a($definitionsClass, Definition::class, true)) {
                $definitionsClass::apply($definition);
            }
        }

        if ($definition = $htmlConfig->getCSSDefinition()) {
            $definitionsClass = $this->config->get('purify.css-definitions');

            if ($definitionsClass && is_a($definitionsClass, CssDefinition::class, true)) {
                $definitionsClass::apply($definition);
            }
        }

        return $htmlConfig;
    }
}
