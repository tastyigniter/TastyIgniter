<?php namespace System\Libraries;

use App;
use File;
use Html;
use URL;

/**
 * Assets Class
 **
 * Uses Assetic PHP Assets Manager
 * Within controllers, widgets, components and views, use facade:
 *
 *   Assets::addCss($path, $options);
 *   Assets::addJs($path, $options);
 *
 * @package System
 */
class Assets
{
    const DEFAULT_COLLECTION = 'custom';

    public static $defaultPaths;

    protected $registeredLoaded;

    protected static $registeredCallback = [];

    protected $favicon = [];

    protected $tags = [];

    protected $assets = [];

    /**
     * Holds the current asset collection.
     * @var string
     */
    protected $collection;

    public $active_styles = '';

    public function __construct($app)
    {
        $this->app = $app;
    }

    public static function registerAssets(callable $callback)
    {
        static::$registeredCallback[] = $callback;
    }

    /**
     * Set the default assets paths.
     *
     * @param  string|array $paths
     *
     * @return void
     */
    public static function defaultPaths($paths)
    {
        static::$defaultPaths = $paths;
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
        $collection = $collection ?: self::DEFAULT_COLLECTION;

        $this->collection = $collection;

        return $this;
    }

    public function loadRegistered()
    {
        if ($this->registeredLoaded === TRUE)
            return;

        foreach (self::$registeredCallback as $callback) {
            $callback($this);
        }

        $this->registeredLoaded = TRUE;
    }

    public function addTags($headTags = [])
    {
        foreach ($headTags as $type => $value) {
            $this->addTag($type, $value);
        }
    }

    public function addTag($type, $tag)
    {
        if (is_string($type)) {
            switch ($type) {
                case 'favicon':
                    $this->addFavIcon($tag);
                    break;
                case 'meta':
                    $this->addMeta($tag);
                    break;
                case 'css':
                case 'style':
                    $this->addCss($tag);
                    break;
                case 'js':
                case 'script':
                    $this->addJs($tag);
                    break;
            }
        }
    }

    public function getFavIcon()
    {
        $favicons = array_map(function ($href) {
            if (!is_array($href))
                $href = ['href' => $href];

            if (isset($href['href']))
                $href['href'] = $this->prepUrl($href['href']);

            $href = array_merge([
                'rel'  => 'shortcut icon',
                'type' => 'image/x-icon',
            ], $href);

            return '<link'.Html::attributes($href).'>'.PHP_EOL;
        }, $this->favicon);

        return $favicons ? implode("\t\t", $favicons) : null;
    }

    public function getMetas()
    {
        $this->loadRegistered();

        if (!isset($this->assets[$this->collection]['meta']))
            return null;

        $metas = array_map(function ($meta) {
            return '<meta'.Html::attributes($meta).'>'.PHP_EOL;
        }, $this->assets[$this->collection]['meta']);

        return $metas ? implode("\t\t", $metas) : null;
    }

    public function getCss()
    {
        $this->loadRegistered();

        if (!isset($this->assets[$this->collection]['css']))
            return null;

        $this->removeDuplicates();

        $result = null;
        foreach ($this->assets[$this->collection]['css'] as $asset) {
            $attributes = $asset['attributes'];
            if (!isset($attributes['id']))
                $attributes['id'] = $asset['name'];

            $attributes = Html::attributes(array_merge([
                'href' => $asset['path'],
            ], $attributes));

            $result .= '<link'.$attributes.'>'.PHP_EOL;
        }

        return $result;
    }

    public function getJs()
    {
        $this->loadRegistered();

        if (!isset($this->assets[$this->collection]['js']))
            return null;

        $this->removeDuplicates();

        $result = null;
        foreach ($this->assets[$this->collection]['js'] as $asset) {
            $attributes = $asset['attributes'];
            if (!isset($attributes['id']))
                $attributes['id'] = $asset['name'];

            $attributes = Html::attributes(array_merge([
                'src' => $asset['path'],
            ], $attributes));

            $result .= '<script'.$attributes.'></script>'.PHP_EOL;
        }

        return $result;
    }

    public function addFavIcon($href)
    {
        $this->favicon[] = $href;

        return $this;
    }

    public function addMeta($meta = [])
    {
        $metaAssets = isset($this->assets[$this->collection]['meta'])
            ? $this->assets[$this->collection]['meta'] : [];

        $this->assets[$this->collection]['meta'] = array_merge($metaAssets, $meta);

        return $this;
    }

    public function addCss($href = null, $options = null)
    {
        if (is_array($href)) {
            foreach ($href as $item) {
                if (isset($item[0]) AND is_string($item[0])) {
                    $this->addCss($item[0], (isset($item[1])) ? $item[1] : null);
                }
                else if (isset($item['href'])) {
                    $this->addCss($item['href'], isset($item['name']) ? $item['name'] : null);
                }
            }

            return $this;
        }

        $options = $this->evalOptions('css', $href, $options);
//        var_dump($this->collection, $options);

        $this->assets[$this->collection]['css'][] = $options;

//        $this->assetsManager->createAsset($options);

        return $this;
    }

    public function addJs($href = null, $options = null)
    {
        if (is_array($href)) {
            foreach ($href as $item) {
                if (isset($item[0]) AND is_string($item[0])) {
                    $this->addJs($item[0], (isset($item[1])) ? $item[1] : null);
                }
                else if (isset($item['src'])) {
                    $this->addJs($item['src'], isset($item['name']) ? $item['name'] : null);
                }
            }

            return $this;
        }

        $options = $this->evalOptions('js', $href, $options);

        $this->assets[$this->collection]['js'][] = $options;

        return $this;
    }

