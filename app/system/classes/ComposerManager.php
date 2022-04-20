<?php

namespace System\Classes;

use Igniter\Flame\Support\Facades\File;

/**
 * ComposerManager Class
 */
class ComposerManager
{
    use \Igniter\Flame\Traits\Singleton;

    /**
     * @var \Composer\Autoload\ClassLoader The primary composer instance.
     */
    protected $loader;

    protected $namespacePool = [];

    protected $psr4Pool = [];

    protected $classMapPool = [];

    protected $includeFilesPool = [];

    protected $installedPackages = [];

    public function initialize()
    {
        $this->loader = require base_path('/vendor/autoload.php');
        $this->preloadPools();
        $this->loadInstalledPackages();
    }

    /**
     * Similar function to including vendor/autoload.php.
     *
     * @param string $vendorPath Absoulte path to the vendor directory.
     *
     * @return void
     */
    public function autoload($vendorPath)
    {
        $dir = $vendorPath.'/composer';

        if (file_exists($file = $dir.'/autoload_namespaces.php')) {
            $map = require $file;
            foreach ($map as $namespace => $path) {
                if (isset($this->namespacePool[$namespace])) continue;
                $this->loader->set($namespace, $path);
                $this->namespacePool[$namespace] = true;
            }
        }

        if (file_exists($file = $dir.'/autoload_psr4.php')) {
            $map = require $file;
            foreach ($map as $namespace => $path) {
                if (isset($this->psr4Pool[$namespace])) continue;
                $this->loader->setPsr4($namespace, $path);
                $this->psr4Pool[$namespace] = true;
            }
        }

        if (file_exists($file = $dir.'/autoload_classmap.php')) {
            $classMap = require $file;
            if ($classMap) {
                $classMapDiff = array_diff_key($classMap, $this->classMapPool);
                $this->loader->addClassMap($classMapDiff);
                $this->classMapPool += array_fill_keys(array_keys($classMapDiff), true);
            }
        }

        if (file_exists($file = $dir.'/autoload_files.php')) {
            $includeFiles = require $file;
            foreach ($includeFiles as $includeFile) {
                $relativeFile = $this->stripVendorDir($includeFile, $vendorPath);
                if (isset($this->includeFilesPool[$relativeFile])) continue;
                require $includeFile;
                $this->includeFilesPool[$relativeFile] = true;
            }
        }
    }

    public function getPackageVersion($name)
    {
        return array_get($this->installedPackages->get($name, []), 'version');
    }

    public function listInstalledPackages($vendorPath)
    {
        return $this->installedPackages;
    }

    public function getConfig($path, $type = 'extension')
    {
        $composer = json_decode(File::get($path.'/composer.json'), true) ?? [];

        if (!$config = array_get($composer, 'extra.tastyigniter-'.$type, []))
            return $config;

        if (array_key_exists('description', $composer))
            $config['description'] = $composer['description'];

        if (array_key_exists('authors', $composer))
            $config['author'] = $composer['authors'][0]['name'];

        if (!array_key_exists('homepage', $config) && array_key_exists('homepage', $composer))
            $config['homepage'] = $composer['homepage'];

        return $config;
    }

    protected function preloadPools()
    {
        $this->classMapPool = array_fill_keys(array_keys($this->loader->getClassMap()), true);
        $this->namespacePool = array_fill_keys(array_keys($this->loader->getPrefixes()), true);
        $this->psr4Pool = array_fill_keys(array_keys($this->loader->getPrefixesPsr4()), true);
        $this->includeFilesPool = $this->preloadIncludeFilesPool();
    }

    protected function preloadIncludeFilesPool()
    {
        $result = [];
        $vendorPath = base_path().'/vendor';

        if (file_exists($file = $vendorPath.'/composer/autoload_files.php')) {
            $includeFiles = require $file;
            foreach ($includeFiles as $includeFile) {
                $relativeFile = $this->stripVendorDir($includeFile, $vendorPath);
                $result[$relativeFile] = true;
            }
        }

        return $result;
    }

    /**
     * Removes the vendor directory from a path.
     *
     * @param string $path
     *
     * @return string
     */
    protected function stripVendorDir($path, $vendorDir)
    {
        $path = realpath($path);
        $vendorDir = realpath($vendorDir);

        if (strpos($path, $vendorDir) === 0) {
            $path = substr($path, strlen($vendorDir));
        }

        return $path;
    }

    protected function loadInstalledPackages()
    {
        $path = base_path('/vendor/composer/installed.json');

        $installed = File::exists($path) ? json_decode(File::get($path), true) : [];

        // Structure of the installed.json manifest in different in Composer 2.0
        $installedPackages = $installed['packages'] ?? $installed;

        $this->installedPackages = collect($installedPackages)
            ->whereIn('type', ['tastyigniter-extension', 'tastyigniter-theme'])
            ->mapWithKeys(function ($package) {
                $code = array_get($package, 'extra.tastyigniter-extension.code',
                    array_get($package, 'extra.tastyigniter-theme.code'),
                    array_get($package, 'name')
                );

                return [$code => $package];
            });
    }
}
