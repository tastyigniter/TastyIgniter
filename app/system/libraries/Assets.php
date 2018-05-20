<?php namespace System\Libraries;

use File;
use Html;
use System\Traits\CombinesAssets;
use URL;

/**
 * Assets Class
 **
 * Within controllers, widgets, components and views, use facade:
 *   Assets::addCss($path, $options);
 *   Assets::addJs($path, $options);
 * @package System
 */
class Assets
{
    use CombinesAssets;

    const DEFAULT_COLLECTION = 'custom';

    protected static $registeredPaths = [];

    protected static $registeredCallback = [];

    protected $assets = ['icon' => [], 'meta' => [], 'js' => [], 'css' => []];

    /**
     * Holds the current asset collection.
     * @var string
     */
    protected $collection;

    public $active_styles = '';

    public function __construct()
    {
        $this->initialize();
    }

    public function initialize()
    {
        $this->initCombiner();

        foreach (self::$registeredCallback as $callback) {
            $callback($this);
        }
    }

    public static function registerCallback(callable $callback)
    {
        static::$registeredCallback[] = $callback;
    }

    /**
     * Set the current assets collection.
     *
     * @param string|null $collection
     *
     * @return self
     */
    public function collection($collection = null)
    {
        $this->collection = $collection ?: self::DEFAULT_COLLECTION;

        return $this;
    }

    public function addTags(array $tags = [])
    {
        foreach ($tags as $type => $value) {
            if (!is_array($value))
                $value = [$value];

            foreach ($value as $item) {
                $options = [];
                if (isset($item['path'])) {
                    $options = array_except($item, 'path');
                    $item = $item['path'];
                }

                $this->addTag($type, $item, $options);
            }
        }
    }

    public function addTag($type, $tag, $options = [])
    {
        switch ($type) {
            case 'favicon':
                return $this->addFavIcon($tag);
            case 'meta':
                return $this->addMeta($tag);
            case 'css':
            case 'style':
                return $this->addCss($tag, $options);
            case 'js':
            case 'script':
                return $this->addJs($tag, $options);
        }
    }

    public function getFavIcon()
    {
        $favIcons = array_map(function ($icon) {
            return "\t\t".$this->renderTag($icon);
        }, $this->assets['icon']);

        return $favIcons ? implode(PHP_EOL, $favIcons) : null;
    }

    public function getMetas()
    {
        if (!count($this->assets['meta']))
            return null;

        $metas = array_map(function ($meta) {
            return '<meta'.Html::attributes($meta).'>'.PHP_EOL;
        }, $this->assets['meta']);

        return $metas ? implode("\t\t", $metas) : null;
    }

    public function getCss($sortBy = null)
    {
        return $this->getTags('css', $sortBy);
    }

    public function getJs($sortBy = null)
    {
        return $this->getTags('js', $sortBy);
    }

    public function addFavIcon($icon)
    {
        $options = [];
        if (is_array($icon)) {
            $options = array_except($icon, 'href');
            $icon = $icon['href'];
        }

        $this->pushTag('icon', $icon, ['attributes' => $options]);

        return $this;
    }

    public function addMeta(array $meta = [])
    {
        $metaAssets = $this->assets['meta'] ?? [];

        $this->assets['meta'] = array_merge($metaAssets, $meta);

        return $this;
    }

    public function addCss($path, $options = null)
    {
        $this->pushTag('css', $path, $options);

        return $this;
    }

    public function addJs($path, $options = null)
    {
        $this->pushTag('js', $path, $options);

        return $this;
    }

    public function getActiveStyle()
    {
        // Compile the customizer styles
        $this->active_styles = $this->compileActiveStyle();

        return $this->active_styles."\n\t\t";
    }

    public function flush()
    {
        $this->assets = ['meta' => [], 'js' => [], 'css' => []];
    }

    protected function pushTag($type, $path, $options = null)
    {
        $tagItem = $this->makeTagItem($type, $options);

        if (!is_array($path))
            $path = [$path];

        if ($tagItem->combine) {
            $path = [$this->combine($type, $path)];
        }

        foreach ($path as $value) {
            $tagItem->path = $this->prepUrl($value, $tagItem->suffix);
            $this->assets[$tagItem->type][] = $tagItem;
        }
    }

    protected function getTags($type, $sortBy)
    {
        if (!count($this->assets[$type]))
            return null;

        $this->removeDuplicates();

        if (is_null($sortBy))
            $sortBy = [];

        if (!is_array($sortBy))
            $sortBy = [$sortBy];

        $result = array_fill_keys($sortBy, []);
        foreach ($this->assets[$type] as $tag) {
            if ($sortBy AND !in_array($tag->collection, $sortBy))
                continue;

            $result[$tag->collection][] = "\t\t".$this->renderTag($tag);
        }

        return implode(PHP_EOL, array_collapse($result)).PHP_EOL;
    }

