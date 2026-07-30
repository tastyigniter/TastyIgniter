<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

/**
 * @property string|null $gam
 */
class Gamma extends BaseManipulator
{
    /**
     * Perform gamma image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        $gamma = $this->getGamma();

        if ($gamma) {
            $image->gamma($gamma);
        }

        return $image;
    }

    /**
     * Resolve gamma amount.
     *
     * @return float|null The resolved gamma amount.
     */
    public function getGamma()
    {
        if (null === $this->gam || !preg_match('/^[0-9]\.*[0-9]*$/', $this->gam)) {
            return;
        }

        if ($this->gam < 0.1 or $this->gam > 9.99) {
            return;
        }

        return (float) $this->gam;
    }
}
