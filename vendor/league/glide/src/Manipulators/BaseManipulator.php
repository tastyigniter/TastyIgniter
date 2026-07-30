<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

abstract class BaseManipulator implements ManipulatorInterface
{
    /**
     * The manipulation params.
     *
     * @var array
     */
    public $params = [];

    /**
     * Set the manipulation params.
     *
     * @param array $params The manipulation params.
     *
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Get a specific manipulation param.
     *
     * @param string $name The manipulation name.
     *
     * @return string The manipulation value.
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
    }

    /**
     * Perform the image manipulation.
     *
     * @return Image The manipulated image.
     */
    abstract public function run(Image $image);
}
