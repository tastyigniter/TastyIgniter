<?php

declare(strict_types=1);

namespace Igniter\Main\Classes;

use Exception;
use Facades\Igniter\System\Helpers\SystemHelper;
use Igniter\Flame\Composer\Manager;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Pagic\Contracts\TemplateInterface;
use Igniter\Flame\Pagic\Model;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Models\Theme as ThemeModel;
use Igniter\Main\Template\Page;
use Igniter\System\Classes\PackageManifest;
use Igniter\System\Classes\UpdateManager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use LogicException;

/**
 * Theme Manager Class
 */
class ThemeManager
{
    /**
     * @var array of disabled themes.
     */
    public array $disabledThemes = [];

    /**
     * @var array used for storing theme information objects.
     */
    public array $themes = [];

    /**
     * @var array of themes and their directory paths.
     */
    protected array $paths = [];

    protected array $config = [
        'allowedImageExt' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff'],
        'allowedFileExt' => ['html', 'txt', 'xml', 'js', 'css', 'php', 'json'],
    ];

    protected bool $booted = false;

    protected array $directories = [];

    public function initialize(): void
    {
        $this->disabledThemes = resolve(PackageManifest::class)->disabledAddons();
    }

    public function addDirectory(string $directory): void
    {
        $this->directories[] = $directory;
    }

    public function clearDirectory(): void
    {
        $this->directories = [];
    }

    //
    // Registration Methods
    //

    /**
     * Returns a list of all themes in the system.
     */
    public function listThemes(): array
    {
        return $this->themes;
    }

    /**
     * Finds all available themes and loads them in to the $themes array.
     */
    public function loadThemes(): array
    {
        $packageManifest = resolve(PackageManifest::class);
        foreach ($packageManifest->themes() as $config) {
            $this->loadTheme($packageManifest->getPackagePath(array_get($config, 'installPath')));
        }

        foreach ($this->folders() as $path) {
            $this->loadTheme($path);
        }

        return $this->themes;
    }

    protected function loadThemeFromConfig($path, $config): ?Theme
    {
        $code = array_get($config, 'code');
        if (!$code || !$this->checkName($code)) {
            return null;
        }

        if (isset($this->themes[$code])) {
            return $this->themes[$code];
        }

        try {
            $config = SystemHelper::themeValidateConfig($config);
            $themeObject = new Theme($path, $config);
            $themeObject->active = $this->isActive($code);
            $this->themes[$code] = $themeObject;
            $this->paths[$code] = $themeObject->getPath();

            return $themeObject;
        } catch (Exception $exception) {
            logger()->debug($exception->getMessage());

            return null;
        }
    }

    /**
     * Loads a single theme in to the manager.
     */
    public function loadTheme(string $path): ?Theme
    {
        $config = SystemHelper::themeConfigFromFile($path);

        return $this->loadThemeFromConfig($path, $config);
    }

    public function bootThemes(): void
    {
        if ($this->booted) {
            return;
        }

        if (!$this->themes) {
            $this->loadThemes();
        }

        collect($this->themes)->each(function(Theme $theme) {
            $this->bootTheme($theme);
        });

        $this->booted = true;
    }

    public function bootTheme(Theme $theme): void
    {
        Page::getSourceResolver()->addSource($theme->getName(), $theme->makeFileSource());

        if ($theme->isActive()) {
            Page::getSourceResolver()->setDefaultSourceName($theme->getName());
        }

        collect([$theme->getPath().'/resources', $theme->getPath().'/assets', $theme->getPath()])
            ->merge($theme->hasParent() ? [$theme->getParent()->getPath().'/resources', $theme->getParent()->getPath().'/assets', $theme->getParent()->getPath()] : [])
            ->filter(fn($path) => File::isDirectory($path))
            ->reverse()
            ->each(function($path) use ($theme) {
                Igniter::loadResourcesFrom($path, $theme->getName());
            });

        if ($pathsToPublish = $theme->getPathsToPublish()) {
            foreach (['laravel-assets', 'igniter-assets'] as $group) {
                if (!array_key_exists($group, ServiceProvider::$publishGroups)) {
                    ServiceProvider::$publishGroups[$group] = [];
                }

                ServiceProvider::$publishGroups[$group] = array_merge(
                    ServiceProvider::$publishGroups[$group], $pathsToPublish,
                );
            }
        }

        if (File::isDirectory($theme->getSourcePath())) {
            View::addNamespace($theme->getName(), $theme->getSourcePath());

            if ($theme->hasParent() && $theme->isActive()) {
                View::prependNamespace($theme->getParent()->getName(), $theme->getSourcePath());
            }
        }
    }

    //
    // Management Methods
    //

    public function getActiveTheme(): ?Theme
    {
        return $this->findTheme($this->getActiveThemeCode());
    }

    public function getActiveThemeCode(): ?string
    {
        return Theme::getActiveCode();
    }

    /**
     * Returns a theme object based on its name.
     */
    public function findTheme(?string $themeCode = null): ?Theme
    {
        return $this->hasTheme($themeCode) ? $this->themes[$themeCode] : null;
    }

