<?php namespace System\Traits;

use Assets;
use File;

trait AssetMaker
{
    /**
     * @var string Specifies a path to the asset directory.
     */
    public $assetPath;

    /**
     * @var string Specifies a path to the asset directory.
     */
    public $assetCollection;

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

        if (!$assetPath) {
            $assetPath = $this->assetPath;
        }

        if ($assetPath = File::symbolizePath($assetPath))
            $assetPath = File::localToPublic($assetPath);

        if (substr($fileName, 0, 1) == '/' OR $assetPath === null) {
            return $fileName;
        }

        return $assetPath.'/'.$fileName;
    }

    public function addMeta($meta)
    {
        Assets::addMeta($meta);
    }

    public function addJs($href, $options = null)
    {
        $jsPath = $this->getAssetPath($href);

        Assets::collection($this->assetCollection)->addJs($jsPath, $options);
    }

    public function addCss($href, $options = null)
    {
        $cssPath = $this->getAssetPath($href);

        Assets::collection($this->assetCollection)->addCss($cssPath, $options);
    }
}