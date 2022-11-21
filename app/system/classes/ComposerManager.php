<?php

namespace System\Classes;

use Composer\Config\JsonConfigSource;
use Composer\Console\Application;
use Composer\Json\JsonFile;
use Composer\Json\JsonManipulator;
use Composer\Util\Platform;
use Igniter\Flame\Support\Facades\File;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * ComposerManager Class
 */
class ComposerManager
{
    use \Igniter\Flame\Traits\Singleton;

    protected $logs = [];

    /**
     * The output interface implementation.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $logsOutput;

    /**
     * @var \Composer\Autoload\ClassLoader The primary composer instance.
     */
    protected $loader;

    protected $workingDir;

    protected $composerBackup;

    protected $namespacePool = [];

    protected $psr4Pool = [];

    protected $classMapPool = [];

    protected $includeFilesPool = [];

    protected $installedPackages = [];

    protected static $corePackages = [
        'tastyigniter/flame',
        'tastyigniter/ti-module-system',
        'tastyigniter/ti-module-admin',
        'tastyigniter/ti-module-main',
    ];

    public function initialize()
    {
        $this->loader = require base_path('/vendor/autoload.php');
        $this->preloadPools();
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
        return array_get($this->loadInstalledPackages()->get($name, []), 'version');
    }

    public function getPackageName($name)
    {
        return array_get($this->loadInstalledPackages()->get($name, []), 'name');
    }

    public function listInstalledPackages()
    {
        return $this->loadInstalledPackages();
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
        if ($this->installedPackages)
            return $this->installedPackages;

        $path = base_path('vendor/composer/installed.json');

        $installed = File::exists($path) ? json_decode(File::get($path), true) : [];

        // Structure of the installed.json manifest in different in Composer 2.0
        $installedPackages = $installed['packages'] ?? $installed;

        return $this->installedPackages = collect($installedPackages)
            ->whereIn('type', ['tastyigniter-extension', 'tastyigniter-theme'])
            ->mapWithKeys(function ($package) {
                $code = array_get($package, 'extra.tastyigniter-extension.code',
                    array_get($package, 'extra.tastyigniter-theme.code'),
                    array_get($package, 'name')
                );

                return [$code => $package];
            });
    }

    //
    //
    //

    public function requireCore($coreVersion)
    {
        $corePackages = collect(self::$corePackages)->map(function ($package) use ($coreVersion) {
            return $package == 'tastyigniter/flame' ? $package : $package.':'.$coreVersion;
        })->all();

        return $this->require($corePackages);
    }

    public function require(array $packages = [])
    {
        $options = ['--no-interaction' => true, '--no-progress' => true];

        return $this->runCommand('require', $packages, $options);
    }

    public function remove(array $packages = [])
    {
        $options = ['--no-interaction' => true];

        return $this->runCommand('remove', $packages, $options);
    }

    public function addRepository($name, $type, $address, $options = [])
    {
        $config = new JsonConfigSource(new JsonFile($this->getJsonPath()));

        $config->addRepository($name, array_merge([
            'type' => $type,
            'url' => $address,
        ], $options));
    }

    public function removeRepository($name)
    {
        $config = new JsonConfigSource(new JsonFile($this->getJsonPath()));

        $config->removeConfigSetting($name);
    }

    public function hasRepository($address): bool
    {
        $config = (new JsonFile($this->getJsonPath()))->read();

        return collect($config['repositories'] ?? [])
            ->contains(function ($repository) use ($address) {
                return rtrim($repository['url'], '/') === $address;
            });
    }

    public function addAuthCredentials($hostname, $username, $password, $type = 'http-basic')
    {
        $config = new JsonConfigSource(new JsonFile($this->getAuthPath()), true);

        $config->addConfigSetting($type.'.'.$hostname, [
            'username' => $username,
            'password' => $password,
        ]);
    }

    protected function getJsonPath(): string
    {
        return base_path('composer.json');
    }

    protected function getAuthPath(): string
    {
        return base_path('auth.json');
    }

    protected function runCommand($action, array $packages = [], array $options = [])
    {
        $this->assertPhpIniSet();
        $this->assertHomeEnvSet();

        try {
            $this->assertHomeDirectory();

            $stream = fopen('php://temp', 'wb+');
            $output = new StreamOutput($stream);

            $application = new Application();
            $application->setAutoExit(false);
            $application->setCatchExceptions(false);
            $exitCode = $application->run(new ArrayInput([
                    'command' => $action,
                    'packages' => $packages,
                ] + $options), $output);

            rewind($stream);
            $this->log(stream_get_contents($stream));
        }
        finally {
            $this->assertWorkingDirectory();
        }

        return $exitCode === 0;
    }

    //
    //
    //

    protected function writePackages(array $requirements)
    {
        $result = null;
        $requireKey = 'require';
        $removeKey = 'require-dev';
        $json = new JsonFile($this->getJsonPath());

        $contents = file_get_contents($json->getPath());
        $manipulator = new JsonManipulator($contents);

        foreach ($requirements as $package => $version) {
            $result = $version !== false
                ? $manipulator->addLink($requireKey, $package, $version, true)
                : $manipulator->removeSubNode($requireKey, $package);

            if ($result) {
                $result = $manipulator->removeSubNode($removeKey, $package);
            }
        }

        if ($result) {
            $manipulator->removeMainKeyIfEmpty($removeKey);
            file_put_contents($json->getPath(), $manipulator->getContents());

            return;
        }

        // Fallback update
        $composerDefinition = $json->read();
        foreach ($requirements as $package => $version) {
            if ($version !== false) {
                $composerDefinition[$requireKey][$package] = $version;
            }
            else {
                unset($composerDefinition[$requireKey][$package]);
            }

            unset($composerDefinition[$removeKey][$package]);

            if (isset($composerDefinition[$removeKey]) && count($composerDefinition[$removeKey]) === 0) {
                unset($composerDefinition[$removeKey]);
            }
        }

        $json->write($composerDefinition);
    }

    protected function restoreComposerFile()
    {
        if ($this->composerBackup) {
            file_put_contents($this->getJsonPath(), $this->composerBackup);
        }
    }

    protected function backupComposerFile()
    {
        $this->composerBackup = file_get_contents($this->getJsonPath());
    }

    //
    // Asserts
    //

    protected function assertPhpIniSet()
    {
        @set_time_limit(3600);
        ini_set('max_input_time', 0);
        ini_set('max_execution_time', 0);
    }

    protected function assertHomeEnvSet()
    {
        if (Platform::getEnv('COMPOSER_HOME'))
            return;

        $tempPath = temp_path('composer');
        if (!file_exists($tempPath)) {
            @mkdir($tempPath);
        }

        Platform::putEnv('COMPOSER_HOME', $tempPath);
    }

    protected function assertHomeDirectory()
    {
        $this->workingDir = getcwd();
        chdir(dirname($this->getJsonPath()));
    }

    protected function assertWorkingDirectory()
    {
        chdir($this->workingDir);
    }

    //
    //
    //

    /**
     * Set the output implementation that should be used by the console.
     *
     * @param \Illuminate\Console\OutputStyle $output
     * @return $this
     */
    public function setLogsOutput($output)
    {
        $this->logsOutput = $output;

        return $this;
    }

    public function log($message)
    {
        if (!is_null($this->logsOutput))
            $this->logsOutput->writeln($message);

        $this->logs[] = $message;

        return $this;
    }

    /**
     * @return \System\Classes\UpdateManager $this
     */
    public function resetLogs()
    {
        $this->logs = [];

        return $this;
    }

    public function getLogs()
    {
        return $this->logs;
    }
}
