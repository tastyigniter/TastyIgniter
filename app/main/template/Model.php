<?php

namespace Main\Template;

use Igniter\Flame\Pagic\Contracts\TemplateSource;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Main\Classes\Theme;
use Main\Classes\ThemeManager;

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
    use Concerns\HasComponents;
    use Concerns\HasViewBag;

    /**
     * @var \Main\Classes\Theme The theme object.
     */
    protected $themeCache;

    protected $fillable = [];

    public $settings = [
        'components' => [],
    ];

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

        $activeTheme = ThemeManager::instance()->getActiveThemeCode();

        $resolver->setDefaultSourceName($activeTheme);
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
            ->remember(Config::get('system.parsedTemplateCacheTTL', now()->addDay()))
            ->find($fileName);
    }

    /**
     * Returns the list of objects in the specified theme.
     * This method is used internally by the system.
     *
     * @param \Main\Classes\Theme $theme Specifies a parent theme.
     * @param bool $skipCache Indicates if objects should be reloaded from the disk bypassing the cache.
     *
     * @return array|\Illuminate\Support\Collection
     */
    public static function listInTheme(Theme $theme, $skipCache = false)
    {
        $instance = static::inTheme($theme);

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

    public static function inTheme(Theme $theme)
    {
        return static::on($theme->getDirName());
    }

    public static function getDropdownOptions(Theme $theme = null, $skipCache = false)
    {
        $result = [];

        $pages = is_null($theme) ? self::get() : self::listInTheme($theme, $skipCache);
        foreach ($pages as $page) {
            $fileName = str_before($page->getBaseFileName(), '.blade');
            $description = $page instanceof Page ? $page->title : $page->description;
            $description = strlen($description) ? lang($description) : $fileName;
            $result[$fileName] = $description.' ['.$fileName.']';
        }

        return collect($result)->sort()->all();
    }

    //
    //
    //

    /**
     * Returns the unique id of this object.
     * ex. account/login.blade.php => account-login
     * @return string
     */
    public function getId()
    {
        $fileName = $this->getBaseFileName();

        return str_replace('/', '-', str_before($fileName, '.blade'));
    }

    /**
     * Returns the theme this object belongs to.
     * @return \Main\Classes\Theme
     */
    public function getThemeAttribute($value = null)
    {
        if (!is_null($value))
            return $value;

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
     * @param string $fileName
     *
     * @return string
     */
    public function getFilePath($fileName = null)
    {
        if ($fileName === null) {
            $fileName = $this->fileName;
        }

        $fileName = $this->getTypeDirName().'/'.$fileName;

        if ($this->theme->hasParent() && File::exists($this->theme->getParentPath().'/'.$fileName))
            return $this->theme->getParentPath().'/'.$fileName;

        return $this->theme->getPath().'/'.$fileName;
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
        return $this->baseFileName;
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

    //
    // Magic
    //

    /**
     * Implements getter functionality for visible properties defined in
     * the settings section or view bag array.
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (is_array($this->settings) && array_key_exists($name, $this->settings)) {
            return $this->settings[$name];
        }

        return parent::__get($name);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        parent::__set($key, $value);

        if (array_key_exists($key, $this->settings)) {
            $this->settings[$key] = $this->attributes[$key];
        }
    }

    /**
     * Determine if an attribute exists on the object.
     *
     * @param string $key
     * @return bool
     */
    public function __isset($key)
    {
        if (parent::__isset($key) === true) {
            return true;
        }

        return isset($this->settings[$key]);
    }
}
