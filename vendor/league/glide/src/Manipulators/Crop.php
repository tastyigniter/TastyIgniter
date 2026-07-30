<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;

/**
 * @property string|null $crop
 */
class Crop extends BaseManipulator
{
    /**
     * Perform crop image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        $coordinates = $this->getCoordinates($image);

        if ($coordinates) {
            $coordinates = $this->limitToImageBoundaries($image, $coordinates);

            $image->crop(
                $coordinates[0],
                $coordinates[1],
                $coordinates[2],
                $coordinates[3]
            );
        }

        return $image;
    }

    /**
     * Resolve coordinates.
     *
     * @param Image $image The source image.
     *
     * @return int[]|null The resolved coordinates.
     *
     * @psalm-return array{0: int, 1: int, 2: int, 3: int}|null
     */
    public function getCoordinates(Image $image)
    {
        if (null === $this->crop) {
            return;
        }

        $coordinates = explode(',', $this->crop);

        if (4 !== count($coordinates) or
            (!is_numeric($coordinates[0])) or
            (!is_numeric($coordinates[1])) or
            (!is_numeric($coordinates[2])) or
            (!is_numeric($coordinates[3])) or
            ($coordinates[0] <= 0) or
            ($coordinates[1] <= 0) or
            ($coordinates[2] < 0) or
            ($coordinates[3] < 0) or
            ($coordinates[2] >= $image->width()) or
            ($coordinates[3] >= $image->height())) {
            return;
        }

        return [
            (int) $coordinates[0],
            (int) $coordinates[1],
            (int) $coordinates[2],
            (int) $coordinates[3],
        ];
    }

    /**
     * Limit coordinates to image boundaries.
     *
     * @param Image $image       The source image.
     * @param int[] $coordinates The coordinates.
     *
     * @return int[] The limited coordinates.
     */
    public function limitToImageBoundaries(Image $image, array $coordinates)
    {
        if ($coordinates[0] > ($image->width() - $coordinates[2])) {
            $coordinates[0] = $image->width() - $coordinates[2];
        }

        if ($coordinates[1] > ($image->height() - $coordinates[3])) {
            $coordinates[1] = $image->height() - $coordinates[3];
        }

        return $coordinates;
    }
}
