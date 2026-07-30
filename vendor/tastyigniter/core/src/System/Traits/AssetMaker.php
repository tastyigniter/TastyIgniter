<?php

declare(strict_types=1);

namespace Igniter\System\Traits;

use Igniter\Flame\Support\Facades\File;
use Igniter\System\Facades\Assets;

trait AssetMaker
{
    /** Specifies a path to the asset directory. */
    public array $assetPath = [];

    public function flushAssets(): void
    {
        Assets::flush();
    }

    /**
     * Locates a file based on it's definition. If the file starts with
     * a forward slash, it will be returned in context of the application public path,
     * otherwise it will be returned in context of the asset path.
     */
    public function getAssetPath(string $fileName, mixed $assetPath = null): string
    {
        if (starts_with($fileName, ['//', 'http://', 'https://'])) {
            return $fileName;
        }

        if ($symbolizedPath = File::symbolizePath($fileName, null)) {
            return $symbolizedPath;
        }

        if (!$assetPath) {
            $assetPath = $this->assetPath;
        }

        foreach ((array)$assetPath as $path) {
            $_fileName = File::symbolizePath($path.'/'.$fileName);
            if (File::isFile($_fileName)) {
                return $_fileName;
            }
        }

        return $fileName;
    }

    public function addMeta(array $meta): void
    {
        Assets::addMeta($meta);
    }

    public function addJs(string $href, string|array|null $attributes = null): void
    {
        Assets::addJs($this->getAssetPath($href), $attributes);
    }

    public function addCss(string $href, string|array|null $attributes = null): void
    {
        Assets::addCss($this->getAssetPath($href), $attributes);
    }

    public function addRss(string $href, string|array|null $attributes = []): void
    {
        Assets::addRss($this->getAssetPath($href), $attributes);
    }
}
