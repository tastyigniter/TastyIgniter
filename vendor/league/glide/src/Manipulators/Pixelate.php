<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

/**
 * @property string $pixel
 */
class Pixelate extends BaseManipulator
{
    /**
     * Perform pixelate image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        $pixelate = $this->getPixelate();

        if (null !== $pixelate) {
            $image->pixelate($pixelate);
        }

        return $image;
    }

    /**
     * Resolve pixelate amount.
     *
     * @return int|null The resolved pixelate amount.
     */
    public function getPixelate()
    {
        if (!is_numeric($this->pixel)) {
            return;
        }

        if ($this->pixel < 0 or $this->pixel > 1000) {
            return;
        }

        return (int) $this->pixel;
    }
}
