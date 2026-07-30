<?php

namespace League\Glide\Manipulators;

use Intervention\Image\Image;
use League\Flysystem\FilesystemException as FilesystemV2Exception;
use League\Flysystem\FilesystemOperator;
use League\Glide\Filesystem\FilesystemException;
use League\Glide\Manipulators\Helpers\Dimension;

/**
 * @property string $dpr
 * @property string $mark
 * @property string $markfit
 * @property string $markh
 * @property string $markpad
 * @property string $markpos
 * @property string $markw
 * @property string $markx
 * @property string $marky
 * @property string $markalpha
 */
class Watermark extends BaseManipulator
{
    /**
     * The watermarks file system.
     *
     * @var FilesystemOperator|null
     */
    protected $watermarks;

    /**
     * The watermarks path prefix.
     *
     * @var string
     */
    protected $watermarksPathPrefix;

    /**
     * Create Watermark instance.
     *
     * @param FilesystemOperator $watermarks The watermarks file system.
     */
    public function __construct(?FilesystemOperator $watermarks = null, $watermarksPathPrefix = '')
    {
        $this->setWatermarks($watermarks);
        $this->setWatermarksPathPrefix($watermarksPathPrefix);
    }

    /**
     * Set the watermarks file system.
     *
     * @param FilesystemOperator $watermarks The watermarks file system.
     *
     * @return void
     */
    public function setWatermarks(?FilesystemOperator $watermarks = null)
    {
        $this->watermarks = $watermarks;
    }

    /**
     * Get the watermarks file system.
     *
     * @return FilesystemOperator|null The watermarks file system.
     */
    public function getWatermarks()
    {
        return $this->watermarks;
    }

    /**
     * Set the watermarks path prefix.
     *
     * @param string $watermarksPathPrefix The watermarks path prefix.
     *
     * @return void
     */
    public function setWatermarksPathPrefix($watermarksPathPrefix = '')
    {
        $this->watermarksPathPrefix = trim($watermarksPathPrefix, '/');
    }

    /**
     * Get the watermarks path prefix.
     *
     * @return string The watermarks path prefix.
     */
    public function getWatermarksPathPrefix()
    {
        return $this->watermarksPathPrefix;
    }

    /**
     * Perform watermark image manipulation.
     *
     * @param Image $image The source image.
     *
     * @return Image The manipulated image.
     */
    public function run(Image $image)
    {
        if ($watermark = $this->getImage($image)) {
            $markw = $this->getDimension($image, 'markw');
            $markh = $this->getDimension($image, 'markh');
            $markx = $this->getDimension($image, 'markx');
            $marky = $this->getDimension($image, 'marky');
            $markpad = $this->getDimension($image, 'markpad');
            $markfit = $this->getFit();
            $markpos = $this->getPosition();
            $markalpha = $this->getAlpha();

            if ($markpad) {
                $markx = $marky = $markpad;
            }

            $size = new Size();
            $size->setParams([
                'w' => $markw,
                'h' => $markh,
                'fit' => $markfit,
            ]);
            $watermark = $size->run($watermark);

            if ($markalpha < 100) {
                $watermark->opacity($markalpha);
            }

            $image->insert($watermark, $markpos, intval($markx), intval($marky));
        }

        return $image;
    }

    /**
     * Get the watermark image.
     *
     * @param Image $image The source image.
     *
     * @return Image|null The watermark image.
     */
    public function getImage(Image $image)
    {
        if (is_null($this->watermarks)) {
            return;
        }

        if (!is_string($this->mark)) {
            return;
        }

        if ('' === $this->mark) {
            return;
        }

        $path = $this->mark;

        if ($this->watermarksPathPrefix) {
            $path = $this->watermarksPathPrefix.'/'.$path;
        }

        try {
            if ($this->watermarks->fileExists($path)) {
                $source = $this->watermarks->read($path);

                return $image->getDriver()->init($source);
            }
        } catch (FilesystemV2Exception $exception) {
            throw new FilesystemException('Could not read the image `'.$path.'`.');
        }
    }

    /**
     * Get a dimension.
     *
     * @param Image  $image The source image.
     * @param string $field The requested field.
     *
     * @return float|null The dimension.
     */
    public function getDimension(Image $image, $field)
    {
        if ($this->{$field}) {
            return (new Dimension($image, $this->getDpr()))->get($this->{$field});
        }
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
     * Get the fit.
     *
     * @return string|null The fit.
     */
    public function getFit()
    {
        $fitMethods = [
            'contain',
            'max',
            'stretch',
            'crop',
            'crop-top-left',
            'crop-top',
            'crop-top-right',
            'crop-left',
            'crop-center',
            'crop-right',
            'crop-bottom-left',
            'crop-bottom',
            'crop-bottom-right',
        ];

        if (in_array($this->markfit, $fitMethods, true)) {
            return $this->markfit;
        }
    }

    /**
     * Get the position.
     *
     * @return string The position.
     */
    public function getPosition()
    {
        $positions = [
            'top-left',
            'top',
            'top-right',
            'left',
            'center',
            'right',
            'bottom-left',
            'bottom',
            'bottom-right',
        ];

        if (in_array($this->markpos, $positions, true)) {
            return $this->markpos;
        }

        return 'bottom-right';
    }

    /**
     * Get the alpha channel.
     *
     * @return int The alpha.
     */
    public function getAlpha()
    {
        if (!is_numeric($this->markalpha)) {
            return 100;
        }

        if ($this->markalpha < 0 or $this->markalpha > 100) {
            return 100;
        }

        return (int) $this->markalpha;
    }
}
