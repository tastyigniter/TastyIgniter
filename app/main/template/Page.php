<?php namespace Main\Template;

/**
 * Page Template Class
 *
 * @package Main
 */
class Page extends Model
{
    use Concerns\HasComponents;
    use Concerns\HasViewBag;

    /**
     * @var string The directory name associated with the model, eg: _pages.
     */
    protected $dirName = '_pages';

    /**
     * Returns name of a PHP class to use as parent
     * for the PHP class created for the template's PHP section.
     *
     * @return mixed Returns the class name or null.
     */
    public function getCodeClassParent()
    {
        return '\Main\Template\Code\PageCode';
    }
}