    /**
     * Checks to see if an extension has been registered.
     */
    public function hasTheme(?string $themeCode = null): bool
    {
        return isset($this->themes[$themeCode]);
    }

    /**
     * Returns the theme domain by looking in its path.
     */
    public function findParent(?string $themeCode = null): ?Theme
    {
        return $this->findTheme($this->findParentCode($themeCode));
    }

    /**
     * Returns the parent theme code.
     */
    public function findParentCode(?string $themeCode = null): ?string
    {
        return $this->findTheme($themeCode)?->getParentName();
    }

    public function paths(): array
    {
        return $this->paths;
    }

    /**
     * Create a Directory Map of all themes
     */
    public function folders(): array
    {
        $paths = [];

        $directories = $this->directories;
        if (File::isDirectory($themesPath = Igniter::themesPath())) {
            array_unshift($directories, $themesPath);
        }

        foreach ($directories as $directory) {
            foreach (File::glob($directory.'/*/theme.json') as $path) {
                $paths[] = dirname((string)$path);
            }
        }

        return $paths;
    }

    /**
     * Determines if a theme is activated by looking at the default themes config.
     */
    public function isActive(string $themeCode): bool
    {
        if (!$this->checkName($themeCode)) {
            return false;
        }

        return rtrim($themeCode, '/') == $this->getActiveThemeCode();
    }

    /**
     * Determines if a theme is disabled by looking at the installed themes config.
     * @codeCoverageIgnore
     */
    public function isDisabled(string $themeCode): bool
    {
        throw new LogicException('Deprecated. Use $instance::isActive($themeCode) instead');
    }

    /**
     * Checks to see if a theme has been registered.
     */
    public function checkName(string $themeCode): ?string
    {
        if ($themeCode === 'errors') {
            return null;
        }

        return (str_starts_with($themeCode, '_') || preg_match('/\s/', $themeCode)) ? null : $themeCode;
    }

    public function isLocked(string $themeCode): bool
    {
        return (bool)optional($this->findTheme($themeCode))->locked;
    }

    public function checkParent(string $themeCode): bool
    {
        foreach ($this->themes as $theme) {
            if ($theme->hasParent() && $theme->getParentName() == $themeCode) {
                return true;
            }
        }

        return false;
    }

    public function isLockedPath(string $path, Theme $theme): bool
    {
        if ($theme->hasParent() && str_starts_with($path, $theme->getParent()->getPath())) {
            return $theme->getParent()->locked;
        }

        if (!str_starts_with($path, $theme->getPath())) {
            return true;
        }

        return $theme->locked;
    }

    //
    // Theme Helper Methods
    //

    /**
     * Returns a theme path based on its name.
     */
    public function findPath($themeCode): ?string
    {
        return $this->paths()[$themeCode] ?? null;
    }

    /**
     * Find a file.
     * Scans for files located within themes directories. Also scans each theme
     * directories for layouts, partials, and content. Generates fatal error if file
     * not found.
     */
    public function findFile(string $filename, string $themeCode, null|string|array $base = null): false|string
    {
        $path = $this->findPath($themeCode);

        $themePath = rtrim((string)$path, '/');
        if (is_null($base)) {
            $base = ['/'];
        } elseif (!is_array($base)) {
            $base = [$base];
        }

        foreach ($base as $folder) {
            if (File::isFile($path = $themePath.$folder.$filename)) {
                return $path;
            }
        }

        return false;
    }

    /**
     * Load a single theme generic file into an array. The file will be
     * found by looking in the _layouts, _pages, _partials, _content, themes folders.
     */
    public function readFile(string $filePath, string $themeCode): TemplateInterface
    {
        $theme = $this->findTheme($themeCode);

        [$dirName, $fileName] = $this->getFileNameParts($filePath);

        if (!strlen((string)$fileName) || !$template = $theme->onTemplate($dirName)->find($fileName)) {
            throw new SystemException('Theme template file not found: '.$filePath);
        }

        return $template;
    }

    public function newFile(string $filePath, ?string $themeCode): string|false
    {
        $theme = $this->findTheme($themeCode);
        [$dirName, $fileName] = $this->getFileNameParts($filePath);
        $path = $theme->getPath().'/'.$dirName.'/'.$fileName;

        if (!File::extension($path)) {
            $path .= '.'.Model::DEFAULT_EXTENSION;
        }

        if (File::isFile($path)) {
            throw new SystemException('Theme template file already exists: '.$filePath);
        }

        if (!File::isDirectory($directory = File::dirname($path))) {
            File::makeDirectory($directory, 0777, true, true);
        }

        return File::put($path, "\n") ? $path : false;
    }

    /**
     * Write an existing theme layout, page, partial or content file.
     */
    public function writeFile(string $filePath, array $attributes, string $themeCode): bool
    {
        $theme = $this->findTheme($themeCode);

        [$dirName, $fileName] = $this->getFileNameParts($filePath);

        if (!$template = $theme->onTemplate($dirName)->find($fileName)) {
            throw new SystemException('Theme template file not found: '.$filePath);
        }

        return $template->fill($attributes)->save();
    }

