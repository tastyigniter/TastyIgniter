<?php namespace Main\Models;

use Main\Classes\MediaLibrary;
use Model;

/**
 * Image_tool Model Class
 * @package Admin
 */
class Image_tool_model extends Model
{
    public static function resize($imgPath, $width = null, $height = null)
    {
        traceLog('Image_tool_model::resize() has been deprecated, use '.MediaLibrary::class.'::getMediaThumb($options) instead.');

        $options = array_merge([
            'width' => is_array($width) ? null : $width,
            'height' => $height,
        ], is_array($width) ? $width : []);

        $rootFolder = config('system.assets.media.folder', 'data').'/';
        if (strpos($imgPath, $rootFolder) === 0)
            $imgPath = substr($imgPath, strlen($rootFolder));

        return MediaLibrary::instance()->getMediaThumb($imgPath, $options);
    }
}