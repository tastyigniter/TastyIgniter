<?php

namespace League\Glide;

use Closure;
use InvalidArgumentException;
use League\Flysystem\FilesystemException as FilesystemV2Exception;
use League\Flysystem\FilesystemOperator;
use League\Glide\Api\ApiInterface;
use League\Glide\Filesystem\FileNotFoundException;
use League\Glide\Filesystem\FilesystemException;
use League\Glide\Responses\ResponseFactoryInterface;

class Server
{
    /**
     * Source file system.
     *
     * @var FilesystemOperator
     */
    protected $source;

    /**
     * Source path prefix.
     *
     * @var string
     */
    protected $sourcePathPrefix;

    /**
     * Cache file system.
     *
     * @var FilesystemOperator
     */
    protected $cache;

    /**
     * Cache path prefix.
     *
     * @var string
     */
    protected $cachePathPrefix;

    /**
     * Temporary EXIF data directory.
     *
     * @var string
     */
    protected $tempDir;

    /**
     * Whether to group cache in folders.
     *
     * @var bool
     */
    protected $groupCacheInFolders = true;

    /**
     * Whether to cache with file extensions.
     *
     * @var bool
     */
    protected $cacheWithFileExtensions = false;

    /**
     * Image manipulation API.
     *
     * @var ApiInterface
     */
    protected $api;

    /**
     * Response factory.
     *
     * @var ResponseFactoryInterface|null
     */
    protected $responseFactory;

    /**
     * Base URL.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Default image manipulations.
     *
     * @var array
     */
    protected $defaults = [];

    /**
     * Preset image manipulations.
     *
     * @var array
     */
    protected $presets = [];

    /**
     * Custom cache path callable.
     *
     * @var \Closure|null
     */
    protected $cachePathCallable;

    /**
     * Create Server instance.
     *
     * @param FilesystemOperator $source Source file system.
     * @param FilesystemOperator $cache  Cache file system.
     * @param ApiInterface       $api    Image manipulation API.
     */
    public function __construct(FilesystemOperator $source, FilesystemOperator $cache, ApiInterface $api)
    {
        $this->setSource($source);
        $this->setCache($cache);
        $this->setApi($api);
        $this->tempDir = sys_get_temp_dir();
    }

    /**
     * Set source file system.
     *
     * @param FilesystemOperator $source Source file system.
     *
     * @return void
     */
    public function setSource(FilesystemOperator $source)
    {
        $this->source = $source;
    }

    /**
     * Get source file system.
     *
     * @return FilesystemOperator Source file system.
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set source path prefix.
     *
     * @param string $sourcePathPrefix Source path prefix.
     *
     * @return void
     */
    public function setSourcePathPrefix($sourcePathPrefix)
    {
        $this->sourcePathPrefix = trim($sourcePathPrefix, '/');
    }

    /**
     * Get source path prefix.
     *
     * @return string Source path prefix.
     */
    public function getSourcePathPrefix()
    {
        return $this->sourcePathPrefix;
    }

    /**
     * Get source path.
     *
     * @param string $path Image path.
     *
     * @return string The source path.
     *
     * @throws FileNotFoundException
     */
    public function getSourcePath($path)
    {
        $path = trim($path, '/');

        $baseUrl = $this->baseUrl.'/';

        if (substr($path, 0, strlen($baseUrl)) === $baseUrl) {
            $path = trim(substr($path, strlen($baseUrl)), '/');
        }

        if ('' === $path) {
            throw new FileNotFoundException('Image path missing.');
        }

        if ($this->sourcePathPrefix) {
            $path = $this->sourcePathPrefix.'/'.$path;
        }

        return rawurldecode($path);
    }

    /**
     * Check if a source file exists.
     *
     * @param string $path Image path.
     *
     * @return bool Whether the source file exists.
     */
    public function sourceFileExists($path)
    {
        try {
            return $this->source->fileExists($this->getSourcePath($path));
        } catch (FilesystemV2Exception $exception) {
            return false;
        }
    }