    /**
     * Rename a theme layout, page, partial or content in the file system.
     */
    public function renameFile(string $filePath, string $newFilePath, string $themeCode): bool|int
    {
        $theme = $this->findTheme($themeCode);

        [$dirName, $fileName] = $this->getFileNameParts($filePath);
        [$newDirName, $newFileName] = $this->getFileNameParts($newFilePath);

        if (!$template = $theme->onTemplate($dirName)->find($fileName)) {
            throw new SystemException('Theme template file not found: '.$filePath);
        }

        if ($this->isLockedPath($template->getFilePath(), $theme)) {
            throw new SystemException(lang('igniter::system.themes.alert_theme_path_locked'));
        }

        $oldFilePath = $theme->path.'/'.$dirName.'/'.$fileName;
        $newFilePath = $theme->path.'/'.$newDirName.'/'.$newFileName;

        if ($oldFilePath === $newFilePath) {
            throw new SystemException('Theme template file already exists: '.$filePath);
        }

        return $template->update(['fileName' => $newFileName]);
    }

    /**
     * Delete a theme layout, page, partial or content from the file system.
     */
    public function deleteFile(string $filePath, string $themeCode): bool
    {
        $theme = $this->findTheme($themeCode);

        [$dirName, $fileName] = $this->getFileNameParts($filePath);

        if (!$template = $theme->onTemplate($dirName)->find($fileName)) {
            throw new SystemException('Theme template file not found: '.$filePath);
        }

        if ($this->isLockedPath($template->getFilePath(), $theme)) {
            throw new SystemException(lang('igniter::system.themes.alert_theme_path_locked'));
        }

        return $template->delete();
    }

    /**
     * Delete existing theme folder from filesystem.
     */
    public function removeTheme(string $themeCode): bool
    {
        $themePath = $this->findPath($themeCode);
        if (!File::isDirectory($themePath)) {
            return false;
        }

        File::deleteDirectory($themePath);

        return true;
    }

    /**
     * Delete a single theme by code
     */
    public function deleteTheme(string $themeCode, bool $deleteData = true): void
    {
        if ($deleteData) {
            ThemeModel::where('code', $themeCode)->delete();
            resolve(UpdateManager::class)->purgeExtension($themeCode);
        }

        $composerManager = resolve(Manager::class);
        if ($packageName = $composerManager->getPackageName($themeCode)) {
            $composerManager->uninstall([$packageName]);
        } else {
            $this->removeTheme($themeCode);
        }
    }

    public function installTheme(string $code, ?string $version = null): bool
    {
        /** @var ThemeModel $model */
        $model = ThemeModel::firstOrNew(['code' => $code]);

        if (is_null($themeObj = $this->findTheme($model->code))) {
            return false;
        }

        $model->name = $themeObj->label ?? title_case($code);
        $model->code = $code;
        $model->version = $version ?? resolve(PackageManifest::class)->getVersion($code) ?? $model->version;
        $model->description = $themeObj->description ?? '';
        $model->save();

        return true;
    }

    /**
     * Update installed extensions config value
     */
    public function updateInstalledThemes(string $code, ?bool $enable = true): void
    {
        if ($enable) {
            array_pull($this->disabledThemes, $code);
        } else {
            $this->disabledThemes[$code] = true;
        }

        resolve(PackageManifest::class)->writeDisabled($this->disabledThemes);
    }

    public function createChildTheme(string $parentThemeCode, ?string $childThemeCode = null): ThemeModel
    {
        $parentTheme = $this->findTheme($parentThemeCode);
        throw_if(!$parentTheme || $parentTheme->hasParent(), new SystemException(
            'Can not create a child theme from another child theme',
        ));

        $childThemeCode = ThemeModel::generateUniqueCode($childThemeCode ?? $parentThemeCode);
        $childThemePath = Igniter::themesPath().'/'.$childThemeCode;

        throw_if(File::isDirectory($childThemePath), new SystemException('Child theme path already exists.'));

        File::makeDirectory($childThemePath, 0777, true, true);

        $themeConfig = [
            'code' => $childThemeCode,
            'name' => $parentTheme->label.' [child]',
            'description' => $parentTheme->description,
            'parent' => $parentTheme->name,
            'version' => array_get($parentTheme->config, 'version'),
            'author' => array_get($parentTheme->config, 'author', ''),
            'homepage' => array_get($parentTheme->config, 'homepage', ''),
            'require' => $parentTheme->requires,
        ];

        File::put($childThemePath.'/theme.json', json_encode($themeConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $themeConfig['data'] = $parentTheme->data ?? [];
        /** @var ThemeModel $childThemeModel */
        $childThemeModel = ThemeModel::create(array_only($themeConfig, [
            'code', 'name', 'description', 'data',
        ]));

        $this->booted = false;
        $this->themes = [];
        $this->bootThemes();

        return $childThemeModel;
    }

    protected function getFileNameParts(string $path): array
    {
        $parts = explode('/', $path);
        $dirName = $parts[0];
        $fileName = implode('/', array_splice($parts, 1));

        return [$dirName, str_replace('.', '/', $fileName)];
    }
}
