<?php

namespace Main\Traits;

/**
 * Trait HasPageOptions
 * @todo remove in v3.1
 */
trait HasPageOptions
{
    use UsesPage;

    public function findPage($id)
    {
        traceLog('Trait method HasPageOptions::findPage($id) is deprecated. Use trait method UsesPage::findStaticPage($id) instead.');

        return $this->findStaticPage($id);
    }

    public function getPageSlug($id)
    {
        traceLog('Trait method HasPageOptions::getPageSlug($id) is deprecated. Use trait method UsesPage::getStaticPagePermalink($id) instead.');

        return $this->getStaticPagePermalink($id);
    }

    public static function getPageOptions()
    {
        traceLog('Trait method HasPageOptions::getPageOptions() is deprecated. Use trait method UsesPage::getThemePageOptions() instead.');

        return self::getThemePageOptions();
    }

    public static function getPagesOptions()
    {
        traceLog('Trait method HasPageOptions::getPagesOptions() is deprecated. Use trait method UsesPage::getStaticPageOptions() instead.');

        return self::getStaticPageOptions();
    }
}
