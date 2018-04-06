<?php namespace Main\Models;

use Main\Libraries\MediaManager;
use Model;

/**
 * Image_tool Model Class
 * @package Admin
 */
class Image_tool_model extends Model
{
    public static function resize($imgPath, $width = null, $height = null)
    {
        extract(array_merge([
            'width'   => is_array($width) ? null : $width,
            'height'  => $height,
            'crop'    => FALSE,
            'default' => 'no_photo.png',
        ], is_array($width) ? $width : []));

        // @todo implement image manipulator

        $rootFolder = 'data/';
        if (strpos($imgPath, $rootFolder) === 0)
            $imgPath = substr($imgPath, strlen($rootFolder));

        return MediaManager::instance()->getMediaUrl($imgPath);
    }
}