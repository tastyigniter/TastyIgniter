<?php

declare(strict_types=1);

namespace Igniter\System\Libraries;

use Igniter\Flame\Html\HtmlFacade as Html;
use Igniter\Flame\Support\Facades\File;
use Igniter\Main\Classes\Theme;
use Igniter\System\Traits\CombinesAssets;
use JsonSerializable;
use RuntimeException;
use stdClass;

/**
 * Assets Class
 **
 * Within controllers, widgets, components and views, use facade:
 *   Assets::addCss($path, $options);
 *   Assets::addJs($path, $options);
 */
class Assets
{
    use CombinesAssets;

    protected array $registeredPaths = [];

    protected array $assets = [];

    protected string $jsVarNamespace = 'app';

    public function __construct()
    {
        $this->flush();

        $this->registeredPaths[] = public_path();

        $this->initCombiner();
    }

    /**
     * Set the default assets paths.
     */
    public function registerSourcePath(string $path): void
    {
        $this->registeredPaths[] = $path;
    }

    public function addFromManifest(string $path): void
    {
        $assetsConfigPath = $this->getAssetPath($path);
        if (!File::exists($assetsConfigPath)) {
            return;
        }

        $content = json_decode(File::get($assetsConfigPath), true) ?: [];
        if ($bundles = array_get($content, 'bundles')) {
            foreach ($bundles as $bundle) {
                $this->registerBundle(
                    array_get($bundle, 'type'),
                    array_get($bundle, 'files'),
                    array_get($bundle, 'destination'),
                );
            }
        }

        $this->addTags(array_except($content, 'bundles'));
    }

    public function addAssetsFromThemeManifest(Theme $theme): void
    {
        collect([$theme])
            ->merge($theme->hasParent() ? [$theme->getParent()] : [])
            ->first(function(Theme $theme) {
                if ($exists = File::exists($assetConfigFile = $theme->getAssetsFilePath())) {
                    $this->addFromManifest($assetConfigFile);
                }

                return $exists;
            });
    }

