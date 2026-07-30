<?php

namespace Stevebauman\Purify\Cache;

use HTMLPurifier_DefinitionCache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilesystemDefinitionCache extends HTMLPurifier_DefinitionCache
{
    /**
     * The filesystem disk.
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    /**
     * Constructor.
     *
     * @param string $type
     */
    public function __construct($type)
    {
        parent::__construct($type);

        $this->disk = Storage::disk(
            config('purify.serializer.disk')
        );
    }

    /**
     * Adds a definition object to the cache.
     *
     * @param \HTMLPurifier_Definition $def
     * @param \HTMLPurifier_Config     $config
     *
     * @return bool|void
     */
    public function add($def, $config)
    {
        if (! $this->checkDefType($def)) {
            return;
        }

        $file = $this->generateFilePath($config);

        if ($this->disk->exists($file)) {
            return false;
        }

        return $this->disk->put($file, serialize($def));
    }

    /**
     * Unconditionally saves a definition object to the cache.
     *
     * @param \HTMLPurifier_Definition $def
     * @param \HTMLPurifier_Config     $config
     *
     * @return bool|void
     */
    public function set($def, $config)
    {
        if (! $this->checkDefType($def)) {
            return;
        }

        $file = $this->generateFilePath($config);

        return $this->disk->put($file, serialize($def));
    }

    /**
     * Replace an object in the cache.
     *
     * @param \HTMLPurifier_Definition $def
     * @param \HTMLPurifier_Config     $config
     *
     * @return bool|void
     */
    public function replace($def, $config)
    {
        if (! $this->checkDefType($def)) {
            return;
        }

        $file = $this->generateFilePath($config);

        if (! $this->disk->exists($file)) {
            return false;
        }

        return $this->disk->put($file, serialize($def));
    }

    /**
     * Retrieves a definition object from the cache.
     *
     * @param \HTMLPurifier_Config $config
     *
     * @return bool|\HTMLPurifier_Config
     */
    public function get($config)
    {
        $file = $this->generateFilePath($config);

        if (! $this->disk->exists($file)) {
            return false;
        }

        return unserialize($this->disk->get($file));
    }

    /**
     * Removes a definition object to the cache.
     *
     * @param \HTMLPurifier_Config $config
     *
     * @return bool
     */
    public function remove($config)
    {
        $file = $this->generateFilePath($config);

        if (! $this->disk->exists($file)) {
            return false;
        }

        return $this->disk->delete($file);
    }

    /**
     * Clears all objects from cache.
     *
     * @param \HTMLPurifier_Config $config
     *
     * @return bool
     */
    public function flush($config)
    {
        $dir = $this->generateDirectoryPath($config);

        foreach ($this->disk->files($dir) as $filename) {
            if (Str::startsWith($filename, '.')) {
                continue;
            }

            $this->disk->delete(
                implode(DIRECTORY_SEPARATOR, [$dir, $filename])
            );
        }

        return true;
    }

    /**
     * Clears all expired (older version or revision) objects from cache.
     *
     * @param \HTMLPurifier_Config $config
     *
     * @return bool
     */
    public function cleanup($config)
    {
        $dir = $this->generateDirectoryPath($config);

        foreach ($this->disk->files($dir) as $filename) {
            if (Str::startsWith($filename, '.')) {
                continue;
            }

            $key = substr($filename, 0, strlen($filename) - 4);

            if ($this->isOld($key, $config)) {
                $this->disk->delete(
                    implode(DIRECTORY_SEPARATOR, [$dir, $filename])
                );
            }
        }

        return true;
    }

    /**
     * Generates the file path.
     *
     * @param \HTMLPurifier_Config $config
     *
     * @return string
     */
    public function generateFilePath($config)
    {
        $key = $this->generateKey($config);

        return $this->generateDirectoryPath($config).'DefinitionCache.php/'.$key.'.ser';
    }

    /**
     * Generates the path to the directory contain this cache's serial files.
     *
     * @note No trailing slash
     *
     * @param \HTMLPurifier_Config $config
     *
     * @return string
     */
    public function generateDirectoryPath($config)
    {
        $base = $this->generateBaseDirectoryPath($config);

        return $base.'/'.$this->type;
    }

    /**
     * Generates path to base directory that contains all definition type
     * serials.
     *
     * @param \HTMLPurifier_Config $config
     *
     * @return string
     */
    public function generateBaseDirectoryPath($config)
    {
        $base = $config->get('Cache.SerializerPath');

        return is_null($base) ? '/' : $base;
    }
}
