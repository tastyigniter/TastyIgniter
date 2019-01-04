<?php namespace Main\Classes;

use App;
use Exception;
use File;
use Igniter\Flame\Traits\Singleton;
use Lang;
use Main\Template\Content;
use Main\Template\Layout;
use Main\Template\Page;
use Main\Template\Partial;
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
        'allowedImageExt' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff'],
        'allowedFileExt' => ['html', 'txt', 'xml', 'js', 'css', 'php', 'json'],
    ];

    protected static $allowedSourceModels = [
        '_layouts' => Layout::class,
        '_pages' => Page::class,
        '_partials' => Partial::class,
        '_content' => Content::class,
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

    public static function applyAssetVariablesOnCombinerFilters(array $filters)
    {
        $theme = self::instance()->getActiveTheme();

        if (!$theme OR !$theme->hasCustomData())
            return;

        $assetVars = $theme->getAssetVariables();
        foreach ($filters as $filter) {
            if (method_exists($filter, 'setVariables')) {
                $filter->setVariables($assetVars);
            }
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
     * Load a single theme generic file into an array. The file will be
     * found by looking in the _layouts, _pages, _partials, _content, themes folders.
     *
     * @param string $filePath The name of the file to locate.
     * @param string $themeCode The theme to check.
     *
     * @return array|bool
     */
    public function readFile($filePath, $themeCode)
    {
        $theme = $this->findTheme($themeCode);

        list($dirName, $fileName) = $this->getFileNameParts($theme, $filePath);

        $source = $this->getSourceModel($dirName, $theme, $fileName);

        if (!$source)
            return FALSE;

        return [
            'fileName' => $source->getFileName(),
            'baseFileName' => $source->getBaseFileName(),
            'settings' => $source->settings,
            'markup' => $source->getMarkup(),
            'codeSection' => $source->getCode(),
            'fileSource' => $source,
        ];
    }

    /**
     * Write a theme layout, page, partial or content file.
     *
     * @param string $filePath The name of the file to locate.
     * @param string $themeCode The theme to check.
     * @param array $attributes
     *
     * @return bool
     */
    public function writeFile($filePath, $themeCode, array $attributes = [])
    {
        $theme = $this->findTheme($themeCode);

        list($dirName, $fileName) = $this->getFileNameParts($theme, $filePath);
        if (!$dirName OR !$fileName)
            return FALSE;

        if (!File::exists($fullFilePath = $theme->path.'/'.$dirName.'/'.$fileName)) {
            File::makeDirectory(File::dirname($fullFilePath), 0777, TRUE, TRUE);
            File::put($fullFilePath, "\n");
        }

        $source = $this->getSourceModel($dirName, $theme, $fileName);
        if (!$source)
            return FALSE;

        $source->update($attributes);

        return $source;
    }

    /**
     * Rename a theme layout, page, partial or content in the file system.
     *
     * @param string $filePath The name of the file to locate.
     * @param string $themeCode The theme to check.
     * @param string $newFilePath
     *
     * @return bool
     */
    public function renameFile($filePath, $themeCode, $newFilePath)
    {
        $theme = $this->findTheme($themeCode);

        list($dirName, $fileName) = $this->getFileNameParts($theme, $filePath);
        list($newDirName, $newFileName) = $this->getFileNameParts($theme, $newFilePath);

        if ($dirName != $newDirName)
            return FALSE;

        $source = $this->getSourceModel($dirName, $theme, $fileName);
        if (!$source)
            return FALSE;

        $oldFilePath = $theme->path.'/'.$dirName.'/'.$fileName;
        $newFilePath = $theme->path.'/'.$newDirName.'/'.$newFileName;
        File::move($oldFilePath, $newFilePath);

        return $source;
    }

    /**
     * Delete a theme layout, page, partial or content from the file system.
     *
     * @param string $filePath The name of the file to locate.
     * @param string $themeCode The theme to check.
     *
     * @return bool
     */
    public function deleteFile($filePath, $themeCode)
    {
        $theme = $this->findTheme($themeCode);

        list($dirName, $fileName) = $this->getFileNameParts($theme, $filePath);

        $source = $this->getSourceModel($dirName, $theme, $fileName);
        if (!$source)
            return FALSE;

        $source->delete();

        return $source;
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
        $themeCode = null;
        $zip = new ZipArchive;

        $themesFolder = App::themesPath();

        if ($zip->open($zipPath) === TRUE) {
            $themeDir = $zip->getNameIndex(0);

            if ($zip->locateName($themeDir.'theme.json') === FALSE)
                return FALSE;

            if (file_exists($themesFolder.'/'.$themeDir)) {
                throw new SystemException(lang('system::lang.themes.error_theme_exists'));
            }

            $meta = @json_decode($zip->getFromName($themeDir.'theme.json'));
            if (!$meta OR !strlen($meta->code))
                throw new SystemException(lang('system::lang.themes.error_config_no_found'));

            $themeCode = $meta->code;
            if (!$this->checkName($themeDir) OR !$this->checkName($themeCode))
                throw new SystemException('Theme directory name can not have spaces.');

            $extractToPath = $themesFolder.'/'.$themeCode;
            $zip->extractTo($extractToPath);
            $zip->close();

            return $themeCode;
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

    public function getFileNameParts($theme, $fileName)
    {
        $parts = explode('/', $fileName);
        $dirName = $parts[0];
        $fileName = implode('/', array_splice($parts, 1));

        $fileNameParts = [];
        switch ($dirName) {
            case '_layouts':
                $fileNameParts = (new Layout)->getFileNameParts($fileName);
                break;
            case '_pages':
                $fileNameParts = (new Page)->getFileNameParts($fileName);
                break;
            case '_partials':
                $fileNameParts = (new Partial($theme))->getFileNameParts($fileName);
                break;
            case '_content':
                $fileNameParts = (new Content($theme))->getFileNameParts($fileName);
                break;
        }

        return [$dirName, implode('.', $fileNameParts)];
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
                     'name',
                     'description',
                     'version',
                     'author',
                 ] as $item) {

            if (!array_key_exists($item, $config)) {
                throw new SystemException(sprintf(
                    Lang::get('system::lang.missing.config_key'),
                    $item, $path
                ));
            }
        }

        return $config;
    }

    protected function getSourceModelClass($dirName)
    {
        if (!isset(self::$allowedSourceModels[$dirName]))
            throw new Exception(sprintf('Source Model not found for [%s] in %s.',
                $dirName, self::class
            ));

        return self::$allowedSourceModels[$dirName];
    }

    protected function getSourceModel($dirName, $theme, $fileName)
    {
        $modelClass = $this->getSourceModelClass($dirName);

        return $modelClass::load($theme, $fileName);
    }
}