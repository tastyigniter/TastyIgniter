<?php

declare(strict_types=1);

namespace Igniter\Main\Traits;

use Igniter\Main\Template\Page;
use Igniter\System\Models\Page as PageModel;

trait UsesPage
{
    protected static array $staticPagesCache = [];

    protected static ?array $staticPageOptionsCache = null;

    protected static ?array $themePageOptionsCache = null;

    public function findStaticPage($id): ?PageModel
    {
        return self::$staticPagesCache[$id] ?? (self::$staticPagesCache[$id] = PageModel::find($id));
    }

    public function getStaticPagePermalink($id): string
    {
        $page = $this->findStaticPage($id);

        return $page->permalink_slug ?? '';
    }

    public static function getThemePageOptions(): array
    {
        if (!is_null(self::$themePageOptionsCache)) {
            return self::$themePageOptionsCache;
        }

        return self::$themePageOptionsCache = Page::getDropdownOptions();
    }

    public static function getStaticPageOptions(): array
    {
        if (!is_null(self::$staticPageOptionsCache)) {
            return self::$staticPageOptionsCache;
        }

        return self::$staticPageOptionsCache = PageModel::getDropdownOptions()->all();
    }
}
