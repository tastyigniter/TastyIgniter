<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

/**
 * @property string $filt
 */
class Filter extends BaseManipulator
{
    /**
     * Perform filter image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        if ('greyscale' === $this->filt) {
            return $this->runGreyscaleFilter($image);
        }

        if ('sepia' === $this->filt) {
            return $this->runSepiaFilter($image);
        }

        return $image;
    }

    /**
     * Perform greyscale manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function runGreyscaleFilter(Image $image)
    {
        return $image->greyscale();
    }

    /**
     * Perform sepia manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function runSepiaFilter(Image $image)
    {
        $image->greyscale();
        $image->brightness(-10);
        $image->contrast(10);
        $image->colorize(38, 27, 12);
        $image->brightness(-10);
        $image->contrast(10);

        return $image;
    }
}
