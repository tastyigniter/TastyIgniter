<?php

namespace League\Glide\Manipulators\Helpers;

use Intervention\Image\Image;

class Dimension
{
    /**
     * The source image.
     *
     * @var Image
     */
    protected $image;

    /**
     * The device pixel ratio.
     *
     * @var float
     */
    protected $dpr;

    /**
     * Create dimension helper instance.
     *
     * @param Image $image The source image.
     * @param float $dpr   The device pixel ratio.
     */
    public function __construct(Image $image, $dpr = 1)
    {
        $this->image = $image;
        $this->dpr = $dpr;
    }

    /**
     * Resolve the dimension.
     *
     * @param string $value The dimension value.
     *
     * @return float|null The resolved dimension.
     */
    public function get($value)
    {
        if (is_numeric($value) and $value > 0) {
            return (float) $value * $this->dpr;
        }

        if (preg_match('/^(\d{1,2}(?!\d)|100)(w|h)$/', $value, $matches)) {
            if ('h' === $matches[2]) {
                return (float) $this->image->height() * ((float) $matches[1] / 100);
            }

            return (float) $this->image->width() * ((float) $matches[1] / 100);
        }
    }
}