    protected function getAssetPath($name)
    {
        if (strpos($name, '~/') === 0)
            return File::localToPublic(File::symbolizePath($name));

        if (starts_with($name, ['/', '//', 'http://', 'https://']))
            return $name;

        $paths = static::$registeredPaths;
        if (!is_array($paths))
            $paths = [$paths];

        foreach ($paths as $path) {
            if (File::exists($path = $path.'/'.$name))
                return File::localToPublic($path);
        }

        return $name;
    }

    /**
     * Removes duplicate assets from the entire collection.
     *
     * @param $type
     *
     * @return void
     */
    protected function removeDuplicates()
    {
        foreach ($this->assets as $type => &$collection) {

            $pathCache = [];
            foreach ($collection as $key => $asset) {

                if (!isset($asset->path) OR !$path = $asset->path) continue;

                if (isset($pathCache[$path])) {
                    array_forget($collection, $key);
                    continue;
                }

                $pathCache[$path] = TRUE;
            }
        }
    }

    protected function prepUrl($path, $suffix = null)
    {
        $path = $this->getAssetPath($path);

        if (!is_null($suffix))
            $suffix = (strpos($path, '?') === FALSE) ? '?'.$suffix : '&'.$suffix;

        return URL::asset($path.$suffix);
    }

    protected function compileActiveStyle($content = '')
    {
        return $content;
        // @todo: implement
//        if (setting(strtolower(APPDIR), 'active_theme_options')) {
//            $active_theme_options = setting(strtolower(APPDIR), 'active_theme_options');
//        }
//        else if (setting(strtolower(APPDIR), 'customizer_active_style')) {
//            $active_theme_options = setting(strtolower(APPDIR), 'customizer_active_style');
//        }
//
//        if (!empty($active_theme_options) AND isset($active_theme_options[0]) AND $active_theme_options[0] === $this->ci()->template->getTheme()) {
//            $data = (isset($active_theme_options[1]) AND is_array($active_theme_options[1])) ? $active_theme_options[1] : [];
//            $content = $this->ci()->template->load_view('stylesheet', $data);
//        }
//
//        return $content;
    }

    protected function makeTagItem($type, $options)
    {
        $defaults = [
            'name'       => null,
            'type'       => $type,
            'path'       => null,
            'collection' => $this->collection,
            'suffix'     => null,
            'combine'    => FALSE,
            'attributes' => [],
        ];

        if (!is_array($options))
            $options = ['name' => $options];

        if (!isset($options['attributes'])) {
            if ($type == 'js') {
                $options['attributes'] = [
                    'charset' => strtolower(setting('charset', 'UTF-8')),
                    'type'    => 'text/javascript',
                ];
            }
            elseif ($type == 'icon') {
                $options['attributes'] = [
                    'rel'  => 'shortcut icon',
                    'type' => 'image/x-icon',
                ];
            }
            else {
                $options['attributes'] = [
                    'rel'  => 'stylesheet',
                    'type' => 'text/css',
                ];
            }
        }

        if (!isset($options['attributes']['id']) AND isset($options['name']))
            $options['attributes']['id'] = $options['name'];

        return (object)array_merge($defaults, $options);
    }

    protected function renderTag($tag)
    {
        if ($tag->type == 'js') {
            if ($tag->path AND !isset($tag->attributes['src']))
                $tag->attributes['src'] = $tag->path;

            $html = '<script'.Html::attributes($tag->attributes).'></script>'.PHP_EOL;
        }
        else {
            if ($tag->path AND !isset($tag->attributes['href']))
                $tag->attributes['href'] = $tag->path;

            $html = '<link'.Html::attributes($tag->attributes).'>'.PHP_EOL;
        }

        return $html;
    }

    /**
     * Set the default assets paths.
     *
     * @param  string $path
     *
     * @return void
     */
    public function registerSourcePath($path)
    {
        static::$registeredPaths[] = $path;
    }

    public function loadAssetsFromFile($file, $collection = null)
    {
        $assetsConfigPath = base_path().$this->getAssetPath($file);

        if (!File::exists($assetsConfigPath))
            return;

        $content = json_decode(File::get($assetsConfigPath), TRUE);

        if ($bundle = array_get($content, 'bundle')) {
            foreach ($bundle as $extension => $files) {
                $this->registerBundle($extension, $files);
            }
        }

        $this->collection($collection)->addTags(array_except($content, 'bundle'));
    }
}