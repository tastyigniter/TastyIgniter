<?php

namespace Main\Helpers;

use Main\Classes\MediaLibrary;

class ImageHelper
{
    public static function resize($path, $width = 0, $height = 0)
    {
        $options = array_merge([
            'width' => is_array($width) ? 0 : $width,
            'height' => $height,
        ], is_array($width) ? $width : []);

        $rootFolder = config('system.assets.media.folder', 'data').'/';
        if (starts_with($path, $rootFolder))
            $path = substr($path, strlen($rootFolder));

        return MediaLibrary::instance()->getMediaThumb($path, $options);
    }
}

class_alias('Main\Helpers\ImageHelper', 'Main\Models\Image_tool_model', FALSE);
