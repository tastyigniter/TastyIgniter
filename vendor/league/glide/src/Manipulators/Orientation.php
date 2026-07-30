<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

/**
 * @property string $or
 */
class Orientation extends BaseManipulator
{
    /**
     * Perform orientation image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        $orientation = $this->getOrientation();

        if ('auto' === $orientation) {
            return $image->orientate();
        }

        return $image->rotate((float) $orientation);
    }

    /**
     * Resolve orientation.
     *
     * @return string The resolved orientation.
     */
    public function getOrientation()
    {
        if (in_array($this->or, ['auto', '0', '90', '180', '270'], true)) {
            return $this->or;
        }

        return 'auto';
    }
}
