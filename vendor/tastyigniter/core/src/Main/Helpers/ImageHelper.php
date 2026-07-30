<?php

declare(strict_types=1);

namespace Igniter\Main\Helpers;

use Igniter\Main\Classes\MediaLibrary;

class ImageHelper
{
    public static function resize(string $path, int|array $width = 0, int $height = 0): string
    {
        $options = array_merge([
            'width' => is_array($width) ? 0 : $width,
            'height' => $height,
        ], is_array($width) ? $width : []);

        $rootFolder = config('igniter-system.assets.media.folder', 'data').'/';
        if (starts_with($path, $rootFolder)) {
            $path = substr($path, strlen($rootFolder));
        }

        return resolve(MediaLibrary::class)->getMediaThumb($path, $options);
    }
}
