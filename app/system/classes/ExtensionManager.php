<?php namespace System\Classes;

use File;
use Igniter\Flame\Traits\Singleton;
use Lang;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SystemException;
use View;
use ZipArchive;

/**
 * Modules class for TastyIgniter.
 * Provides utility functions for working with modules.
 */
class ExtensionManager
{
    use Singleton;

    /**
     * @var \Igniter\Flame\Foundation\Application
     */
    public $app;

    /**
     * @var
     */
    public $routes;

    /**
     * @var
     */
    public $registry;

    /**
     * @var array used for storing extension information objects.
     */
    protected $extensions = [];

    /**
     * @var array of disabled extensions.
     */
    protected $installedExtensions = [];

    /**
     * @var array of extensions and their directory paths.
     */
    protected $paths = [];

    /**
     * @var array used Set whether extensions have been initialized.
     */
    protected $initialized = FALSE;

    /**
     * @var array used Set whether extensions have been registered.
     */
    protected $registered = FALSE;

    public function initialize()
    {
        $this->app = app();

        // This prevents reading settings from the database before its been created
        if ($this->app->hasDatabase())
            $this->loadInstalled();

        $this->loadExtensions();
    }

    /**
     * Return the path to the extension and its specified folder.
     *
     * @param $extension string The name of the extension (must match the folder name).
     * @param $folder string The folder name to search for (Optional).
     *
     * @return string The path, relative to the front controller.
     */
    public function path($extension = null, $folder = null)
    {
        foreach ($this->folders() as $extensionFolder) {

            $extension = $this->checkName($extension);

            // Check each folder for the extension's folder.
            if (File::isDirectory("{$extensionFolder}/{$extension}")) {
                // If $folder was specified and exists, return it.
                if (!is_null($folder)
                    AND File::isDirectory("{$extensionFolder}/{$extension}/{$folder}")
                ) {
                    return "{$extensionFolder}/{$extension}/{$folder}";
                }

                // Return the extension's folder.
                return "{$extensionFolder}/{$extension}/";
            }
        }

        return null;
    }

    /**
     * Return an associative array of files within one or more extensions.
     *
     * @param string $extensionName
     * @param string $subFolder
     *
     * @return bool|array An associative array, like:
     * <code>
     * array(
     *     'extension_name' => array(
     *         'folder' => array('file1', 'file2')
     *     )
     * )
     */
    public function files($extensionName = null, $subFolder = null)
    {
        $files = [];
        $extensionPath = $this->path($this->getNamePath($extensionName));
        $extensionPath = rtrim($extensionPath.$subFolder, '/');
        foreach (File::allFiles($extensionPath) as $path) {
            // Add just the specified folder for this extension.
            $files[] = $path->getRelativePathname();
        }

        return $files;
    }

    /**
     * Search a extension folder for files.
     *
     * @param $extensionName   string  If not null, will return only files from that extension.
     * @param $path string  If not null, will return only files within
     * that sub-folder of each extension (ie 'views').
     *
     * @return array
     */
    public function filesPath($extensionName, $path = null)
    {
        $extensionPath = $path ? $path : $this->path($extensionName);
        $extensionPath = rtrim($extensionPath, '/').'/';

        if ($extensionPath == '/')
            return null;

        $files = [];
        foreach (glob($extensionPath.'*') as $filepath) {
            $filename = ltrim(substr($filepath, strlen(base_path())), '/');

            if (File::isDirectory($filepath)) {
                $files[] = $this->filesPath($extensionName, $filepath);
            }
            else {
                $files[] = $filename;
            }
        }

        return array_flatten($files);
    }

    /**
     * Returns an array of the folders in which extensions may be stored.
     * @return array The folders in which extensions may be stored.
     */
    public function folders()
    {
        return [$this->app->extensionsPath()];
    }

