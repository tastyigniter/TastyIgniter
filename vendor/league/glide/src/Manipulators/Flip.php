<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

/**
 * @property string $flip
 */
class Flip extends BaseManipulator
{
    /**
     * Perform flip image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        if ($flip = $this->getFlip()) {
            if ('both' === $flip) {
                return $image->flip('h')->flip('v');
            }

            return $image->flip($flip);
        }

        return $image;
    }

    /**
     * Resolve flip.
     *
     * @return string|null The resolved flip.
     */
    public function getFlip()
    {
        if (in_array($this->flip, ['h', 'v', 'both'], true)) {
            return $this->flip;
        }
    }
}
