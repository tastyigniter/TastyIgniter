<?php namespace Main\Classes;

use App;
use File;
use Igniter\Flame\Traits\Singleton;
use Lang;
use SystemException;
use ZipArchive;

/**
 * Theme Manager Class
 * @package Main
 */
class ThemeManager
{
    use Singleton;

    protected $themeModel = 'System\Models\Themes_model';

    /**
     * @var array of disabled themes.
     */
    public $installedThemes = [];

    /**
     * @var array used for storing theme information objects.
     */
    public $themes = [];

    public $activeTheme;

    /**
     * @var array of themes and their directory paths.
     */
    protected $paths = [];

    protected $config = [
        'filesToCopy'     => ['theme.json', 'theme.php', 'screenshot.png'],
        'allowedImageExt' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff'],
        'allowedFileExt'  => ['html', 'txt', 'xml', 'js', 'css', 'php', 'json'],
    ];

    protected $loadedConfig;

    protected $loadedCustomizerConfig;

    public function initialize()
    {
        // This prevents reading settings from the database before its been created
        if (App::hasDatabase()) {
            $this->loadInstalled();
            $this->loadThemes();
        }
    }

    //--------------------------------------------------------------------------
    // Theme TemplateLoader Methods
    //--------------------------------------------------------------------------

    /**
     * Returns a list of all themes in the system.
     * @return array A list of all themes in the system.
     */
    public function listThemes()
    {
        $themes = [];
        foreach ($this->paths() as $theme => $path) {
            $themes[] = $theme;
        }

        return $themes;
    }

    /**
     * Loads all installed theme from application config.
     */
    public function loadInstalled()
    {
        if (($installedThemes = setting('installed_themes')) AND is_array($installedThemes)) {
            $this->installedThemes = $installedThemes;
        }
    }

    /**
     * Finds all available themes and loads them in to the $themes array.
     * @return array
     * @throws \SystemException
     */
    public function loadThemes()
    {
        foreach ($this->paths() as $theme => $path) {
            $this->loadTheme($theme, $path);
        }

        return $this->themes;
    }

    /**
     * Loads a single theme in to the manager.
     *
     * @param string $themeCode Eg: directory_name
     * @param string $path Ex: base_path().'directory_name';
     *
     * @return bool|object
     * @throws \SystemException
     */
    public function loadTheme($themeCode, $path)
    {
        if (!$this->checkName($themeCode)) return FALSE;

        if (isset($this->themes[$themeCode])) {
            return $this->themes[$themeCode];
        }

        $config = $this->getMetaFromFile($themeCode);
        $themeObject = Theme::load($path, $config);

        $themeObject->active = $this->isActive($themeCode);

        $this->themes[$themeCode] = $themeObject;
        $this->paths[$themeCode] = $path;

        return $themeObject;
    }

    /**
     * Creates a new instance of the theme model
     */
    public function createThemeModel()
    {
        $class = '\\'.ltrim($this->themeModel, '\\');

        return new $class();
    }

    //
    // Theme Management Methods
    //--------------------------------------------------------------------------

    public function getActiveTheme()
    {
        if (!$activeTheme = $this->findTheme($this->getActiveThemeCode()))
            return null;

        return $activeTheme;
    }

    public function getActiveThemeCode()
    {
        $code = params('default_themes.main', config('system.defaultTheme'));

        return trim($code, '/');
    }

    /**
     * Find a file.
     * Scans for files located within themes directories. Also scans each theme
     * directories for layouts, partials, and content. Generates fatal error if file
     * not found.
     *
     * @param string $filename The file.
     * @param string $theme The theme.
     * @param string $base The folder within the theme eg. layouts, partials, content
     *
     * @return string|bool
     */
    public function findFile($filename, $theme, $base = null)
    {
        $path = $this->findPath($theme);

        $themePath = rtrim($path, '/');
        $file = pathinfo($filename, PATHINFO_EXTENSION) ? $filename : $filename.'.php';

        if (is_null($base)) {
            $base = ['/'];
        }
        else if (!is_array($base)) {
            $base = [$base];
        }

        foreach ($base as $folder) {
            if (File::isFile($path = $themePath.$folder.$file)) {
                return $path;
            }
        }

        return FALSE;
    }

    /**
     * Returns a theme object based on its name.
     *
     * @param $themeCode
     *
     * @return \Main\Classes\Theme
     */
    public function findTheme($themeCode)
    {
        if (!$this->hasTheme($themeCode)) {
            return null;
        }

        return $this->themes[$themeCode];
    }

    /**
     * Checks to see if an extension has been registered.
     *
     * @param $themeCode
     *
     * @return bool
     */
    public function hasTheme($themeCode)
    {
        return isset($this->themes[$themeCode]);
    }

