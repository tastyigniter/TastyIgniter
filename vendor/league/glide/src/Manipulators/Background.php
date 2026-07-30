<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;
use League\Glide\Manipulators\Helpers\Color;

/**
 * @property string $bg
 */
class Background extends BaseManipulator
{
    /**
     * Perform background image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        if (is_null($this->bg)) {
            return $image;
        }

        $color = (new Color($this->bg))->formatted();

        if ($color) {
            $new = $image->getDriver()->newImage($image->width(), $image->height(), $color);
            $new->mime = $image->mime;
            $image = $new->insert($image, 'top-left', 0, 0);
        }

        return $image;
    }
}
