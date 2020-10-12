<?php

namespace Main\Template;

class Partial extends Model
{
    /**
     * @var string The directory name associated with the model
     */
    protected $dirName = '_partials';

    public $settings = [];

    /**
     * Returns name of a PHP class to use as parent
     * for the PHP class created for the template's PHP section.
     *
     * @return mixed Returns the class name or null.
     */
    public function getCodeClassParent()
    {
        return '\Main\Template\Code\PartialCode';
    }
}