    /**
     * Returns a list of all extensions in the system.
     * @return array A list of all extensions in the system.
     */
    public function listExtensions()
    {
        $map = [];
        foreach ($this->paths() as $dir => $path) {
            $map[] = $dir;
        }

        $count = count($map);
        if (!$count) {
            return $map;
        }

        // Clean out any html or php files.
        for ($i = 0; $i < $count; $i++) {
            if (stripos($map[$i], '.html') !== FALSE
                || stripos($map[$i], '.php') !== FALSE
            ) {
                unset($map[$i]);
            }
        }

        return $map;
    }

    /**
     * Scans extensions to locate any dependencies that are not currently
     * installed. Returns an array of extension codes that are needed.
     * @return array
     */
    public function findMissingDependencies()
    {
        $missing = [];
        foreach ($this->extensions as $code => $extension) {
            if (!$required = $this->getDependencies($extension))
                continue;

            foreach ($required as $require) {
                if ($this->hasExtension($require))
                    continue;

                $missing[] = $require;
            }
        }

        return $missing;
    }

    /**
     * Checks all extensions and their dependencies, if not met extensions
     * are disabled and vice versa.
     * @return void
     */
    protected function loadDependencies()
    {
        foreach ($this->extensions as $code => $extension) {
            if (!$required = $this->getDependencies($extension))
                continue;

            $disable = FALSE;
            foreach ($required as $require) {
                $extensionObj = $this->findExtension($require);
                $disable = !$extensionObj OR $extensionObj->disabled;
            }

            $this->updateExtension($code, $disable);
        }
    }

    /**
     * Returns the extension codes that are required by the supplied extension.
     *
     * @param  string $extension
     *
     * @return bool|array
     */
    public function getDependencies($extension)
    {
        if (is_string($extension) AND (!$extension = $this->findExtension($extension)))
            return FALSE;

        if (!isset($extension->require) OR !$extension->require)
            return null;

        return is_array($extension->require) ? $extension->require : [$extension->require];
    }

    /**
     * Sorts extensions, in the order that they should be actioned,
     * according to their given dependencies. Least required come first.
     *
     * @param  array $extensions Array to sort, or null to sort all.
     *
     * @return array Collection of sorted extension identifiers
     */
    public function listByDependencies($extensions = null)
    {
        if (!is_array($extensions))
            $extensions = $this->getExtensions();

        $result = [];
        foreach ($extensions as $code => $extension) {
            $depends = $this->getDependencies($extension) ?: [];
            $depends = array_filter($depends, function ($dependCode) use ($extensions) {
                return isset($plugins[$dependCode]);
            });

            if (count($depends) > 0)
                array_push($result, $code);

            $result[] = $code;
        }

        return $result;
    }

    /**
     * Create a Directory Map of all extensions
     * @return array A list of all extensions in the system.
     */
    public function paths()
    {
        $data = [];
        $dirPath = extension_path();
        if (!File::isDirectory($dirPath)) {
            return $data;
        }

        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(
            $dirPath, RecursiveDirectoryIterator::FOLLOW_SYMLINKS
        ));

        $it->setMaxDepth(2);
        $it->rewind();

        while ($it->valid()) {
            if (($it->getDepth() > 1) AND $it->isFile() AND (strtolower($it->getFilename()) == "extension.php")) {
                $filePath = dirname($it->getPathname());
                $extensionName = basename($filePath);
                $extensionVendor = basename(dirname($filePath));
                $data[$extensionVendor][$extensionName] = $filePath;
            }

            $it->next();
        }

