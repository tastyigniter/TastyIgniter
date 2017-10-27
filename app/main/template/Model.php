<?php

namespace Main\Template;

use Config;
use Main\Classes\Theme;
use Main\Classes\ThemeManager;
use Main\Contracts\TemplateSource;

/**
 * @property \Main\Classes\Theme theme The theme this model belongs to
 * @property string fileName The source path
 * @property array settings The template settings
 * @property string content The template source code
 * @property string code The template code section
 * @property string markup The template markup section
 * @property int mTime The template last modified timestamp
 */
class Model extends \Igniter\Flame\Pagic\Model implements TemplateSource
{
    /**
     * @var \Main\Classes\Theme The theme object.
     */
    protected $themeCache;

    protected $fillable = [];

    /**
     * The "booting" method of the model.
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::bootDefaultTheme();
    }

    /**
     * Boot all of the bootable traits on the model.
     * @return void
     */
    protected static function bootDefaultTheme()
    {
        $resolver = static::getSourceResolver();
        if ($resolver->getDefaultSourceName()) {
            return;
        }

        $manager = ThemeManager::instance();
        $defaultTheme = $manager->getActiveThemeCode();

        $resolver->setDefaultSourceName($defaultTheme);
    }

    /**
     * Loads the object from a file.
     * This method is used in the admin. It doesn't use any caching.
     *
     * @param \Main\Classes\Theme $theme Specifies the theme the object belongs to.
     * @param string $fileName Specifies the file name, with the extension.
     * The file name can contain only alphanumeric symbols, dashes and dots.
     *
     * @return mixed Returns a Template object instance or null if the object wasn't found.
     */
    public static function load($theme, $fileName)
    {
        return static::on($theme->getDirName())->find($fileName);
    }

    /**
     * Loads the object from a cache.
     * This method is used by the main in the runtime. If the cache is not found, it is created.
     *
     * @param \Main\Classes\Theme $theme Specifies the theme the object belongs to.
     * @param string $fileName Specifies the file name, with the extension.
     *
     * @return mixed Returns a Template object instance or null if the object wasn't found.
     */
    public static function loadCached($theme, $fileName)
    {
        return static::on($theme->getDirName())
                     ->remember(Config::get('system.parsedTemplateCacheTTL', 1440))
                     ->find($fileName);
    }

    /**
     * Returns the list of objects in the specified theme.
     * This method is used internally by the system.
     *
     * @param \Main\Classes\Theme $theme Specifies a parent theme.
     * @param boolean $skipCache Indicates if objects should be reloaded from the disk bypassing the cache.
     *
     * @return array|\Illuminate\Support\Collection
     */
    public static function listInTheme(Theme $theme, $skipCache = FALSE)
    {
        $instance = static::on($theme->getDirName());

        if ($skipCache) {
            return $instance->get();
        }

        $result = [];
        $items = $instance->newFinder()->lists('fileName');

        foreach ($items as $file) {
            $result[] = static::loadCached($theme, $file);
        }

        return $instance->newCollection($result);
    }

    /**
     * Returns the theme this object belongs to.
     * @return \Main\Classes\Theme
     */
    public function getThemeAttribute()
    {
        if ($this->themeCache !== null) {
            return $this->themeCache;
        }

        $themeName = $this->getSourceName()
            ?: static::getSourceResolver()->getDefaultSourceName();

        return $this->themeCache = ThemeManager::instance()->findTheme($themeName);
    }

    /**
     * Returns the local file path to the template.
     *
     * @param  string $fileName
     *
     * @return string
     */
    public function getFilePath($fileName = null)
    {
        if ($fileName === null) {
            $fileName = $this->fileName;
        }

        return $this->theme->getPath().'/'.$this->getTypeDirName().'/'.$fileName;
    }

    /**
     * Returns the file name.
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Returns the file name without the extension.
     * @return string
     */
    public function getBaseFileName()
    {
        $pos = strrpos($this->fileName, '.');
        if ($pos === FALSE) {
            return $this->fileName;
        }

        return substr($this->fileName, 0, $pos);
    }

    /**
     * Returns the file content.
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Gets the markup section of a template
     * @return string The template source code
     */
    public function getMarkup()
    {
        return $this->markup;
    }

    /**
     * Gets the code section of a template
     * @return string The template source code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns the key used by the Template cache.
     * @return string
     */
    public function getTemplateCacheKey()
    {
        return $this->getFilePath();
    }
}