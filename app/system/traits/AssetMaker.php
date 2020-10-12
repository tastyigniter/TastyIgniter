<?php

namespace System\Traits;

use Assets;
use File;

trait AssetMaker
{
    /**
     * @var array Specifies a path to the asset directory.
     */
    public $assetPath;

    public function flushAssets()
    {
        Assets::flush();
    }

    /**
     * Locates a file based on it's definition. If the file starts with
     * a forward slash, it will be returned in context of the application public path,
     * otherwise it will be returned in context of the asset path.
     *
     * @param string $fileName File to load.
     * @param string $assetPath Explicitly define an asset path.
     *
     * @return string Relative path to the asset file.
     */
    public function getAssetPath($fileName, $assetPath = null)
    {
        if (starts_with($fileName, ['//', 'http://', 'https://'])) {
            return $fileName;
        }

        if ($symbolizedPath = File::symbolizePath($fileName, null))
            return File::localToPublic($symbolizedPath);

        if (!$assetPath)
            $assetPath = $this->assetPath;

        if (!is_array($assetPath))
            $assetPath = [$assetPath];

        foreach ($assetPath as $path) {
            $_fileName = File::symbolizePath($path).'/'.$fileName;
            if (File::isFile($_fileName)) {
                return File::localToPublic($_fileName);
            }
        }

        return $fileName;
    }

    public function addMeta($meta)
    {
        Assets::addMeta($meta);
    }

    public function addJs($href, $attributes = null)
    {
        Assets::addJs($this->getAssetPath($href), $attributes);
    }

    public function addCss($href, $attributes = null)
    {
        Assets::addCss($this->getAssetPath($href), $attributes);
    }
}