        return $data;
    }

    /**
     * Finds all available extensions and loads them in to the $extensions array.
     * @return array
     */
    public function loadExtensions()
    {
        $this->extensions = [];

        foreach ($this->namespaces() as $name => $path) {
            $this->loadExtension($name, $path);
        }

        return $this->extensions;
    }

    /**
     * Loads a single extension in to the manager.
     *
     * @param string $name Eg: directory_name
     * @param string $path Eg: base_path().'/extensions/directory_name';
     *
     * @return object|bool
     * @throws \SystemException
     */
    public function loadExtension($name, $path)
    {
        if (!$this->checkName($name)) return FALSE;

        $identifier = $this->getIdentifier($name);

        if (isset($this->extensions[$identifier])) {
            return $this->extensions[$identifier];
        }

        $classPath = $path.'/Extension.php';
        if (!file_exists($classPath))
            return FALSE;

        $namespace = ucfirst($name).'\\';
        $class = $namespace.'Extension';

        if (!class_exists($class)) {
            throw new SystemException("Missing Extension class '{$class}' in '{$identifier}', create the Extension class to override extensionMeta() method.");
        }

        $classObj = new $class($this->app);

        // Check for disabled extensions
        if ($this->isDisabled($identifier)) {
            $classObj->disabled = TRUE;
        }

        $this->extensions[$identifier] = $classObj;
        $this->paths[$identifier] = $path;

        return $classObj;
    }

    /**
     * Runs the initialize() method on all extensions. Can only be called once.
     * @return void
     */
    public function initializeExtensions()
    {
        if ($this->initialized) {
            return;
        }

        foreach ($this->extensions as $name => $extension) {
            $this->initializeExtension($extension);
        }

        $this->initialized = TRUE;
    }

    /**
     * Initialize a single extension.
     *
     * @param \System\Classes\BaseExtension $extension
     *
     * @return void
     */
    public function initializeExtension($extension = null)
    {
        if (!$extension) {
            return;
        }

        if ($extension->disabled) {
            return;
        }

        $extension->initialize();
    }

    /**
     * Runs the register() method on all extensions. Can only be called once.
     * @return void
     */
    public function registerExtensions()
    {
        if ($this->registered) {
            return;
        }

        foreach ($this->extensions as $name => $extension) {
            $this->registerExtension($name, $extension);
        }

        $this->registered = TRUE;
    }

    /**
     * Register a single extension.
     *
     * @param \System\Classes\BaseExtension $extension
     *
     * @return void
     */
    public function registerExtension($name, $extension = null)
    {
        if (!$extension) {
            return;
        }

        $path = $this->getNamePath($name);
        $extensionPath = extension_path($path);

        $langPath = $extensionPath.'/language';
        if (File::isDirectory($langPath)) {
            Lang::addNamespace($name, $langPath);
        }

        if ($extension->disabled) {
            return;
        }

        // Register extension class autoloader
        $autoloadPath = $extensionPath.'vendor/autoload.php';
        if (file_exists($autoloadPath)) {
            ComposerManager::instance()->autoload($extensionPath.'/vendor');
        }

        $extension->register();

//        get_instance()->load->add_package_path($extensionPath);

        // Register views path
        $viewsPath = $extensionPath.'views';
        if (File::isDirectory($viewsPath)) {
            View::addNamespace($name, $viewsPath);
        }

        // Add routes, if available
        $routesFile = $extensionPath.'routes.php';
        if (file_exists($routesFile)) {
            require $routesFile;
        }
    }

    /**
     * Returns an array with all registered extensions
     * The index is the extension name, the value is the extension object.
     *
     * @return BaseExtension[]
     */
    public function getExtensions()
    {
        $extensions = [];
        foreach ($this->extensions as $name => $extension) {
            if (!$extension->disabled)
                $extensions[$name] = $extension;
        }

        return $extensions;
    }

    /**
     * Returns a extension registration class based on its name.
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function findExtension($name)
    {
        if (!$this->hasExtension($name)) {
            return null;
        }

        return $this->extensions[$name];
    }

    /**
     * Returns a extension registration class based on its name.
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function findRequiredExtensions($name)
    {
        if (!$extension = $this->findExtension($name)) {
            return null;
        }

        $meta = $extension->extensionMeta();

        return isset($meta['required']) ? $meta['required'] : null;
    }

    /**
     * Checks to see if an extension name is well formed.
     *
     * @param $name
     *
     * @return bool
     */
    public function checkName($name)
    {
        return (strpos($name, '_') === 0 OR preg_match('/\s/', $name)) ? null : $name;
    }

    public function getIdentifier($name)
    {
        $name = trim($name, '\\');

        return str_replace('\\', '.', $name);
    }

    public function getNamePath($name)
    {
        return str_replace('.', '/', $name);
    }

    /**
     * Checks to see if an extension has been registered.
     *
     * @param $name
     *
     * @return bool
     */
    public function hasExtension($name)
    {
        return isset($this->extensions[$name]);
    }

    public function hasVendor($path)
    {
        return array_key_exists($path, $this->paths());
    }

    /**
     * Returns a flat array of extensions namespaces and their paths
     */
    public function namespaces()
    {
        $classNames = [];

        foreach ($this->paths() as $vendor => $extensions) {
            foreach ($extensions as $name => $path) {
                $namespace = '\\'.$vendor.'\\'.$name;
                $namespace = normalize_class_name($namespace);
                $classNames[$namespace] = $path;
            }
        }

        return $classNames;
    }

    /**
     * Determines if an extension is disabled by looking at the installed extensions config.
     *
     * @param $name
     *
     * @return bool
     */
    public function isDisabled($name)
    {
        if (!$this->checkName($name) OR !array_get($this->installedExtensions, $name, FALSE)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Loads all installed extension from application config.
     */
    public function loadInstalled()
    {
        if (($installedExtensions = setting('installed_extensions')) AND is_array($installedExtensions)) {
            $this->installedExtensions = setting('installed_extensions');
        }
    }

    /**
     * Extract uploaded extension zip folder
     *
     * @param $zipPath
     * @param array $extCode extension code
     *
     * @return array
     */
    public function extractExtension($zipPath, $extCode = null)
    {
        if (!File::exists($zipPath) OR !class_exists('ZipArchive', FALSE))
            return [FALSE, FALSE];

        $zip = new ZipArchive;
        if ($zip->open($zipPath) !== TRUE)
            throw new SystemException('Failed to open zip file');

        $extensionDir = $zip->getNameIndex(0);

        if (
            $zip->locateName($extensionDir.'Extension.php') === FALSE
            AND $zip->locateName($extensionDir.'extension.json') === FALSE
        )
            throw new SystemException('Missing extension registration class file');

        if (!$this->checkName($extensionDir))
            throw new SystemException(lang('system::extensions.error_upload_name'));

        $zip->extractTo($extractTo = temp_path());
        $zip->close();

        $extractedPath = $extractTo.'/'.$extensionDir;
        $manifestFile = $extractedPath.'extension.json';
        $config = json_decode(File::get($manifestFile));
        $extensionPath = extension_path($this->getNamePath($config->code));

        File::moveDirectory($extractedPath, $extensionPath, TRUE);

        return [$config, $extensionPath];
    }

    /**
     * Delete extension the filesystem
     *
     * @param array $extCode The extension to delete
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function removeExtension($extCode = null)
    {
        $extensionPath = extension_path($this->getNamePath($extCode));

        // Delete the specified extension folder.
        if (File::isDirectory($extensionPath))
            File::deleteDirectory($extensionPath);

        $vendorPath = dirname($extensionPath);

        // Delete the specified extension vendor folder if it has no extension.
        if (File::isDirectory($vendorPath) AND
            !count(File::directories($vendorPath))
        )
            File::deleteDirectory($vendorPath);

        return TRUE;
    }

    /**
     * Migrate to the latest version or drop all migrations
     * for a given extension migration
     *
     * @param string $extension
     * @param bool $downgrade
     *
     * @return bool
     */
    public function updateExtension($extension, $downgrade = FALSE)
    {
//        dd($extension);
//        list($path) = $this->find('migration', $extension, 'config/');
//
//        if (!$path) {
//            return FALSE;
//        }
//
//        $migration = $this->load_file('migration', $path, 'config');
//
//        if (!isset($migration['migration_enabled'])) $migration['migration_enabled'] = TRUE;
//
//        $CI =& get_instance();
//        $CI->load->library('migration', $migration);
//
//        if ($downgrade === TRUE) {
//            return $CI->migration->version('0', $extension);
//        }
//        else {
//            return $CI->migration->current($extension);
//        }
    }
}
