<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

/**
 * @property string|null $bri
 */
class Brightness extends BaseManipulator
{
    /**
     * Perform brightness image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        $brightness = $this->getBrightness();

        if (null !== $brightness) {
            $image->brightness($brightness);
        }

        return $image;
    }

    /**
     * Resolve brightness amount.
     *
     * @return int|null The resolved brightness amount.
     */
    public function getBrightness()
    {
        if (null === $this->bri || !preg_match('/^-*[0-9]+$/', $this->bri)) {
            return;
        }

        if ($this->bri < -100 or $this->bri > 100) {
            return;
        }

        return (int) $this->bri;
    }
}
