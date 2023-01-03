<?php

namespace Main\Template;

use Main\Classes\MainController;
use Main\Classes\Theme;
use Main\Classes\ThemeManager;

/**
 * Page Template Class
 */
class Page extends Model
{
    /**
     * @var string The directory name associated with the model, eg: _pages.
     */
    protected $dirName = '_pages';

    /**
     * Helper that makes a URL for a page in the active theme.
     * @param $page
     * @param array $params
     * @return string
     */
    public static function url($page, array $params = [])
    {
        $controller = MainController::getController() ?: new MainController;

        return $controller->pageUrl($page, $params);
    }

    /**
     * Handler for the pages.menuitem.getTypeInfo event.
     * @param string $type
     * @return array|void
     */
    public static function getMenuTypeInfo(string $type)
    {
        if ($type !== 'theme-page')
            return;

        $theme = ThemeManager::instance()->getActiveTheme();
        $references = self::getDropdownOptions($theme, true);

        return [
            'references' => $references,
        ];
    }

    /**
     * Handler for the pages.menuitem.resolveItem event.
     * @param $item
     * @param string $url
     * @param \Main\Classes\Theme $theme
     * @return array|void
     */
    public static function resolveMenuItem($item, string $url, Theme $theme)
    {
        if (!$item->reference)
            return;

        $controller = MainController::getController() ?: new MainController;
        $pageUrl = $controller->pageUrl($item->reference, [], false);

        return [
            'url' => $pageUrl,
            'isActive' => $pageUrl == $url,
        ];
    }

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