    public function getActiveStyle()
    {
        // Compile the customizer styles
        $this->active_styles = $this->compileActiveStyle();

        return $this->active_styles."\n\t\t";
    }

    public function getActiveThemeOptions($item = null, $default = null)
    {
        return $default;
        if (setting(strtolower(APPDIR), 'active_theme_options')) {
            $active_theme_options = setting(strtolower(APPDIR), 'active_theme_options');
        }
        else if (setting(strtolower(APPDIR), 'customizer_active_style')) {
            $active_theme_options = setting(strtolower(APPDIR), 'customizer_active_style');
        }

        if (empty($active_theme_options) OR !isset($active_theme_options[0]) OR !isset($active_theme_options[1])) {
            return null;
        }

        if ($active_theme_options[0] !== $this->ci()->template->getTheme()) {
            return null;
        }

        $theme_options = null;
        if (is_array($active_theme_options[1])) {
            $theme_options = $active_theme_options[1];
        }

        if ($item === null) {
            return $theme_options;
        }
        else if (isset($theme_options[$item])) {
            return $theme_options[$item];
        }
        else {
            return null;
        }
    }

    public function flushAssets()
    {
        $this->assets[$this->collection] = ['meta' => [], 'js' => [], 'css' => []];
    }

    protected function evalOptions($type, $href, $options)
    {
        if (!is_array($options))
            $options = ['name' => $options];

        if ($type == 'css') {
            $defaults = [
                'name'       => null,
                'filter'     => [],
                'reference'  => null,
                'collection' => $this->collection,
                'path'       => $this->prepUrl($href, 'ver='.App::version()),
//                'path'       => $href,
                'attributes' => [
                    'rel'  => 'stylesheet',
                    'type' => 'text/css',
                ],
            ];
        }
        else {
            $defaults = [
                'name'       => null,
                'depends'    => null,
                'filter'     => [],
                'reference'  => null,
                'collection' => $this->collection,
                'path'       => $this->prepUrl($href, 'ver='.App::version()),
//                'path'       => $href,
                'attributes' => [
                    'charset' => strtolower(setting('charset')),
                    'type'    => 'text/javascript',
                ],
            ];
        }

        return array_merge($defaults, $options);
    }

    /**
     * Removes duplicate assets from the entire collection.
     * @return void
     */
    protected function removeDuplicates()
    {
        foreach ($this->assets[$this->collection] as $type => &$collection) {

            $pathCache = [];
            foreach ($collection as $key => $asset) {

                if (!$path = array_get($asset, 'path')) {
                    continue;
                }

                if (isset($pathCache[$path])) {
                    array_forget($collection, $key);
                    continue;
                }

                $pathCache[$path] = TRUE;
            }
        }
    }

    protected function prepUrl($href, $suffix = null)
    {
        if (substr($href, 0, 1) == ':') {
            $callable = explode(',', substr($href, 1));
            $args = array_splice($callable, 1);
            if (function_exists($callable[0]))
                $href = call_user_func_array($callable[0], $args);
        }
        else {
            $href = URL::asset($this->getAssetPath($href));
        }

        if (!is_null($suffix))
            $suffix = (strpos($href, '?') === FALSE) ? '?'.$suffix : '&'.$suffix;

        return $href.$suffix;
    }

    protected function compileActiveStyle($content = '')
    {
        return $content;
        if (setting(strtolower(APPDIR), 'active_theme_options')) {
            $active_theme_options = setting(strtolower(APPDIR), 'active_theme_options');
        }
        else if (setting(strtolower(APPDIR), 'customizer_active_style')) {
            $active_theme_options = setting(strtolower(APPDIR), 'customizer_active_style');
        }

        if (!empty($active_theme_options) AND isset($active_theme_options[0]) AND $active_theme_options[0] === $this->ci()->template->getTheme()) {
            $data = (isset($active_theme_options[1]) AND is_array($active_theme_options[1])) ? $active_theme_options[1] : [];
            $content = $this->ci()->template->load_view('stylesheet', $data);
        }

        return $content;
    }

    protected function getAssetPath($href)
    {
        if (substr($href, 0, 2) == '~/')
            return File::localToPublic(File::symbolizePath($href));

        if (starts_with($href, ['/', '//', 'http://', 'https://']))
            return $href;

        $paths = static::$defaultPaths;
        if (!is_array($paths))
            $paths = [$paths];

        foreach ($paths as $path) {
            if (File::exists($path = $path.'/'.$href))
                return File::localToPublic($path);
        }

//        if (App::runningInAdmin()) {
//            $viewPath = $this->themeManager->folders()['admin'];
//            if (File::exists($path = base_path($viewPath.'/'.$_href)))
//                return File::localToPublic($path);
//        }
//        else {
//            $activeTheme = $this->themeManager->getActiveTheme();
//
//            // We will first look in the active theme path,
//            // then its parent theme path if it has any before
//            // finally looking in the current app context views folder
//            foreach ([
//                         $activeTheme->getPath(),
//                         $activeTheme->getParentPath(),
//                         app_path(app()->appContext().'/views'),
//                     ] as $path) {
//
////            foreach (['/', '/_layouts/', '/_partials/'] as $folder) {
//                if (File::exists($path.'/'.$_href))
//                    return File::localToPublic($path.'/'.$_href);
////            }
//            }
//        }

        // Not found
        return $href;
    }
}