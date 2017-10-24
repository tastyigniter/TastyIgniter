<?php

namespace System\Classes;
use Igniter\Flame\Traits\Singleton;

/**
 * ComposerManager Class
 *
 * @package System
 */
class ComposerManager
{
    use Singleton;

    const INSTALLER_URL = 'https://getcomposer.org/composer.phar';
    const EXTRACTED_PHAR = 'extracted_phar';
    const COMPOSER_PHAR = 'composer.phar';

    protected $namespacePool = [];

    protected $psr4Pool = [];

    protected $classMapPool = [];

    protected $includeFilesPool = [];

    /**
     * @var Composer\Autoload\ClassLoader The primary composer instance.
     */
    protected $loader;

    public $vendorDir;
    public $checkPaths = ['vendor', 'vendor/codeigniter', 'vendor/illuminate', 'vendor/autoload.php'];

    public function initialize()
    {
        $this->loader = require BASEPATH.'/vendor/autoload.php';
        $this->preloadPools();
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
        $vendorPath = base_path() .'/vendor';

        if (file_exists($file = $vendorPath . '/composer/autoload_files.php')) {
            $includeFiles = require $file;
            foreach ($includeFiles as $includeFile) {
                $relativeFile = $this->stripVendorDir($includeFile, $vendorPath);
                $result[$relativeFile] = true;
            }
        }

        return $result;
    }

    /**
     * Similar function to including vendor/autoload.php.
     * @param string $vendorPath Absoulte path to the vendor directory.
     * @return void
     */
    public function autoload($vendorPath)
    {
        $dir = $vendorPath . '/composer';

        if (file_exists($file = $dir . '/autoload_namespaces.php')) {
            $map = require $file;
            foreach ($map as $namespace => $path) {
                if (isset($this->namespacePool[$namespace])) continue;
                $this->loader->set($namespace, $path);
                $this->namespacePool[$namespace] = true;
            }
        }

        if (file_exists($file = $dir . '/autoload_psr4.php')) {
            $map = require $file;
            foreach ($map as $namespace => $path) {
                if (isset($this->psr4Pool[$namespace])) continue;
                $this->loader->setPsr4($namespace, $path);
                $this->psr4Pool[$namespace] = true;
            }
        }

        if (file_exists($file = $dir . '/autoload_classmap.php')) {
            $classMap = require $file;
            if ($classMap) {
                $classMapDiff = array_diff_key($classMap, $this->classMapPool);
                $this->loader->addClassMap($classMapDiff);
                $this->classMapPool += array_fill_keys(array_keys($classMapDiff), true);
            }
        }

        if (file_exists($file = $dir . '/autoload_files.php')) {
            $includeFiles = require $file;
            foreach ($includeFiles as $includeFile) {
                $relativeFile = $this->stripVendorDir($includeFile, $vendorPath);
                if (isset($this->includeFilesPool[$relativeFile])) continue;
                require $includeFile;
                $this->includeFilesPool[$relativeFile] = true;
            }
        }
    }

    public function setPsr4($namespace, $path)
    {
        $this->loader->setPsr4($namespace, $path);
    }

    /**
     * Removes the vendor directory from a path.
     * @param string $path
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

    public function checkVendor()
    {
        $vendorDir = $this->getVendorRootDir();
        foreach ($this->checkPaths as $path) {
            if (!file_exists($vendorDir.DIRECTORY_SEPARATOR.$path))
                return FALSE;
        }

        return TRUE;
    }

    public function makeComposer()
    {
        if ($this->downloadComposer())
            $this->extractComposer();

        if (!$this->checkVendor())
            $this->command('install');

        $this->cleanUp();
    }

    public function command($command)
    {
        if (!$this->checkVendor()) {
            if (!file_exists($extractedPhar = $this->getExtractedPharPath()))
                throw new Exception("Extracted ".self::COMPOSER_PHAR." not found");

            putenv("COMPOSER_HOME={$extractedPhar}/bin/composer");
            require_once($extractedPhar.'/vendor/autoload.php');
        }

        set_time_limit(-1);
        ini_set('phar.readonly', '0');

        // Setup composer input and output formatter
        $stream = fopen('php://temp', 'w+');
        $output = new Symfony\Component\Console\Output\StreamOutput($stream);
        $input = new Symfony\Component\Console\Input\ArrayInput(['command' => $command]);

        // change out of the directory so that the vendors file is created correctly
        chdir($this->getVendorRootDir());

        // Programmatically run `composer command`
        $composerApp = new Composer\Console\Application();
        $composerApp->setAutoExit(FALSE);
        $composerApp->run($input, $output);

        rewind($stream);
        $response = trim(stream_get_contents($stream));
        log_message('debug', strip_tags($response));
    }

    public function downloadComposer()
    {
        if (is_dir($extractedPhar = $this->getExtractedPharPath()))
            return TRUE;

        if (file_exists($composerPhar = $this->getVendorRootDir(self::COMPOSER_PHAR)))
            return TRUE;

        if (!$this->checkVendor()) {
            if (!is_dir($temp_dir = ROOTPATH.'assets/downloads/temp')) {
                mkdir($temp_dir, 0777, TRUE);
            }

            $installerStream = fopen($composerPhar, 'w+');
            get_remote_data(self::INSTALLER_URL, ['FILE' => $installerStream]);

            if (!file_exists($composerPhar)) {
                $message = "Error downloading ".self::INSTALLER_URL;
                log_message('error', $message);
                throw new Exception($message);
            }

            return TRUE;
        }

        return FALSE;
    }

    public function extractComposer()
    {
        if (is_dir($extractedPhar = $this->getExtractedPharPath()))
            return TRUE;

        $composerPhar = $this->getVendorRootDir(self::COMPOSER_PHAR);
        if (file_exists($composerPhar) AND !is_dir($extractedPhar)) {
            mkdir($extractedPhar, 0777, TRUE);

            $composer = new Phar($composerPhar);
            //php.ini setting phar.readonly must be set to 0
            //ini_set('phar.readonly', '0');
            $composer->extractTo($extractedPhar);
            @unlink($composerPhar);

            return TRUE;
        }

        log_message('error', $composerPhar.' does not exist');

        return FALSE;
    }

    public function getVendorRootDir($directory = null)
    {
        $vendorDir = rtrim($this->vendorDir ? $this->vendorDir : ROOTPATH, '/');

        return $directory ? $vendorDir.DIRECTORY_SEPARATOR.$directory : $vendorDir;
    }

    public function setVendorRootDir($vendorDir)
    {
        $this->vendorDir = $vendorDir;
    }

    public function getExtractedPharPath()
    {
        return $this->getVendorRootDir(self::EXTRACTED_PHAR);
    }

    public function cleanUp()
    {
        if (!function_exists('delete_files'))
            get_instance()->load->helper('file_helper');

        delete_files($this->getExtractedPharPath(), TRUE);
        @rmdir($this->getExtractedPharPath());
        @unlink($this->getVendorRootDir(self::COMPOSER_PHAR));
    }
}