<?php

namespace League\Glide\Api;

use Intervention\Image\ImageManager;
use InvalidArgumentException;
use League\Glide\Manipulators\ManipulatorInterface;

class Api implements ApiInterface
{
    /**
     * Intervention image manager.
     *
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * Collection of manipulators.
     *
     * @var array
     */
    protected $manipulators;

    /**
     * Create API instance.
     *
     * @param ImageManager $imageManager Intervention image manager.
     * @param array        $manipulators Collection of manipulators.
     */
    public function __construct(ImageManager $imageManager, array $manipulators)
    {
        $this->setImageManager($imageManager);
        $this->setManipulators($manipulators);
    }

    /**
     * Set the image manager.
     *
     * @param ImageManager $imageManager Intervention image manager.
     *
     * @return void
     */
    public function setImageManager(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * Get the image manager.
     *
     * @return ImageManager Intervention image manager.
     */
    public function getImageManager()
    {
        return $this->imageManager;
    }

    /**
     * Set the manipulators.
     *
     * @param array $manipulators Collection of manipulators.
     *
     * @return void
     */
    public function setManipulators(array $manipulators)
    {
        foreach ($manipulators as $manipulator) {
            if (!($manipulator instanceof ManipulatorInterface)) {
                throw new InvalidArgumentException('Not a valid manipulator.');
            }
        }

        $this->manipulators = $manipulators;
    }

    /**
     * Get the manipulators.
     *
     * @return array Collection of manipulators.
     */
    public function getManipulators()
    {
        return $this->manipulators;
    }

    /**
     * Perform image manipulations.
     *
     * @param string $source Source image binary data.
     * @param array  $params The manipulation params.
     *
     * @return string Manipulated image binary data.
     */
    public function run($source, array $params)
    {
        $image = $this->imageManager->make($source);

        foreach ($this->manipulators as $manipulator) {
            $manipulator->setParams($params);

            $image = $manipulator->run($image);
        }

        return $image->getEncoded();
    }
}
