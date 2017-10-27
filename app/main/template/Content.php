<?php

namespace Main\Template;

class Content extends Partial
{
    /**
     * @var string The directory name associated with the model
     */
    protected $dirName = '_content';

    /**
     * Loads the template.
     *
     * @param  \Main\Classes\Theme|\System\Classes\BaseComponent $source
     * @param  string $fileName
     *
     * @return mixed
     */
    public static function load($source, $fileName)
    {
        return (new static($source))->find($fileName);
    }

    /**
     * Loads and caches the template.
     *
     * @param  \Main\Classes\Theme|\System\Classes\BaseComponent $source
     * @param  string $fileName
     *
     * @return mixed
     */
    public static function loadCached($source, $fileName)
    {
        return static::load($source, $fileName);
    }
}