    public function addTags(array $tags = []): void
    {
        foreach ($tags as $type => $value) {
            if (!is_array($value)) {
                $value = [$value];
            }

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

    public function addTag(string $type, null|string|array $tag, array $options = []): self
    {
        return match ($type) {
            'icon', 'favicon' => $this->addFavIcon($tag),
            'meta' => $this->addMeta($tag),
            'rss' => $this->addRss($tag),
            'css', 'style' => $this->addCss($tag, $options),
            'js', 'script' => $this->addJs($tag, $options),
            default => $this,
        };

    }

    public function getFavIcon(): ?string
    {
        $favIcons = array_map(function($href): string {
            $attributes = ['rel' => 'shortcut icon', 'type' => 'image/x-icon'];
            if (is_array($href)) {
                $attributes = array_except($href, 'href');
                $href = $href['href'];
            }

            $attributes['href'] = asset($this->prepUrl($href));

            return '<link'.Html::attributes($attributes).'>'.PHP_EOL;
        }, $this->assets['icon']);

        return !empty($favIcons) ? implode("\t\t", $favIcons) : null;
    }

    public function getMetas(): ?string
    {
        if (empty($this->assets['meta'])) {
            return null;
        }

        $metas = array_map(fn($meta): string => '<meta'.Html::attributes($meta).'>'.PHP_EOL, $this->assets['meta']);

        return !empty($metas) ? implode("\t\t", $metas) : null;
    }

    public function getRss(): ?string
    {
        return $this->getAsset('rss');
    }

    public function getCss(): ?string
    {
        return $this->getAsset('css');
    }

    public function getJs(): ?string
    {
        return $this->getAsset('js');
    }

    public function getJsVars(): string
    {
        if (!$this->assets['jsVars']) {
            return '';
        }

        $output = sprintf('window.%s = window.%s || {};', $this->jsVarNamespace, $this->jsVarNamespace);

        $output .= collect($this->assets['jsVars'])->map(function($value, $name): string {
            $value = is_object($value)
                ? $this->transformJsObjectVar($value) : $this->transformJsVar($value);

            return sprintf('%s.%s = %s;', $this->jsVarNamespace, $name, $value);
        })->implode('');

        return sprintf('<script>%s</script>', $output);
    }

    public function addFavIcon(string|array $icon): self
    {
        $this->assets['icon'][] = $icon;

        return $this;
    }

    public function addMeta(array $meta = []): self
    {
        $this->assets['meta'][] = $meta;

        return $this;
    }

    public function addRss(string $path, null|string|array $attributes = []): self
    {
        $this->putAsset('rss', $path, $attributes);

        return $this;
    }

    public function addCss(string $path, string|array|null $attributes = null): self
    {
        $this->putAsset('css', $path, $attributes);

        return $this;
    }

    public function addJs(string $path, string|array|null $attributes = null): self
    {
        $this->putAsset('js', $path, $attributes);

        return $this;
    }

    public function putJsVars(array $variables): void
    {
        $this->assets['jsVars'] = array_merge($this->assets['jsVars'], $variables);
    }

    public function mergeJsVars(string $key, array $value): void
    {
        $vars = array_get($this->assets['jsVars'], $key, []);

        $value = array_merge((array)$vars, $value);

        array_set($this->assets['jsVars'], $key, $value);
    }

    public function flush(): void
    {
        $this->assets = ['icon' => [], 'meta' => [], 'rss' => [], 'js' => [], 'css' => [], 'jsVars' => []];
    }

    public function clearInternalCache(): void
    {
        $this->registeredPaths = [];
    }

    protected function putAsset(string $type, string $path, null|string|array $attributes)
    {
        $this->assets[$type][] = ['path' => $path, 'attributes' => $attributes];
    }

    protected function getAsset(string $type): ?string
    {
        $assets = $this->getUniqueAssets($type);
        if (empty($assets)) {
            return null;
        }

        $assetsToCombine = $this->prepareAssets(
            $this->filterAssetsToCombine($assets),
        );

        $assets[] = [
            'path' => $this->combine($type, $assetsToCombine),
            'attributes' => ['data-navigate-once' => 'true'],
        ];

        return $this->buildAssetUrls($type, $assets);
    }

    protected function getAssetPath(string $name): string
    {
        if (starts_with($name, ['//', 'http://', 'https://'])) {
            return $name;
        }

        if (starts_with($name, base_path())) {
            return $name;
        }

        if (File::isPathSymbol($name)) {
            return File::symbolizePath($name);
        }

        foreach ($this->registeredPaths as $path) {
            if (File::isFile($file = str_replace('//', '/', $path.'/'.$name))) {
                return $file;
            }
        }

        return $name;
    }

    protected function filterAssetsToCombine(array &$assets): array
    {
        $result = [];
        foreach ($assets as $key => $asset) {
            $path = array_get($asset, 'path');
            if (!$path || starts_with($path, ['//', 'http://', 'https://'])) {
                continue;
            }

            $result[] = $path;
            unset($assets[$key]);
        }

        return $result;
    }

    /**
     * Removes duplicate assets from the assets array.
     */
    protected function getUniqueAssets(string $type): array
    {
        if (empty($this->assets[$type])) {
            return [];
        }

        $collection = $this->assets[$type];

        $pathCache = [];
        foreach ($collection as $key => $asset) {
            $path = array_get($asset, 'path');
            $realPath = realpath(public_path($path)) ?: $path;
            if (isset($pathCache[$realPath])) {
                array_forget($collection, $key);
                continue;
            }

            $pathCache[$realPath] = true;
        }

        return $collection;
    }

    protected function prepUrl(string $path): string
    {
        $path = $this->getAssetPath($path);

        if (starts_with($path, public_path())) {
            $path = File::localToPublic($path);
        }

        return $path;
    }

    protected function buildAssetUrls(string $type, array $assets): string
    {
        $tags = [];
        foreach ($assets as $asset) {
            $path = array_get($asset, 'path');
            $attributes = array_get($asset, 'attributes');

            $tags[] = "\t\t".$this->buildAssetUrl($type, $this->prepUrl($path), $attributes);
        }

        return implode(PHP_EOL, $tags).PHP_EOL;
    }

    protected function buildAssetUrl(string $type, string $file, null|string|array $attributes): string
    {
        if (!is_array($attributes)) {
            $attributes = ['name' => $attributes];
        }

        if ($type === 'rss') {
            $html = '<link'.Html::attributes(array_merge([
                'rel' => 'alternate',
                'href' => $file,
                'title' => 'RSS',
                'type' => 'application/rss+xml',
            ], $attributes)).'>'.PHP_EOL;
        } elseif ($type === 'js') {
            $html = '<script'.Html::attributes(array_merge([
                'charset' => strtolower((string)setting('charset', 'UTF-8')),
                'type' => 'text/javascript',
                'src' => asset($file),
            ], $attributes)).'></script>'.PHP_EOL;
        } else {
            $html = '<link'.Html::attributes(array_merge([
                'rel' => 'stylesheet',
                'type' => 'text/css',
                'href' => asset($file),
            ], $attributes)).'>'.PHP_EOL;
        }

        return $html;
    }

    protected function transformJsVar(mixed $value): false|string
    {
        return json_encode($value);
    }

    protected function transformJsObjectVar(mixed $value): false|string
    {
        if ($value instanceof JsonSerializable || $value instanceof stdClass) {
            return json_encode($value);
        }

        // If a toJson() method exists, the object can cast itself automatically.
        if (method_exists($value, 'toJson')) {
            return json_encode($value->toJson());
        }

        // Otherwise, if the object doesn't even have a __toString() method, we can't proceed.
        if (!method_exists($value, '__toString')) {
            throw new RuntimeException('Cannot transform this object to JavaScript.');
        }

        return sprintf("'%s'", $value);
    }
}
