<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

/**
 * @property string $blur
 */
class Blur extends BaseManipulator
{
    /**
     * Perform blur image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        $blur = $this->getBlur();

        if (null !== $blur) {
            $image->blur($blur);
        }

        return $image;
    }

    /**
     * Resolve blur amount.
     *
     * @return int|null The resolved blur amount.
     */
    public function getBlur()
    {
        if (!is_numeric($this->blur)) {
            return;
        }

        if ($this->blur < 0 or $this->blur > 100) {
            return;
        }

        return (int) $this->blur;
    }
}
