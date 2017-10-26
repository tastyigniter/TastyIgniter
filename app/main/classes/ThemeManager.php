<?php namespace Main\Classes;

use App;
use Config;
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

    protected $filesToCopy;

    /**
     * @var array of themes and their directory paths.
     */
    protected $paths = [];

    protected $config;

    protected $loadedConfig;

    protected $loadedCustomizerConfig;

    public function initialize()
    {
        $this->config = Config::get('theme', TRUE);
        $this->filesToCopy = ['theme.json', 'theme_config.php', 'screenshot.png'];

        $this->app = app();

        // This prevents reading settings from the database before its been created
        if ($this->app->hasDatabase()) {
            $this->loadInstalled();
            $this->loadThemes();
        }
    }

    //--------------------------------------------------------------------------
    // Theme TemplateLoader Methods
    //--------------------------------------------------------------------------

    /**
     * Returns a list of all modules in the system.
     *
     * @param $theme
     *
     * @return array A list of all modules in the system.
     */
    public function themeMeta($theme)
    {
        return isset($this->themes[$theme]->config) ? $this->themes[$theme]->config : [];
    }

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
        $installedThemes = setting('installed_themes');
//        if (is_null($installedThemes)) {
//            $this->createThemeModel()->updateInstalledThemes();
//        }

        if ($installedThemes AND is_array($installedThemes)) {
            $this->installedThemes = setting('installed_themes');
        }
    }

    /**
     * Finds all available themes and loads them in to the $themes array.
     * @return array
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
     */
    public function loadTheme($themeCode, $path)
    {
        if (!$this->checkName($themeCode)) return FALSE;

        if (isset($this->themes[$themeCode])) {
            return $this->themes[$themeCode];
        }

        $themeObject = new Theme($themeCode, $path);

        $themeObject->setUpAs($this->getMetaFromFile($themeCode));

        $themeConfigPath = $themeObject->getPath().'/theme_config.php';
        if (File::exists($themeConfigPath))
            $themeObject->setCustomizers(File::getRequire($themeConfigPath));

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
        $user = new $class();

        return $user;
    }

    //--------------------------------------------------------------------------
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
        $theme = setting('default_themes.main', config('system.defaultTheme'));
        if (is_string($theme))
            $theme = trim($theme, '/');

        return $theme;
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
        $file = (pathinfo($filename, PATHINFO_EXTENSION)) ? $filename : $filename.'.php';

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
     * Returns an array of the folders in which themes/views files may be stored.
     * @return array.
     */
    public function folders()
    {
        return [
            'admin' => 'app/admin/views',
            'main'  => App::themesPath(),
        ];
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

        $themeCode = rtrim($themeCode, '/').'/';

        return $themeCode == $this->getActiveThemeCode();
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
        $themePath = $this->findPath($themeCode);
        $files = File::allFiles($themePath);

        return ($subFolder) ? array_get($files, $subFolder, FALSE) : $files;
    }

    /**
     * Search a theme folder for files.
     *
     * @param string $themeCode The theme to search
     * @param string $subFolder If not null, will return only files within sub-folder (ie 'partials').
     *
     * @return array $theme_files
     */