    /**
     * Returns a theme path based on its name.
     *
     * @param $themeCode
     *
     * @return string|null
     */
    public function findPath($themeCode)
    {
        $themesPath = $this->paths();

        return isset($themesPath[$themeCode]) ? $themesPath[$themeCode] : null;
    }

    /**
     * Returns the theme domain by looking in its path.
     *
     * @param $themeCode
     *
     * @return string
     */
    public function findDomain($themeCode)
    {
        $theme = $this->findTheme($themeCode);

        return $theme ? $theme->getDomain() : null;
    }

    /**
     * Returns the theme domain by looking in its path.
     *
     * @param $themeCode
     *
     * @return string
     */
    public function findParent($themeCode)
    {
        $theme = $this->findTheme($themeCode);

        return $theme ? $theme->parent : null;
    }

    /**
     * Create a Directory Map of all themes
     * @return array A list of all themes in the system.
     */
    public function paths()
    {
        $themes = [];
        foreach (File::directories(App::themesPath()) as $path) {
            $themeDir = basename($path);
            $themes[$themeDir] = $path;
        }

        return $themes;
    }

    /**
     * Determines if a theme is activated by looking at the default themes config.
     *
     * @param $themeCode
     *
     * @return bool
     */
    public function isActive($themeCode)
    {
        if (!$this->checkName($themeCode)) {
            return FALSE;
        }

        return (rtrim($themeCode, '/') == $this->getActiveThemeCode());
    }

    /**
     * Determines if a theme is disabled by looking at the installed themes config.
     *
     * @param $name
     *
     * @return bool
     */
    public function isDisabled($name)
    {
        return !$this->checkName($name) OR !array_get($this->installedThemes, $name, FALSE);
    }

    /**
     * Checks to see if a theme has been registered.
     *
     * @param $themeCode
     *
     * @return bool
     */
    public function checkName($themeCode)
    {
        if ($themeCode == 'errors')
            return null;

        return (strpos($themeCode, '_') === 0 OR preg_match('/\s/', $themeCode)) ? null : $themeCode;
    }

    /**
     * Search a theme folder for files.
     *
     * @param string $themeCode The theme to search
     * @param string $subFolder If not null, will return only files within sub-folder (ie 'partials').
     *
     * @return array $theme_files
     */
    public function listFiles($themeCode, $subFolder = null)
    {
        $result = [];
        $themePath = $this->findPath($themeCode);
        $files = File::allFiles($themePath);
        foreach ($files as $file) {
            list($folder,) = explode('/', $file->getRelativePath());
            $path = $file->getRelativePathname();
            $result[$folder ?: '/'][] = $path;
        }

        if (is_string($subFolder))
            $subFolder = [$subFolder];

        return $subFolder ? array_only($result, $subFolder) : $result;
    }

    //--------------------------------------------------------------------------
    // Theme Helper Methods
    //--------------------------------------------------------------------------

    /**
     * Load a single theme generic file into an array.
     *
     * @param string $filename The name of the file to locate. The file will be
     *                          found by looking in the all themes folders.
     * @param string $themeCode The theme to check.
     *
     * @return bool|array The $theme_file array from the file or false if not found. Returns
     * null if $filename is empty.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function readFile($filename, $themeCode)
    {
        $themePath = $this->findPath($themeCode);
        $filePath = $themePath.'/'.$filename;

        if (!$filename OR !File::isFile($filePath))
            return FALSE;

        $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
        if (!in_array($fileExt, $this->config['allowedFileExt']))
            return FALSE;

        return File::get($filePath);
    }

    /**
     * Write a theme file.
     *
     * @param string $filename The name of the file to locate. The file will be
     *                               found by looking in the admin and main themes folders.
     * @param string $themeCode The theme to check.
     * @param string $content A string of the theme file content to write or replace.
     * @param boolean|string $return True to return the contents or false to return bool.
     *
     * @return bool|string False if there was a problem loading the file. Otherwise,
     * returns true when $return is false or a string containing the file's contents
     * when $return is true.
     */
    public function writeFile($filename, $themeCode, $content = null, $return = FALSE)
    {
        if (empty($filename) OR empty($themeCode)) {
            return FALSE;
        }

        $path = $this->findPath($themeCode);

        if (!File::exists($filePath = $path.'/'.$filename)) {
            return FALSE;
        }

        $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
        if (!in_array($fileExt, $this->config['allowedFileExt']) OR !File::isWritable($filePath)) {
            return FALSE;
        }

        if (!File::put($filePath, $content)) {
            return FALSE;
        }

        return ($return === TRUE) ? $content : TRUE;
    }

