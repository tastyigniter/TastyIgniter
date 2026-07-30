<?php

namespace League\Glide;

use Intervention\Image\ImageManager;
use InvalidArgumentException;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Glide\Api\Api;
use League\Glide\Manipulators\Background;
use League\Glide\Manipulators\Blur;
use League\Glide\Manipulators\Border;
use League\Glide\Manipulators\Brightness;
use League\Glide\Manipulators\Contrast;
use League\Glide\Manipulators\Crop;
use League\Glide\Manipulators\Encode;
use League\Glide\Manipulators\Filter;
use League\Glide\Manipulators\Flip;
use League\Glide\Manipulators\Gamma;
use League\Glide\Manipulators\Orientation;
use League\Glide\Manipulators\Pixelate;
use League\Glide\Manipulators\Sharpen;
use League\Glide\Manipulators\Size;
use League\Glide\Manipulators\Watermark;
use League\Glide\Responses\ResponseFactoryInterface;

class ServerFactory
{
    /**
     * Configuration parameters.
     *
     * @var array
     */
    protected $config;

    /**
     * Create ServerFactory instance.
     *
     * @param array $config Configuration parameters.
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Get configured server.
     *
     * @return Server Configured Glide server.
     */
    public function getServer()
    {
        $server = new Server(
            $this->getSource(),
            $this->getCache(),
            $this->getApi()
        );

        $server->setSourcePathPrefix($this->getSourcePathPrefix() ?: '');
        $server->setCachePathPrefix($this->getCachePathPrefix() ?: '');
        $server->setGroupCacheInFolders($this->getGroupCacheInFolders());
        $server->setCacheWithFileExtensions($this->getCacheWithFileExtensions());
        $server->setDefaults($this->getDefaults());
        $server->setPresets($this->getPresets());
        $server->setBaseUrl($this->getBaseUrl() ?: '');
        $server->setResponseFactory($this->getResponseFactory());
        $server->setCachePathCallable($this->getCachePathCallable());

        if ($this->getTempDir()) {
            $server->setTempDir($this->getTempDir());
        }

        return $server;
    }

    /**
     * Get source file system.
     *
     * @return FilesystemOperator Source file system.
     */
    public function getSource()
    {
        if (!isset($this->config['source'])) {
            throw new InvalidArgumentException('A "source" file system must be set.');
        }

        if (is_string($this->config['source'])) {
            return new Filesystem(
                new LocalFilesystemAdapter($this->config['source'])
            );
        }

        return $this->config['source'];
    }

    /**
     * Get source path prefix.
     *
     * @return string|null Source path prefix.
     */
    public function getSourcePathPrefix()
    {
        if (isset($this->config['source_path_prefix'])) {
            return $this->config['source_path_prefix'];
        }
    }

    /**
     * Get cache file system.
     *
     * @return FilesystemOperator Cache file system.
     */
    public function getCache()
    {
        if (!isset($this->config['cache'])) {
            throw new InvalidArgumentException('A "cache" file system must be set.');
        }

        if (is_string($this->config['cache'])) {
            return new Filesystem(
                new LocalFilesystemAdapter($this->config['cache'])
            );
        }

        return $this->config['cache'];
    }

    /**
     * Get cache path prefix.
     *
     * @return string|null Cache path prefix.
     */
    public function getCachePathPrefix()
    {
        if (isset($this->config['cache_path_prefix'])) {
            return $this->config['cache_path_prefix'];
        }
    }

    /**
     * Get temporary EXIF data directory.
     *
     * @return string
     */
    public function getTempDir()
    {
        if (isset($this->config['temp_dir'])) {
            return $this->config['temp_dir'];
        }
    }

    /**
     * Get cache path callable.
     *
     * @return \Closure|null Cache path callable.
     */
    public function getCachePathCallable()
    {
        return $this->config['cache_path_callable'] ?? null;
    }

    /**
     * Get the group cache in folders setting.
     *
     * @return bool Whether to group cache in folders.
     */
    public function getGroupCacheInFolders()
    {
        if (isset($this->config['group_cache_in_folders'])) {
            return $this->config['group_cache_in_folders'];
        }

        return true;
    }

    /**
     * Get the cache with file extensions setting.
     *
     * @return bool Whether to cache with file extensions.
     */
    public function getCacheWithFileExtensions()
    {
        if (isset($this->config['cache_with_file_extensions'])) {
            return $this->config['cache_with_file_extensions'];
        }

        return false;
    }

    /**
     * Get watermarks file system.
     *
     * @return FilesystemOperator|null Watermarks file system.
     */
    public function getWatermarks()
    {
        if (!isset($this->config['watermarks'])) {
            return;
        }

        if (is_string($this->config['watermarks'])) {
            return new Filesystem(
                new LocalFilesystemAdapter($this->config['watermarks'])
            );
        }

        return $this->config['watermarks'];
    }

    /**
     * Get watermarks path prefix.
     *
     * @return string|null Watermarks path prefix.
     */
    public function getWatermarksPathPrefix()
    {
        if (isset($this->config['watermarks_path_prefix'])) {
            return $this->config['watermarks_path_prefix'];
        }
    }

    /**
     * Get image manipulation API.
     *
     * @return Api Image manipulation API.
     */
    public function getApi()
    {
        return new Api(
            $this->getImageManager(),
            $this->getManipulators()
        );
    }

    /**
     * Get Intervention image manager.
     *
     * @return ImageManager Intervention image manager.
     */
    public function getImageManager()
    {
        $driver = 'gd';

        if (isset($this->config['driver'])) {
            $driver = $this->config['driver'];
        }

        return new ImageManager([
            'driver' => $driver,
        ]);
    }

    /**
     * Get image manipulators.
     *
     * @return array Image manipulators.
     */
    public function getManipulators()
    {
        return [
            new Orientation(),
            new Crop(),
            new Size($this->getMaxImageSize()),
            new Brightness(),
            new Contrast(),
            new Gamma(),
            new Sharpen(),
            new Filter(),
            new Flip(),
            new Blur(),
            new Pixelate(),
            new Watermark($this->getWatermarks(), $this->getWatermarksPathPrefix() ?: ''),
            new Background(),
            new Border(),
            new Encode(),
        ];
    }

    /**
     * Get maximum image size.
     *
     * @return int|null Maximum image size.
     */
    public function getMaxImageSize()
    {
        if (isset($this->config['max_image_size'])) {
            return $this->config['max_image_size'];
        }
    }

    /**
     * Get default image manipulations.
     *
     * @return array Default image manipulations.
     */
    public function getDefaults()
    {
        if (isset($this->config['defaults'])) {
            return $this->config['defaults'];
        }

        return [];
    }

    /**
     * Get preset image manipulations.
     *
     * @return array Preset image manipulations.
     */
    public function getPresets()
    {
        if (isset($this->config['presets'])) {
            return $this->config['presets'];
        }

        return [];
    }

    /**
     * Get base URL.
     *
     * @return string|null Base URL.
     */
    public function getBaseUrl()
    {
        if (isset($this->config['base_url'])) {
            return $this->config['base_url'];
        }
    }

    /**
     * Get response factory.
     *
     * @return ResponseFactoryInterface|null Response factory.
     */
    public function getResponseFactory()
    {
        if (isset($this->config['response'])) {
            return $this->config['response'];
        }
    }

    /**
     * Create configured server.
     *
     * @param array $config Configuration parameters.
     *
     * @return Server Configured server.
     */
    public static function create(array $config = [])
    {
        return (new self($config))->getServer();
    }
}
