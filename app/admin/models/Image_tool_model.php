<?php namespace Admin\Models;

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

//        $setting = setting('image_manager');

        $rootFolder = 'data/';
        if (strpos($imgPath, $rootFolder) === 0)
            $imgPath = substr($imgPath, strlen($rootFolder));

        $imgPath = $rootFolder.ltrim($imgPath, '/');
        if (!is_file(image_path($imgPath)))
            $imgPath = $default;

//        if (empty($width) AND empty($height))
        return image_url($imgPath);

//        if (!File::isDirectory($thumbsPath = image_path('thumbs')))
//            File::makeDirectory($thumbsPath, 0777, TRUE);
//
//        if (is_dir(image_path().$rootFolder.$imgPath) AND !is_dir($thumbsPath.'/'.$imgPath)) {
//            self::createFolder($thumbsPath.'/'.$imgPath);
//        }

//        $info = pathinfo($imgPath);
//        $extension = $info['extension'];

//        dd($imgPath, $setting, $info);
//        $old_path = image_path().$rootFolder.$imgPath;
//
//        $new_path = image_path().'thumbs/'.substr($imgPath, 0, strrpos($imgPath, '.')).'-'.$width.'x'.$height.'.'.$extension;
//        $new_image = 'thumbs/'.substr($imgPath, 0, strrpos($imgPath, '.')).'-'.$width.'x'.$height.'.'.$extension;

//        if (file_exists($old_path) AND !file_exists($new_path)) {
//            $CI =& get_instance();
//            $CI->load->library('image_lib');
//            $CI->image_lib->clear();
//            $config['image_library'] = 'gd2';
//            $config['source_image'] = $old_path;
//            $config['new_image'] = $new_path;
//            $config['width'] = $width;
//            $config['height'] = $height;
//
//            $CI->image_lib->initialize($config);
//            if (!$CI->image_lib->resize()) {
//                return FALSE;
//            }
//        }

        return image_url($new_image);
    }

    protected static function createFolder($thumb_path = FALSE)
    {
        $oldumask = umask(0);

        if ($thumb_path AND !file_exists($thumb_path)) {
            mkdir($thumb_path, 0777, TRUE);
        }

        umask($oldumask);
    }
}