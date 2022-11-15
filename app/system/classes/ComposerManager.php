<?php

namespace System\Classes;

use Composer\Composer;
use Composer\Config\JsonConfigSource;
use Composer\DependencyResolver\Request;
use Composer\Factory;
use Composer\Installer;
use Composer\IO\BufferIO;
use Composer\IO\ConsoleIO;
use Composer\IO\IOInterface;
use Composer\IO\NullIO;
use Composer\Json\JsonFile;
use Composer\Json\JsonManipulator;
use Composer\Util\Platform;
use DirectoryIterator;
use Exception;
use Igniter\Flame\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Throwable;

/**
 * ComposerManager Class
 */
class ComposerManager
{
    use \Igniter\Flame\Traits\Singleton;

    /**
     * @var IOInterface output
     */
    protected $output;

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

    public function initialize()
    {
        $this->loader = require base_path('/vendor/autoload.php');
        $this->preloadPools();
        $this->setOutput();
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

    public function update(array $packageNames = [])
    {
        $this->assertPhpIniSet();
        $this->assertHomeEnvSet();

        try {
            $this->assertHomeDirectory();
            $this->assertComposerLoaded();

            Installer::create($this->output, $this->makeComposer())
                ->setDevMode(config('app.debug', false))
                ->setUpdateAllowList($packageNames)
                ->setPreferDist()
                ->setOptimizeAutoloader(!config('app.debug', false))
                ->setUpdate(true)
                ->run();
        }
        finally {
            $this->assertWorkingDirectory();
        }
    }

    public function require(array $packages = [])
    {
        $this->assertPhpIniSet();
        $this->assertHomeEnvSet();
        $this->backupComposerFile();

        $lastException = new Exception('Failed to update composer dependencies');

        try {
            $this->assertHomeDirectory();
            $this->assertComposerLoaded();
            $this->writePackages($packages);

            $composer = $this->makeComposer();
            $installer = Installer::create($this->output, $composer)
                ->setDevMode(config('app.debug', false))
                ->setPreferDist()
                ->setUpdate(true)
                ->setUpdateAllowTransitiveDependencies(Request::UPDATE_LISTED_WITH_TRANSITIVE_DEPS);

            // If no lock is present, or the file is brand new, we do not do a
            // partial update as this is not supported by the Installer
            if ($composer->getLocker()->isLocked()) {
                $installer->setUpdateAllowList(array_keys($packages));
            }

            $statusCode = $installer->run();
        }
        catch (Throwable $ex) {
            $statusCode = 1;
            $lastException = $ex;
        }
        finally {
            $this->assertWorkingDirectory();
        }

        if ($statusCode !== 0) {
            $this->restoreComposerFile();
            throw $lastException;
        }
    }

    public function remove(array $packages = [])
    {
        $this->require(array_map(function ($package) {
            return false;
        }, $packages));
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

    protected function makeComposer(): Composer
    {
        $composer = Factory::create($this->output, $this->getJsonPath());

        // Disable scripts
        $composer->getEventDispatcher()->setRunScripts(false);

        // Discard changes to prevent corrupt state
        $composer->getConfig()->merge([
            'config' => [
                'discard-changes' => true,
            ],
        ]);

        return $composer;
    }

    protected function getJsonPath(): string
    {
        return base_path('composer-dev.json');
    }

    protected function getAuthPath(): string
    {
        return base_path('auth.json');
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
        $osHome = Platform::isWindows() ? 'APPDATA' : 'HOME';
        if (Platform::getEnv('COMPOSER_HOME') || Platform::getEnv($osHome)) {
            return;
        }

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

    protected function assertComposerLoaded()
    {
        // Preload root package
        $this->assertPackageLoaded('Composer', base_path('vendor/composer/composer/src/Composer'), false);

        // Preload child packages
        foreach ([
            'Composer\Autoload',
            'Composer\Config',
            'Composer\DependencyResolver',
            'Composer\Downloader',
            'Composer\EventDispatcher',
            'Composer\Exception',
            'Composer\Filter',
            'Composer\Installer',
            'Composer\IO',
            'Composer\Json',
            'Composer\Package',
            'Composer\Platform',
            'Composer\Plugin',
            'Composer\Question',
            'Composer\Repository',
            'Composer\Script',
            'Composer\SelfUpdate',
            'Composer\Util',
        ] as $package) {
            $this->assertPackageLoaded(
                $package,
                base_path('vendor/composer/composer/src/'.str_replace("\\", "/", $package))
            );
        }
    }

    protected function assertPackageLoaded($packageName, $packagePath, $recursive = true)
    {
        $allFiles = $recursive
            ? new RecursiveIteratorIterator(new RecursiveDirectoryIterator($packagePath))
            : new DirectoryIterator($packagePath);

        $phpFiles = new RegexIterator($allFiles, '/\.php$/');
        $packagePathLen = strlen($packagePath);

        foreach ($phpFiles as $phpFile) {
            // Remove base directory and .php extension
            $className = substr($phpFile->getRealPath(), $packagePathLen, -4);

            // Normalize OS path separators, normalize to a class namespace
            $className = trim(str_replace("/", "\\", $className), '\\');

            // Build complete namespace
            $className = $packageName.'\\'.$className;

            // Preload class
            class_exists($className);
        }
    }

    //
    //
    //

    public function setOutput(IOInterface $output = null)
    {
        if ($output === null) {
            $this->output = new NullIO();
        }
        else {
            $this->output = $output;
        }
    }

    public function setOutputCommand(Command $command, InputInterface $input)
    {
        $this->setOutput(new ConsoleIO($input, $command->getOutput(), $command->getHelperSet()));
    }

    public function setOutputBuffer()
    {
        $this->setOutput(new BufferIO());
    }

    public function getOutputBuffer(): string
    {
        if ($this->output instanceof BufferIO) {
            return $this->output->getOutput();
        }

        return '';
    }
}
