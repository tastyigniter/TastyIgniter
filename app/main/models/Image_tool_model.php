<?php namespace Main\Models;

use Main\Classes\MediaLibrary;
use Model;

/**
 * Image_tool Model Class
 * @package Admin
 */
class Image_tool_model extends Model
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