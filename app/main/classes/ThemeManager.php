<?php

namespace Main\Classes;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Traits\Singleton;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use System\Classes\ComposerManager;
use System\Libraries\Assets;
use System\Models\Themes_model;
use ZipArchive;

/**
 * Theme Manager Class
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

    protected $loadedConfig;

    protected $loadedCustomizerConfig;

    protected $booted = false;

    protected static $directories = [];

    public function initialize()
    {
        // This prevents reading settings from the database before its been created
        if (App::hasDatabase()) {
            $this->loadInstalled();
            $this->loadThemes();
        }
    }

    public static function addDirectory($directory)
    {
        self::$directories[] = $directory;
    }

    public static function addAssetsFromActiveThemeManifest(Assets $manager)
    {
        $instance = self::instance();
        if (!$theme = $instance->getActiveTheme())
            return;

        if (File::exists($theme->path.'/_meta/assets.json')) {
            $manager->addFromManifest($theme->publicPath.'/_meta/assets.json');
        }
        elseif ($theme->hasParent()) {
            $parentTheme = $instance->findTheme($theme->getParentName());
            $manager->addFromManifest($parentTheme->publicPath.'/_meta/assets.json');
        }
    }

    public static function applyAssetVariablesOnCombinerFilters(array $filters, Theme $theme = null)
    {
        $theme = !is_null($theme) ? $theme : self::instance()->getActiveTheme();

        if (!$theme || !$theme->hasCustomData())
            return;

        $assetVars = $theme->getAssetVariables();
        foreach ($filters as $filter) {
            if (method_exists($filter, 'setVariables')) {
                $filter->setVariables($assetVars);
            }
        }
    }

    //
    // Registration Methods
    //

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
        if (($installedThemes = setting('installed_themes')) && is_array($installedThemes)) {
            $this->installedThemes = $installedThemes;
        }
    }

    /**
     * Finds all available themes and loads them in to the $themes array.
     * @return array
     * @throws \Igniter\Flame\Exception\SystemException
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
     * @throws \Igniter\Flame\Exception\SystemException
     */
    public function loadTheme($themeCode, $path)
    {
        if (!$this->checkName($themeCode)) return false;

        if (isset($this->themes[$themeCode])) {
            return $this->themes[$themeCode];
        }

        $config = $this->getMetaFromFile($themeCode);
        $themeObject = new Theme($path, $config);

        $themeObject->active = $this->isActive($themeCode);

        $this->themes[$themeCode] = $themeObject;

        return $themeObject;
    }

    public function bootThemes()
    {
        if ($this->booted)
            return;

        foreach ($this->themes as $theme) {
            $theme->boot();
        }

        $this->booted = true;
    }

    //
    // Management Methods
    //

    public function getActiveTheme()
    {
        return ($activeTheme = $this->findTheme($this->getActiveThemeCode()))
            ? $activeTheme : null;
    }

    public function getActiveThemeCode()
    {
        $activeTheme = trim(params('default_themes.main', config('system.defaultTheme')), '/');

        if (!is_null($apiResult = Event::fire('theme.getActiveTheme', [], true)))
            $activeTheme = $apiResult;

        return $activeTheme;
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
     * Returns the theme domain by looking in its path.
     *
     * @param $themeCode
     *
     * @return string
     */
    public function findParent($themeCode)
    {
        $theme = $this->findTheme($themeCode);

        return $theme ? $this->findTheme($theme->getParentName()) : null;
    }

    /**
     * Returns the parent theme code.
     *
     * @param $themeCode
     *
     * @return string
     */
    public function findParentCode($themeCode)
    {
        $theme = $this->findTheme($themeCode);

        return $theme ? $theme->getParentName() : null;
    }

    /**
     * Create a Directory Map of all themes
     * @return array A list of all themes in the system.
     */
    public function paths()
    {
        if ($this->paths)
            return $this->paths;

        $paths = [];

        $directories = array_merge([App::themesPath()], self::$directories);
        foreach ($directories as $directory) {
            foreach (File::directories($directory) as $path) {
                $themeDir = basename($path);
                $paths[$themeDir] = $path;
            }
        }

        return $this->paths = $paths;
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
            return false;
        }

        return rtrim($themeCode, '/') == $this->getActiveThemeCode();
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
        traceLog('Deprecated. Use $instance::isActive($themeCode) instead');

        return !$this->checkName($name) || !array_get($this->installedThemes, $name, false);
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

        return (strpos($themeCode, '_') === 0 || preg_match('/\s/', $themeCode)) ? null : $themeCode;
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
        traceLog('Deprecated. Use Template::listInTheme($theme) instead');
        $result = [];
        $themePath = $this->findPath($themeCode);
        $files = File::allFiles($themePath);
        foreach ($files as $file) {
            [$folder,] = explode('/', $file->getRelativePath());
            $path = $file->getRelativePathname();
            $result[$folder ?: '/'][] = $path;
        }

        if (is_string($subFolder))
            $subFolder = [$subFolder];

        return $subFolder ? array_only($result, $subFolder) : $result;
    }

    public function isLocked($themeCode)
    {
        return (bool)optional($this->findTheme($themeCode))->locked;
    }

    public function checkParent($themeCode)
    {
        foreach ($this->themes as $code => $theme) {
            if ($theme->hasParent() && $theme->getParentName() == $themeCode)
                return true;
        }

        return false;
    }

    public function isLockedPath($path)
    {
        if (starts_with($path, App::themesPath().'/'))
            $path = substr($path, strlen(App::themesPath().'/'));

        $themeCode = str_before($path, '/');

        return $this->isLocked($themeCode);
    }

    //
    // Theme Helper Methods
    //

    /**
     * Returns a theme path based on its name.
     *
     * @param $themeCode
     *
     * @return string|null
     */
    public function findPath($themeCode)
    {
        return $this->paths()[$themeCode] ?? null;
    }

    /**
     * Find a file.
     * Scans for files located within themes directories. Also scans each theme
     * directories for layouts, partials, and content. Generates fatal error if file
     * not found.
     *
     * @param string $filename The file.
     * @param string $themeCode The theme code.
     * @param string $base The folder within the theme eg. layouts, partials, content
     *
     * @return string|bool
     */
    public function findFile($filename, $themeCode, $base = null)
    {
        $path = $this->findPath($themeCode);

        $themePath = rtrim($path, '/');
        $file = pathinfo($filename, PATHINFO_EXTENSION) ? $filename : $filename.'.php';

        if (is_null($base)) {
            $base = ['/'];
        }
        elseif (!is_array($base)) {
            $base = [$base];
        }

        foreach ($base as $folder) {
            if (File::isFile($path = $themePath.$folder.$file)) {
                return $path;
            }
        }

        return false;
    }

    /**
     * Load a single theme generic file into an array. The file will be
     * found by looking in the _layouts, _pages, _partials, _content, themes folders.
     *
     * @param string $filePath The name of the file to locate.
     * @param string $themeCode The theme to check.
     *
     * @return \Igniter\Flame\Pagic\Contracts\TemplateSource
     */
    public function readFile($filePath, $themeCode)
    {
        $theme = $this->findTheme($themeCode);

        [$dirName, $fileName] = $this->getFileNameParts($filePath, $theme);

        if (!$template = $theme->onTemplate($dirName)->find($fileName))
            throw new ApplicationException("Theme template file not found: $filePath");

        return $template;
    }

    public function newFile($filePath, $themeCode)
    {
        $theme = $this->findTheme($themeCode);
        [$dirName, $fileName] = $this->getFileNameParts($filePath, $theme);
        $path = $theme->getPath().'/'.$dirName.'/'.$fileName;

        if (File::isFile($path))
            throw new ApplicationException("Theme template file already exists: $filePath");

        if (!File::exists($path))
            File::makeDirectory(File::dirname($path), 0777, true, true);

        File::put($path, "\n");
    }

    /**
     * Write an existing theme layout, page, partial or content file.
     *
     * @param string $filePath The name of the file to locate.
     * @param array $attributes
     * @param string $themeCode The theme to check.
     *
     * @return bool
     */
    public function writeFile($filePath, array $attributes, $themeCode)
    {
        $theme = $this->findTheme($themeCode);

        [$dirName, $fileName] = $this->getFileNameParts($filePath, $theme);

        if (!$template = $theme->onTemplate($dirName)->find($fileName))
            throw new ApplicationException("Theme template file not found: $filePath");

        return $template->update($attributes);
    }

    /**
     * Rename a theme layout, page, partial or content in the file system.
     *
     * @param string $filePath The name of the file to locate.
     * @param string $newFilePath
     * @param string $themeCode The theme to check.
     *
     * @return bool
     */
    public function renameFile($filePath, $newFilePath, $themeCode)
    {
        $theme = $this->findTheme($themeCode);

        [$dirName, $fileName] = $this->getFileNameParts($filePath, $theme);
        [$newDirName, $newFileName] = $this->getFileNameParts($newFilePath, $theme);

        if (!$template = $theme->onTemplate($dirName)->find($fileName))
            throw new ApplicationException("Theme template file not found: $filePath");

        if ($this->isLockedPath($template->getFilePath()))
            throw new ApplicationException(lang('system::lang.themes.alert_theme_path_locked'));

        $oldFilePath = $theme->path.'/'.$dirName.'/'.$fileName;
        $newFilePath = $theme->path.'/'.$newDirName.'/'.$newFileName;

        if ($oldFilePath == $newFilePath)
            throw new ApplicationException("Theme template file already exists: $filePath");

        return $template->update(['fileName' => $newFileName]);
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

        [$dirName, $fileName] = $this->getFileNameParts($filePath, $theme);

        if (!$template = $theme->onTemplate($dirName)->find($fileName))
            throw new ApplicationException("Theme template file not found: $filePath");

        if ($this->isLockedPath($template->getFilePath()))
            throw new ApplicationException(lang('system::lang.themes.alert_theme_path_locked'));

        return $template->delete();
    }

    /**
     * Extract uploaded/downloaded theme zip folder
     *
     * @param string $zipPath The path to the zip folder
     *
     * @return bool
     * @throws \Igniter\Flame\Exception\SystemException
     */
    public function extractTheme($zipPath)
    {
        $themeCode = null;
        $zip = new ZipArchive;

        $themesFolder = App::themesPath();

        if ($zip->open($zipPath) === true) {
            $themeDir = $zip->getNameIndex(0);

            if ($zip->locateName($themeDir.'theme.json') === false)
                return false;

            if (file_exists($themesFolder.'/'.$themeDir)) {
                throw new SystemException(lang('system::lang.themes.error_theme_exists'));
            }

            $meta = @json_decode($zip->getFromName($themeDir.'theme.json'));
            if (!$meta || !strlen($meta->code))
                throw new SystemException(lang('system::lang.themes.error_config_no_found'));

            $themeCode = $meta->code;
            if (!$this->checkName($themeDir) || !$this->checkName($themeCode))
                throw new SystemException('Theme directory name can not have spaces.');

            $extractToPath = $themesFolder.'/'.$themeCode;
            $zip->extractTo($extractToPath);
            $zip->close();

            return $themeCode;
        }

        return false;
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
            return false;

        // Delete the specified admin and main language folder.
        File::deleteDirectory($themePath);

        return true;
    }

    public function installTheme($code, $version = null)
    {
        $model = Themes_model::firstOrNew(['code' => $code]);

        if (!$themeObj = $this->findTheme($model->code))
            return false;

        $model->name = $themeObj->label ?? title_case($code);
        $model->code = $code;
        $model->version = $version ?? ComposerManager::instance()->getPackageVersion($code) ?? $model->version;
        $model->description = $themeObj->description ?? '';
        $model->save();

        return true;
    }

    /**
     * @param \System\Models\Themes_model $model
     * @return \System\Models\Themes_model
     * @throws \Igniter\Flame\Exception\ApplicationException
     */
    public function createChildTheme($model)
    {
        $parentTheme = $this->findTheme($model->code);
        if ($parentTheme->hasParent())
            throw new ApplicationException('Can not create a child theme from another child theme');

        $childThemeCode = Themes_model::generateUniqueCode($model->code);
        $childThemePath = dirname($parentTheme->getPath()).'/'.$childThemeCode;

        $themeConfig = [
            'code' => $childThemeCode,
            'name' => $parentTheme->label.' [child]',
            'description' => $parentTheme->description,
        ];

        $this->writeChildThemeMetaFile(
            $childThemePath, $parentTheme, $themeConfig
        );

        $themeConfig['data'] = $model->data ?? [];

        return Themes_model::create($themeConfig);
    }

    /**
     * Read configuration from Config/Meta file
     *
     * @param string $themeCode
     *
     * @return array|null
     * @throws \Igniter\Flame\Exception\SystemException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getMetaFromFile($themeCode)
    {
        if (isset($this->loadedConfig[$themeCode]))
            return $this->loadedConfig[$themeCode];

        if ($metaPath = $this->findFile('theme.json', $themeCode)) {
            $config = json_decode(File::get($metaPath), true);
        }
        elseif ($metaPath = $this->findFile('composer.json', $themeCode)) {
            $config = ComposerManager::instance()->getConfig(dirname($metaPath), 'theme');
        }
        else {
            throw new SystemException('Theme ['.$themeCode.'] does not have a registration file.');
        }

        $config = $this->validateMetaFile($config, $metaPath);

        $this->loadedConfig[$themeCode] = $config;

        return $config;
    }

    public function getFileNameParts($path, Theme $theme)
    {
        $parts = explode('/', $path);
        $dirName = $parts[0];
        $fileName = implode('/', array_splice($parts, 1));

        $fileNameParts = $theme->onTemplate($dirName)->getFileNameParts($fileName);

        return [$dirName, implode('.', $fileNameParts)];
    }

    /**
     * Check configuration in Config file
     *
     * @param string $path
     * @param $themeCode
     *
     * @return array|null
     * @throws \Igniter\Flame\Exception\SystemException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function validateMetaFile($config, $path)
    {
        foreach ([
            'code',
            'name',
            'description',
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

    protected function writeChildThemeMetaFile($path, $parentTheme, $themeConfig)
    {
        $config = array_merge($parentTheme->config, $themeConfig);
        $config['parent'] = $parentTheme->name;
        unset($config['locked'], $config['require']);

        if (File::isDirectory($path))
            throw new ApplicationException('Child theme path already exists.');

        File::makeDirectory($path, 0777, false, true);

        if (File::exists($parentTheme->path.'/theme.json')) {
            File::put($path.'/theme.json', json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        elseif (File::exists($metaPath = $parentTheme->path.'/composer.json')) {
            $composer = json_decode(File::get($metaPath), true) ?? [];

            $composer['extra']['tastyigniter-theme'] = array_merge(
                array_except($composer['extra']['tastyigniter-theme'], ['locked']),
                array_except($config, ['description'])
            );

            File::put($path.'/composer.json', json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }
}
