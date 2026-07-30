<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;
use League\Glide\Manipulators\Helpers\Color;
use League\Glide\Manipulators\Helpers\Dimension;

/**
 * @property string $border
 * @property string $dpr
 */
class Border extends BaseManipulator
{
    /**
     * Perform border image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        if ($border = $this->getBorder($image)) {
            list($width, $color, $method) = $border;

            if ('overlay' === $method) {
                return $this->runOverlay($image, $width, $color);
            }

            if ('shrink' === $method) {
                return $this->runShrink($image, $width, $color);
            }

            if ('expand' === $method) {
                return $this->runExpand($image, $width, $color);
            }
        }

        return $image;
    }

    /**
     * Resolve border amount.
     *
     * @param Image $image The source image.
     *
     * @return (float|string)[]|null The resolved border amount.
     *
     * @psalm-return array{0: float, 1: string, 2: string}|null
     */
    public function getBorder(Image $image)
    {
        if (!$this->border) {
            return;
        }

        $values = explode(',', $this->border);

        $width = $this->getWidth($image, $this->getDpr(), isset($values[0]) ? $values[0] : null);
        $color = $this->getColor(isset($values[1]) ? $values[1] : null);
        $method = $this->getMethod(isset($values[2]) ? $values[2] : null);

        if ($width) {
            return [$width, $color, $method];
        }
    }

    /**
     * Get border width.
     *
     * @param Image  $image The source image.
     * @param float  $dpr   The device pixel ratio.
     * @param string $width The border width.
     *
     * @return float|null The resolved border width.
     */
    public function getWidth(Image $image, $dpr, $width)
    {
        return (new Dimension($image, $dpr))->get($width);
    }

    /**
     * Get formatted color.
     *
     * @param string $color The color.
     *
     * @return string The formatted color.
     */
    public function getColor($color)
    {
        return (new Color($color))->formatted();
    }

    /**
     * Resolve the border method.
     *
     * @param string $method The raw border method.
     *
     * @return string The resolved border method.
     */
    public function getMethod($method)
    {
        if (!in_array($method, ['expand', 'shrink', 'overlay'], true)) {
            return 'overlay';
        }

        return $method;
    }

    /**
     * Resolve the device pixel ratio.
     *
     * @return float The device pixel ratio.
     */
    public function getDpr()
    {
        if (!is_numeric($this->dpr)) {
            return 1.0;
        }

        if ($this->dpr < 0 or $this->dpr > 8) {
            return 1.0;
        }

        return (float) $this->dpr;
    }

    /**
     * Run the overlay border method.
     *
     * @param Image  $image The source image.
     * @param float  $width The border width.
     * @param string $color The border color.
     *
     * @return Image The manipulated image.
     */
    public function runOverlay(Image $image, $width, $color)
    {
        return $image->rectangle(
            (int) round($width / 2),
            (int) round($width / 2),
            (int) round($image->width() - ($width / 2)),
            (int) round($image->height() - ($width / 2)),
            function ($draw) use ($width, $color) {
                $draw->border($width, $color);
            }
        );
    }

    /**
     * Run the shrink border method.
     *
     * @param Image  $image The source image.
     * @param float  $width The border width.
     * @param string $color The border color.
     *
     * @return Image The manipulated image.
     */
    public function runShrink(Image $image, $width, $color)
    {
        return $image
            ->resize(
                (int) round($image->width() - ($width * 2)),
                (int) round($image->height() - ($width * 2))
            )
            ->resizeCanvas(
                (int) round($width * 2),
                (int) round($width * 2),
                'center',
                true,
                $color
            );
    }

    /**
     * Run the expand border method.
     *
     * @param Image  $image The source image.
     * @param float  $width The border width.
     * @param string $color The border color.
     *
     * @return Image The manipulated image.
     */
    public function runExpand(Image $image, $width, $color)
    {
        return $image->resizeCanvas(
            (int) round($width * 2),
            (int) round($width * 2),
            'center',
            true,
            $color
        );
    }
}
