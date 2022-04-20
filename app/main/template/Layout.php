<?php

namespace Main\Template;

/**
 * Layout Template Class
 */
class Layout extends Model
{
    /**
     * @var string The directory name associated with the model, eg: pages.
     */
    protected $dirName = '_layouts';

    public $controller;

    public static function initFallback($theme)
    {
        $model = self::inTheme($theme);
        $model->markup = '<?= page(); ?>';
        $model->fileName = 'default';

        return $model;
    }

    /**
     * Returns name of a PHP class to use as parent
     * for the PHP class created for the template's PHP section.
     * @return mixed Returns the class name or null.
     */
    public function getCodeClassParent()
    {
        return '\Main\Template\Code\LayoutCode';
    }
}
