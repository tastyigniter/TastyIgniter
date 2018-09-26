<?php

namespace Main\Classes;

use App;
use File;
use Igniter\Flame\Pagic\Source\FileSource;
use Main\Template\Page as PageTemplate;
use Main\Template\Partial;
use System\Models\Themes_model;

class Theme
{
    /**
     * @var string The theme name
     */
    public $name;

    /**
     * @var string Theme label.
     */
    public $label;

    /**
     * @var string Specifies a description to accompany the theme
     */
    public $description;

    /**
     * @var string The theme version
     */
    public $version;

    /**
     * @var string The theme author
     */
    public $author;

    /**
     * @var string The theme domain
     */
    public $domain;

    /**
     * @var string List of extension code and version required by this theme
     */
    public $requires = [];

    /**
     * @var string The theme path absolute base path
     */
    public $path;

    /**
     * @var string The theme path relative to base path
     */
    public $publicPath;

    /**
     * @var boolean Determine if this theme should be loaded (false) or not (true).
     */
    public $disabled;

    /**
     * @var boolean Determine if this theme is active (false) or not (true).
     */
    public $active;

    /**
     * @var string Path to the screenshot image, relative to this theme folder.
     */
    public $screenshot;

    /**
     * @var array Cached theme configuration.
     */
    public $configCache;

    /**
     * Loads the theme.
     *
     * @param $path
     * @param array $config
     *
     * @return self
     */
    public static function load($path, array $config = [])
    {
        $theme = new static;
        $theme->path = realpath($path);
        $theme->publicPath = File::localToPublic($theme->path);
        $theme->fillFromArray($config);
        $theme->registerAsSource();

        return $theme;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getDirName()
    {
        return basename($this->path);
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function requires($require)
    {
        if (!is_array($require))
            $require = [$require];

        return $require;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function listPages()
    {
        return PageTemplate::listInTheme($this);
    }

    public function listPartials()
    {
        return Partial::listInTheme($this);
    }

    public function getConfig()
    {
        if (!is_null($this->configCache))
            return $this->configCache;

        $config = [];
        if (File::exists($configPath = $this->getPath().'/_meta/fields.php'))
            $config = File::getRequire($configPath);

        return $this->configCache = $config;
    }

    public function getConfigValue($name, $default = null)
    {
        return array_get($this->getConfig(), $name, $default);
    }

    public function hasCustomData()
    {
        return $this->getConfigValue('form', FALSE);
    }

    public function getCustomData()
    {
        return Themes_model::forTheme($this)->getThemeData();
    }

    /**
     * Returns variables that should be passed to the asset combiner.
     * @return array
     */
    public function getAssetVariables()
    {
        $result = [];

        $formFields = Themes_model::forTheme($this)->getFieldsConfig();
        foreach ($formFields as $attribute => $field) {
            if (!$varName = array_get($field, 'assetVar')) {
                continue;
            }

            $result[$varName] = $this->{$attribute};
        }

        return $result;
    }

    public function fillFromArray($config)
    {
        if (isset($config['code']))
            $this->name = $config['code'];

        if (isset($config['name']))
            $this->label = $config['name'];

        if (isset($config['domain']))
            $this->domain = $config['domain'];

        if (isset($config['description']))
            $this->description = $config['description'];

        if (isset($config['version']))
            $this->version = $config['version'];

        if (isset($config['author']))
            $this->author = $config['author'];

        if (isset($config['screenshot']))
            $this->screenshot = $config['screenshot'];

        if (!$this->screenshot)
            $this->screenshot = $this->publicPath.'/screenshot.png';

        if (isset($config['require']))
            $this->requires = $this->requires($config['require']);

        if (array_key_exists('disabled', $config))
            $this->disabled = $config['disabled'];
    }

    /**
     * Ensures this theme is registered as a Pagic source.
     * @return void
     */
    public function registerAsSource()
    {
        $resolver = App::make('pagic');

        if (!$resolver->hasSource($this->getDirName())) {
            $source = new FileSource($this->getPath(), App::make('files'));
            $resolver->addSource($this->getDirName(), $source);
        }
    }

    /**
     * Implements the getter functionality.
     *
     * @param  string $name
     *
     * @return void
     */
    public function __get($name)
    {
        if ($this->hasCustomData()) {
            return array_get($this->getCustomData(), $name);
        }

        return null;
    }

    /**
     * Determine if an attribute exists on the object.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        if ($this->hasCustomData()) {
            return array_has($this->getCustomData(), $key);
        }

        return FALSE;
    }
}