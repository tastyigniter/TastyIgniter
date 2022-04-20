<?php

namespace Main\Traits;

use Main\Template\Page;
use System\Models\Pages_model;

trait UsesPage
{
    protected static $staticPagesCache = [];

    protected static $staticPageOptionsCache;

    protected static $themePageOptionsCache;

    public function findStaticPage($id)
    {
        if (isset(self::$staticPagesCache[$id]))
            return self::$staticPagesCache[$id];

        return self::$staticPagesCache[$id] = Pages_model::find($id);
    }

    public function getStaticPagePermalink($id)
    {
        $page = $this->findStaticPage($id);

        return $page ? $page->permalink_slug : '';
    }

    public static function getThemePageOptions()
    {
        if (self::$themePageOptionsCache)
            return self::$themePageOptionsCache;

        return self::$themePageOptionsCache = Page::getDropdownOptions();
    }

    public static function getStaticPageOptions()
    {
        if (self::$staticPageOptionsCache)
            return self::$staticPageOptionsCache;

        return self::$staticPageOptionsCache = Pages_model::getDropdownOptions();
    }
}