//    public function findFilesPath($themeCode, $subFolder = null)
//    {
//
//        $themePath = $this->findPath($themeCode);
//        $files = $this->findFiles($themeCode, $subFolder);
//        $subFolder = !is_null($subFolder) ? $subFolder.'/' : null;
//
//        $_files = [];
//        foreach ($files as $key => $file) {
//            if (is_string($key)) {
//                $_files[] = $this->findFilesPath($themeCode, $key);
//            }
//            else {
//                $_files[] = $themePath.'/'.$subFolder.$file;
//            }
//        }
//
//        return array_flatten($_files);
//    }

    //--------------------------------------------------------------------------
    // Theme Helper Methods
    //--------------------------------------------------------------------------

    public function findPartialAreas($themeCode)
    {
        $config = $this->getConfigFromFile($themeCode);

        if (!isset($config['partial_area']) OR !is_array($config['partial_area']))
            return null;

        return $config['partial_area'];
    }

    public function getCustomizerFields($themeCode)
    {
        $config = $this->getConfigFromFile($themeCode);

        if (!isset($config['customize']) OR !is_array($config['customize']))
            return null;

        return $config['customize'];
    }

    /**
     * Build the theme files tree.
     *
     * @param array $files
     * @param string $url
     * @param string $currentFile
     *
     * @return string $themeTree
     */
    public function buildFilesTree($files, $url, $currentFile = null)
    {
        ksort($files);
        $currentPaths = (!is_null($currentFile)) ? explode('/', $currentFile) : [];

        $html = '<nav class="nav">';
        $html .= $this->_buildFilesTree($files, $url, $currentPaths);
        $html .= '</nav>';

        return $html;
    }

    /**
     * Load a single theme generic file into an array.
     *
     * @param string $filename The name of the file to locate. The file will be
     *                          found by looking in the all themes folders.
     * @param string $themeCode The theme to check.
     *
     * @return bool|array The $theme_file array from the file or false if not found. Returns
     * null if $filename is empty.
     */
    public function readFile($filename, $themeCode)
    {
        $file = [];
        $themePath = $this->findPath($themeCode);
        $filePath = $themePath.'/'.ltrim($filename, '/');
        $fileExt = strtolower(substr(strrchr($filename, '.'), 1));

        if (in_array($fileExt, $this->config['allowed_image_ext'])) {
            $file['type'] = 'img';
            $file['content'] = root_url(File::localToPublic($filePath));
        }
        else if (in_array($fileExt, $this->config['allowed_file_ext'])) {
            $file['type'] = 'file';
            $file['content'] = htmlspecialchars(file_get_contents($filePath));
        }
        else {
            return null;
        }

        $file = array_merge($file, [
            'name'        => $filename,
            'ext'         => $fileExt,
            'path'        => $filePath,
            'is_writable' => File::isWritable($filePath),
        ]);

        return $file;
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

        if (!file_exists($filePath = base_path($path.'/'.$filename))) {
            return FALSE;
        }

        $fileExt = strtolower(substr(strrchr($filePath, '.'), 1));
        if (!in_array($fileExt, $this->config['allowed_file_ext']) OR !File::isWritable($filePath)) {
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
        foreach ($this->filesToCopy as $file) {
            $path = $this->findFile($file, $themeCode);
            $files[] = $path;
        }

        return $files;
    }

    /**
     * Create child theme.
     *
     * @param string $themeCode The name of the theme to create child from.
     * @param array $childData The child theme DB data, the child theme data
     *                          should be inserted in DB before creating files.
     *
     * @return bool Returns false if child them could not be created
     * or $child_theme already exist.
     */
    public function createChild($themeCode, $childData = [])
    {
        if (empty($childData) OR !isset($childData['name']))
            return FALSE;

        // preparing the paths
        $parentPath = $this->findPath($themeCode);
        $childPath = dirname($parentPath).'/'.$childData['name'];

        // creating the destination directory
        if (!is_dir($childPath)) {
            mkdir($childPath, config('system.folderPermissions'), TRUE);
        }

        $failed = FALSE;
        $themeMeta = $this->themeMeta($themeCode);
        $files = $this->getFilesToCopy($themeCode);

        foreach ($files as $filePath) {
            $filename = basename($filePath);

            if (file_exists("{$childPath}/{$filename}") OR !file_exists($filePath))
                continue;

            if ($filename == 'theme.json') {
                $content = array_merge($themeMeta, [
                    'parent' => $themeMeta['code'],
                    'code'   => $childData['name'],
                    'name'   => $childData['title'],
                ]);

                $content = stripslashes(json_encode($content, JSON_PRETTY_PRINT));
                if (!File::put("{$childPath}/{$filename}", $content)) {
                    return FALSE;
                }
            }
            else {
                File::copy($filePath, "{$childPath}/{$filename}");
            }
        }

        return $failed === TRUE ? FALSE : TRUE;
    }

    /**
     * Extract uploaded/downloaded theme zip folder
     *
     * @param string $zipPath The path to the zip folder
     * @param string $domain The domain in which to extract the theme to
     *
     * @return bool
     * @throws \SystemException
     */
    public function extractTheme($zipPath, $domain = null)
    {
        if (file_exists($zipPath) AND class_exists('ZipArchive', FALSE)) {

            $domain = $domain ?: config('system.mainUri');

            $zip = new ZipArchive;

            chmod($zipPath, config('system.filePermission'));

            $themesFolder = $this->folders()['main'];

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
     */
    public function getMetaFromFile($themeCode)
    {
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

    /**
     * Internal method to build the theme files tree.
     *
     * @param array $files
     * @param string $url
     * @param array $currentPaths
     * @param string $parentDir
     *
     * @return string $themeTree
     */
    protected function _buildFilesTree($files, $url, $currentPaths = [], $parentDir = null)
    {
        $html = is_null($parentDir) ? '<ul class="metisFolder">' : '<ul>';

        foreach ($files as $dir => $file) {
            if (is_string($dir)) {
                $active = (in_array($dir, $currentPaths)) ? ' active' : '';
                $html .= '<li class="directory'.$active.'"><a><i class="fa fa-folder-open"></i>&nbsp;&nbsp;'.htmlspecialchars($dir).'</a>';
                $html .= $this->_buildFilesTree($file, $url, $currentPaths, $dir);
                $html .= '</li>';
            }
            else {
                $active = (in_array($file, $currentPaths)) ? ' active' : '';
                $fileExt = strtolower(substr(strrchr($file, '.'), 1));
                $fileName = htmlspecialchars($file);

                if (in_array($fileExt, $this->config['allowed_image_ext'])) {
                    $link = str_replace('{link}', $parentDir.'/'.urlencode($file), $url);
                    $html .= '<li class="img'.$active.'"><a href="'.$link.'"><i class="fa fa-file-image-o"></i>&nbsp;&nbsp;'.$fileName.'</a></li>';
                }
                else if (in_array($fileExt, $this->config['allowed_file_ext'])) {
                    $link = str_replace('{link}', $parentDir.'/'.urlencode($file), $url);
                    $html .= '<li class="file'.$active.'"><a href="'.$link.'"><i class="fa fa-file-code-o"></i>&nbsp;&nbsp;'.$fileName.'</a></li>';
                }
            }
        }

        $html .= '</ul>';

        return $html;
    }
}