    public function getFilesToCopy($themeCode)
    {
        $files = [];
        foreach ($this->config['filesToCopy'] as $file) {
            $path = $this->findFile($file, $themeCode);
            $files[] = File::localToPublic($path);
        }

        return $files;
    }

    /**
     * Create child theme.
     *
     * @param string $themeCode The name of the theme to create child from.
     * @param $childThemeCode
     *
     * @return bool Returns false if child them could not be created
     * or $child_theme already exist.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function createChild($themeCode, $childThemeCode)
    {
        if (!strlen($childThemeCode) OR !strlen($themeCode))
            return FALSE;

        // preparing the paths
        $parentPath = $this->findPath($themeCode);
        $childPath = dirname($parentPath).'/'.$childThemeCode;

        // creating the destination directory
        if (!File::isDirectory($childPath))
            File::makeDirectory($childPath);

        foreach ($this->config['filesToCopy'] as $file) {
            if ($file == 'theme.json') {
                $themeMeta = json_decode(File::get("{$parentPath}/{$file}"), TRUE);
                $content = array_merge($themeMeta, [
                    'code'   => $childThemeCode,
                    'name'   => $themeMeta['name'].' Child',
                    'parent' => $themeCode,
                ]);

                $content = stripslashes(json_encode($content, JSON_PRETTY_PRINT));
                File::put("{$childPath}/{$file}", $content);
            }
            else {
                File::copy("{$parentPath}/{$file}", "{$childPath}/{$file}");
            }
        }

        return TRUE;
    }

    /**
     * Extract uploaded/downloaded theme zip folder
     *
     * @param string $zipPath The path to the zip folder
     *
     * @return bool
     * @throws \SystemException
     */
    public function extractTheme($zipPath)
    {
        if (file_exists($zipPath) AND class_exists('ZipArchive', FALSE)) {

            $zip = new ZipArchive;

            chmod($zipPath, config('system.filePermission'));

            $themesFolder = App::themesPath();

            if ($zip->open($zipPath) === TRUE) {
                $themeDir = $zip->getNameIndex(0);

                if ($zip->locateName($themeDir.'theme.json') === FALSE)
                    return FALSE;

                if (!$this->checkName($themeDir) OR file_exists($themesFolder.'/'.$themeDir)) {
                    throw new SystemException(lang('system::themes.error_theme_exists'));
                }

                $zip->extractTo($themesFolder);
                $zip->close();

                return $themesFolder.'/'.$themeDir;
            }
        }

        return FALSE;
    }

    /**
     * Delete existing theme folder from filesystem.
     *
     * @param null $themeCode The theme to delete
     *
     * @return bool
     */
    public function removeTheme($themeCode)
    {
        if (!is_dir($themePath = $this->findPath($themeCode)))
            return FALSE;

        // Delete the specified admin and main language folder.
        File::deleteDirectory($themePath);

        return TRUE;
    }

    /**
     * Read theme customizer configuration from the config file
     *
     * @param string $themeCode The theme to check.
     *
     * @return array|bool
     */
    public function getConfigFromFile($themeCode)
    {
        if (isset($this->loadedCustomizerConfig[$themeCode]))
            return $this->loadedCustomizerConfig[$themeCode];

        if (!$configPath = $this->findFile('theme_config.php', $themeCode))
            return null;

        include($configPath);

        if (empty($theme) OR !is_array($theme))
            return null;

        $this->loadedCustomizerConfig[$themeCode] = $theme;

        return $theme;
    }

    /**
     * Read configuration from Config/Meta file
     *
     * @param string $themeCode
     *
     * @return array|null
     * @throws \SystemException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getMetaFromFile($themeCode)
    {
        $config = [];
        if (isset($this->loadedConfig[$themeCode]))
            return $this->loadedConfig[$themeCode];

        if ($metaPath = $this->findFile('theme.json', $themeCode))
            $config = $this->validateMetaFile($metaPath, $themeCode);

        $this->loadedConfig[$themeCode] = $config;

        return $config;
    }

    /**
     * Check configuration in Config file
     *
     * @param string $path
     * @param $themeCode
     *
     * @return array|null
     * @throws \SystemException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function validateMetaFile($path, $themeCode)
    {
        if (!$config = json_decode(File::get($path), TRUE)) {
            throw new SystemException('Theme ['.$themeCode.'] does not have a registration file.');
        }

        foreach ([
                     'code',
                     'description',
                     'version',
                     'author',
                     'tags',
                 ] as $item) {

            if (!array_key_exists($item, $config)) {
                throw new SystemException(sprintf(
                    Lang::get('system::default.missing.config_key'),
                    $item, $path
                ));
            }
        }

        return $config;
    }
}