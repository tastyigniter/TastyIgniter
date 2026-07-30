<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

/**
 * @property string $fm
 * @property string $q
 */
class Encode extends BaseManipulator
{
    /**
     * Perform output image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        $format = $this->getFormat($image);
        $quality = $this->getQuality();

        if (in_array($format, ['jpg', 'pjpg'], true)) {
            $image = $image->getDriver()
                           ->newImage($image->width(), $image->height(), '#fff')
                           ->insert($image, 'top-left', 0, 0);
        }

        if ('pjpg' === $format) {
            $image->interlace();
            $format = 'jpg';
        }

        return $image->encode($format, $quality);
    }

    /**
     * Resolve format.
     *
     * @param Image $image The source image.
     *
     * @return string The resolved format.
     */
    public function getFormat(Image $image)
    {
        if (array_key_exists($this->fm, static::supportedFormats())) {
            return $this->fm;
        }

        return array_search($image->mime(), static::supportedFormats(), true) ?: 'jpg';
    }

    /**
     * Get a list of supported image formats and MIME types.
     *
     * @return array<string,string>
     */
    public static function supportedFormats()
    {
        return [
            'avif' => 'image/avif',
            'gif' => 'image/gif',
            'jpg' => 'image/jpeg',
            'pjpg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'tiff' => 'image/tiff',
        ];
    }

    /**
     * Resolve quality.
     *
     * @return int The resolved quality.
     */
    public function getQuality()
    {
        $default = 90;

        if (!is_numeric($this->q)) {
            return $default;
        }

        if ($this->q < 0 or $this->q > 100) {
            return $default;
        }

        return (int) $this->q;
    }
}
