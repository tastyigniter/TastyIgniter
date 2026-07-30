<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

interface ManipulatorInterface
{
    /**
     * Set the manipulation params.
     *
     * @param array $params The manipulation params.
     */
    public function setParams(array $params);

    /**
     * Perform the image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image);
}
