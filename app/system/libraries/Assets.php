<?php namespace System\Libraries;

use File;
use Html;
use System\Traits\CombinesAssets;

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

    protected static $registeredPaths = [];

    protected static $registeredCallback = [];

    protected $assets = ['icon' => [], 'meta' => [], 'js' => [], 'css' => []];

    public function __construct()
    {
        $this->initialize();
    }

    public function initialize()
    {
        static::$registeredPaths[] = base_path();

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

    public function addFromManifest($path)
    {
        $assetsConfigPath = base_path().$this->getAssetPath($path);
        if (!File::exists($assetsConfigPath))
            return FALSE;

        $content = json_decode(File::get($assetsConfigPath), TRUE);
        if ($bundles = array_get($content, 'bundles')) {
            foreach ($bundles as $bundle) {
                $this->registerBundle(
                    array_get($bundle, 'type'),
                    array_get($bundle, 'files'),
                    array_get($bundle, 'destination')
                );
            }
        }

        $this->addTags(array_except($content, 'bundles'));
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
            case 'icon':
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
        $favIcons = array_map(function ($href) {
            $attributes = ['rel' => 'shortcut icon', 'type' => 'image/x-icon'];
            if (is_array($href)) {
                $attributes = array_except($href, 'href');
                $href = $href['href'];
            }

            $attributes['href'] = asset($this->prepUrl($href));

            return '<link'.Html::attributes($attributes).'>'.PHP_EOL;
        }, $this->assets['icon']);

        return $favIcons ? implode("\t\t", $favIcons) : null;
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

    public function getCss()
    {
        return $this->getAsset('css');
    }

    public function getJs()
    {
        return $this->getAsset('js');
    }

    public function addFavIcon($icon)
    {
        $this->assets['icon'][] = $icon;

        return $this;
    }

    public function addMeta(array $meta = [])
    {
        $this->assets['meta'][] = $meta;

        return $this;
    }

    public function addCss($path, $attributes = null)
    {
        $this->putAsset('css', $path, $attributes);

        return $this;
    }

    public function addJs($path, $attributes = null)
    {
        $this->putAsset('js', $path, $attributes);

        return $this;
    }

    public function flush()
    {
        $this->assets = ['meta' => [], 'js' => [], 'css' => []];
    }

    protected function putAsset($type, $path, $attributes)
    {
        $this->assets[$type][] = ['path' => $path, 'attributes' => $attributes];
    }

    protected function getAsset($type)
    {
        $assets = $this->getUniqueAssets($type);
        if (!$assets)
            return null;

        if ($this->combineAssets) {
            $path = $this->combine($type, $this->getAssetPaths($assets));

            return $this->buildAssetUrl($type, $path);
        }

        return $this->buildAssetUrls($type, $assets);
    }

    protected function getAssetPath($name)
    {
        if (starts_with($name, ['//', 'http://', 'https://']))
            return $name;

        if (File::isPathSymbol($name))
            return File::localToPublic(File::symbolizePath($name));

        foreach (static::$registeredPaths as $path) {
            if (File::exists($path = realpath($path.'/'.$name)))
                return File::localToPublic($path);
        }

        return $name;
    }

    protected function getAssetPaths($assets)
    {
        $result = [];
        foreach ($assets as $asset) {
            $result[] = array_get($asset, 'path');
        }

        return $result;
    }

    /**
     * Removes duplicate assets from the assets array.
     *
     * @param $type
     * @return array
     */
    protected function getUniqueAssets($type)
    {
        if (!count($this->assets[$type]))
            return [];

        $collection = $this->assets[$type];

        $pathCache = [];
        foreach ($collection as $key => $asset) {
            $path = array_get($asset, 'path');
            if (!$path) continue;

            $realPath = realpath(base_path($path)) ?: $path;
            if (isset($pathCache[$realPath])) {
                array_forget($collection, $key);
                continue;
            }

            $pathCache[$realPath] = TRUE;
        }

        return $collection;
    }

    protected function prepUrl($path, $suffix = null)
    {
        $path = $this->getAssetPath($path);

        if (!is_null($suffix))
            $suffix = (strpos($path, '?') === FALSE) ? '?'.$suffix : '&'.$suffix;

        return $path.$suffix;
    }

    protected function buildAssetUrls($type, $assets)
    {
        $tags = [];
        foreach ($assets as $asset) {
            $path = array_get($asset, 'path');
            $attributes = array_get($asset, 'attributes');
            $tags[] = "\t\t".$this->buildAssetUrl($type, $this->prepUrl($path), $attributes);
        }

        return implode(PHP_EOL, $tags).PHP_EOL;
    }

    protected function buildAssetUrl($type, $file, $attributes = null)
    {
        if (!is_array($attributes))
            $attributes = ['name' => $attributes];

        if ($type == 'js') {
            $html = '<script'.Html::attributes(array_merge([
                    'charset' => strtolower(setting('charset', 'UTF-8')),
                    'type' => 'text/javascript',
                    'src' => asset($file)
                ], $attributes)).'></script>'.PHP_EOL;
        }
        else {
            $html = '<link'.Html::attributes(array_merge([
                    'rel' => 'stylesheet',
                    'type' => 'text/css',
                    'href' => asset($file)
                ], $attributes)).'>'.PHP_EOL;
        }

        return $html;
    }
}