    /**
     * Set base URL.
     *
     * @param string $baseUrl Base URL.
     *
     * @return void
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = trim($baseUrl, '/');
    }

    /**
     * Get base URL.
     *
     * @return string Base URL.
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Set cache file system.
     *
     * @param FilesystemOperator $cache Cache file system.
     *
     * @return void
     */
    public function setCache(FilesystemOperator $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get cache file system.
     *
     * @return FilesystemOperator Cache file system.
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Set cache path prefix.
     *
     * @param string $cachePathPrefix Cache path prefix.
     *
     * @return void
     */
    public function setCachePathPrefix($cachePathPrefix)
    {
        $this->cachePathPrefix = trim($cachePathPrefix, '/');
    }

    /**
     * Get cache path prefix.
     *
     * @return string Cache path prefix.
     */
    public function getCachePathPrefix()
    {
        return $this->cachePathPrefix;
    }

    /**
     * Get temporary EXIF data directory.
     *
     * @return string
     */
    public function getTempDir()
    {
        return $this->tempDir;
    }

    /**
     * Set temporary EXIF data directory. This directory must be a local path and exists on the filesystem.
     *
     * @param string $tempDir
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setTempDir($tempDir)
    {
        if (!$tempDir || !is_dir($tempDir)) {
            throw new InvalidArgumentException(sprintf('Invalid temp dir provided: "%s" does not exist.', $tempDir));
        }

        $this->tempDir = rtrim($tempDir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
    }

    /**
     * Set the group cache in folders setting.
     *
     * @param bool $groupCacheInFolders Whether to group cache in folders.
     *
     * @return void
     */
    public function setGroupCacheInFolders($groupCacheInFolders)
    {
        $this->groupCacheInFolders = $groupCacheInFolders;
    }

    /**
     * Get the group cache in folders setting.
     *
     * @return bool Whether to group cache in folders.
     */
    public function getGroupCacheInFolders()
    {
        return $this->groupCacheInFolders;
    }

    /**
     * Set the cache with file extensions setting.
     *
     * @param bool $cacheWithFileExtensions Whether to cache with file extensions.
     *
     * @return void
     */
    public function setCacheWithFileExtensions($cacheWithFileExtensions)
    {
        $this->cacheWithFileExtensions = $cacheWithFileExtensions;
    }

    /**
     * Get the cache with file extensions setting.
     *
     * @return bool Whether to cache with file extensions.
     */
    public function getCacheWithFileExtensions()
    {
        return $this->cacheWithFileExtensions;
    }

    /**
     * Set a custom cachePathCallable.
     *
     * @param \Closure|null $cachePathCallable The custom cache path callable. It receives the same arguments as @see getCachePath
     */
    public function setCachePathCallable(?Closure $cachePathCallable)
    {
        $this->cachePathCallable = $cachePathCallable;
    }

    /**
     * Gets the custom cachePathCallable.
     *
     * @return \Closure|null The custom cache path callable. It receives the same arguments as @see getCachePath
     */
    public function getCachePathCallable()
    {
        return $this->cachePathCallable;
    }

    /**
     * Get cache path.
     *
     * @param string $path   Image path.
     * @param array  $params Image manipulation params.
     *
     * @return string Cache path.
     *
     * @throws FileNotFoundException
     */
    public function getCachePath($path, array $params = [])
    {
        $customCallable = $this->getCachePathCallable();
        if (null !== $customCallable) {
            $boundCallable = Closure::bind($customCallable, $this, static::class);

            return $boundCallable($path, $params);
        }

        $sourcePath = $this->getSourcePath($path);

        if ($this->sourcePathPrefix) {
            $sourcePath = substr($sourcePath, strlen($this->sourcePathPrefix) + 1);
        }

        $params = $this->getAllParams($params);
        unset($params['s'], $params['p']);
        ksort($params);

        $cachedPath = md5($sourcePath.'?'.http_build_query($params));

        if ($this->groupCacheInFolders) {
            $cachedPath = $sourcePath.'/'.$cachedPath;
        }

        if ($this->cachePathPrefix) {
            $cachedPath = $this->cachePathPrefix.'/'.$cachedPath;
        }

        if ($this->cacheWithFileExtensions) {
            $ext = (isset($params['fm']) ? $params['fm'] : pathinfo($path)['extension']);
            $ext = ('pjpg' === $ext) ? 'jpg' : $ext;
            $cachedPath .= '.'.$ext;
        }

        return $cachedPath;
    }

    /**
     * Check if a cache file exists.
     *
     * @param string $path   Image path.
     * @param array  $params Image manipulation params.
     *
     * @return bool Whether the cache file exists.
     */
    public function cacheFileExists($path, array $params)
    {
        try {
            return $this->cache->fileExists(
                $this->getCachePath($path, $params)
            );
        } catch (FilesystemV2Exception $exception) {
            return false;
        }
    }

    /**
     * Delete cached manipulations for an image.
     *
     * @param string $path Image path.
     *
     * @return bool Whether the delete succeeded.
     */
    public function deleteCache($path)
    {
        if (!$this->groupCacheInFolders) {
            throw new InvalidArgumentException('Deleting cached image manipulations is not possible when grouping cache into folders is disabled.');
        }

        try {
            $this->cache->deleteDirectory(
                dirname($this->getCachePath($path))
            );

            return true;
        } catch (FilesystemV2Exception $exception) {
            return false;
        }
    }

    /**
     * Set image manipulation API.
     *
     * @param ApiInterface $api Image manipulation API.
     *
     * @return void
     */
    public function setApi(ApiInterface $api)
    {
        $this->api = $api;
    }

    /**
     * Get image manipulation API.
     *
     * @return ApiInterface Image manipulation API.
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Set default image manipulations.
     *
     * @param array $defaults Default image manipulations.
     *
     * @return void
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
    }

    /**
     * Get default image manipulations.
     *
     * @return array Default image manipulations.
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Set preset image manipulations.
     *
     * @param array $presets Preset image manipulations.
     *
     * @return void
     */
    public function setPresets(array $presets)
    {
        $this->presets = $presets;
    }

    /**
     * Get preset image manipulations.
     *
     * @return array Preset image manipulations.
     */
    public function getPresets()
    {
        return $this->presets;
    }

    /**
     * Get all image manipulations params, including defaults and presets.
     *
     * @param array $params Image manipulation params.
     *
     * @return array All image manipulation params.
     */
    public function getAllParams(array $params)
    {
        $all = $this->defaults;

        if (isset($params['p'])) {
            foreach (explode(',', $params['p']) as $preset) {
                if (isset($this->presets[$preset])) {
                    $all = array_merge($all, $this->presets[$preset]);
                }
            }
        }

        return array_merge($all, $params);
    }

    /**
     * Set response factory.
     *
     * @param ResponseFactoryInterface|null $responseFactory Response factory.
     *
     * @return void
     */
    public function setResponseFactory(?ResponseFactoryInterface $responseFactory = null)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Get response factory.
     *
     * @return ResponseFactoryInterface|null Response factory.
     */
    public function getResponseFactory()
    {
        return $this->responseFactory;
    }

    /**
     * Generate and return image response.
     *
     * @param string $path   Image path.
     * @param array  $params Image manipulation params.
     *
     * @return mixed Image response.
     *
     * @throws InvalidArgumentException
     * @throws FileNotFoundException
     * @throws FilesystemException
     */
    public function getImageResponse($path, array $params)
    {
        if (is_null($this->responseFactory)) {
            throw new InvalidArgumentException('Unable to get image response, no response factory defined.');
        }

        $path = $this->makeImage($path, $params);

        return $this->responseFactory->create($this->cache, $path);
    }

    /**
     * Generate and return Base64 encoded image.
     *
     * @param string $path   Image path.
     * @param array  $params Image manipulation params.
     *
     * @return string Base64 encoded image.
     *
     * @throws FileNotFoundException
     * @throws FilesystemException
     */
    public function getImageAsBase64($path, array $params)
    {
        $path = $this->makeImage($path, $params);

        try {
            $source = $this->cache->read($path);

            return 'data:'.$this->cache->mimeType($path).';base64,'.base64_encode($source);
        } catch (FilesystemV2Exception $exception) {
            throw new FilesystemException('Could not read the image `'.$path.'`.');
        }
    }

    /**
     * Generate and output image.
     *
     * @param string $path   Image path.
     * @param array  $params Image manipulation params.
     *
     * @throws InvalidArgumentException
     * @throws FileNotFoundException
     * @throws FilesystemException
     *
     * @return void
     */
    public function outputImage($path, array $params)
    {
        $path = $this->makeImage($path, $params);

        try {
            header('Content-Type:'.$this->cache->mimeType($path));
            header('Content-Length:'.$this->cache->fileSize($path));
            header('Cache-Control:'.'max-age=31536000, public');
            header('Expires:'.date_create('+1 years')->format('D, d M Y H:i:s').' GMT');

            $stream = $this->cache->readStream($path);

            if (0 !== ftell($stream)) {
                rewind($stream);
            }
            fpassthru($stream);
            fclose($stream);
        } catch (FilesystemV2Exception $exception) {
            throw new FilesystemException('Could not read the image `'.$path.'`.');
        }
    }

    /**
     * Generate manipulated image.
     *
     * @param string $path   Image path.
     * @param array  $params Image manipulation params.
     *
     * @return string Cache path.
     *
     * @throws FileNotFoundException
     * @throws FilesystemException
     */
    public function makeImage($path, array $params)
    {
        $sourcePath = $this->getSourcePath($path);
        $cachedPath = $this->getCachePath($path, $params);

        if (true === $this->cacheFileExists($path, $params)) {
            return $cachedPath;
        }

        if (false === $this->sourceFileExists($path)) {
            throw new FileNotFoundException('Could not find the image `'.$sourcePath.'`.');
        }

        try {
            $source = $this->source->read(
                $sourcePath
            );
        } catch (FilesystemV2Exception $exception) {
            throw new FilesystemException('Could not read the image `'.$sourcePath.'`.');
        }

        // We need to write the image to the local disk before
        // doing any manipulations. This is because EXIF data
        // can only be read from an actual file.
        $tmp = tempnam($this->tempDir, 'Glide');

        if (false === file_put_contents($tmp, $source)) {
            throw new FilesystemException('Unable to write temp file for `'.$sourcePath.'`.');
        }

        try {
            $this->cache->write(
                $cachedPath,
                $this->api->run($tmp, $this->getAllParams($params))
            );
        } catch (FilesystemV2Exception $exception) {
            throw new FilesystemException('Could not write the image `'.$cachedPath.'`.', 0, $exception);
        } finally {
            unlink($tmp);
        }

        return $cachedPath;
    }
}
