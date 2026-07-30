<?php

declare(strict_types=1);

namespace Igniter\Main\Template;

use Igniter\Flame\Pagic\Model;
use Igniter\Main\Classes\MainController;
use Igniter\Main\Classes\Theme;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Template\Code\PageCode;
use Igniter\Main\Template\Concerns\HasComponents;
use Igniter\Main\Template\Concerns\HasViewBag;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Page Template Class
 *
 * @property string $title
 * @property string $permalink
 * @property string $layout
 * @property bool $isHidden
 */
class Page extends Model
{
    use HasComponents;
    use HasViewBag;

    /** The directory name associated with the model, eg: _pages. */
    public const string DIR_NAME = '_pages';

    /**
     * Helper that makes a URL for a page in the active theme.
     */
    public static function url(string $page, array $params = []): string
    {
        $controller = MainController::getController();

        return $controller->pageUrl($page, $params);
    }

    /**
     * Handler for the pages.menuitem.getTypeInfo event.
     */
    public static function getMenuTypeInfo(string $type): ?array
    {
        if ($type !== 'theme-page') {
            return null;
        }

        if (!$themeCode = resolve(ThemeManager::class)->getActiveThemeCode()) {
            return null;
        }

        $references = self::getDropdownOptions($themeCode);

        return [
            'references' => $references,
        ];
    }

    /**
     * Handler for the pages.menuitem.resolveItem event.
     */
    public static function resolveMenuItem(mixed $item, string $url, Theme $theme): ?array
    {
        if (!$item->reference) {
            return null;
        }

        $controller = MainController::getController();
        $pageUrl = $controller->pageUrl($item->reference);

        return [
            'url' => $pageUrl,
            'isActive' => $pageUrl === $url,
        ];
    }

    /**
     * Returns name of a PHP class to use as parent
     * for the PHP class created for the template's PHP section.
     */
    public function getCodeClassParent(): string
    {
        return PageCode::class;
    }

    public static function resolveRouteBinding(string $value, ?string $field = null): mixed
    {
        if (($page = event('main.page.beforeRoute', [$value, $field], true)) !== null) {
            return $page;
        }

        /** @var Page $page */
        $page = self::query()->find($value);

        // @phpstan-ignore-next-line
        throw_unless($page, (new ModelNotFoundException)->setModel(self::class));

        // @phpstan-ignore-next-line
        throw_if($page->isHidden && !AdminAuth::check(), (new ModelNotFoundException)->setModel(self::class));

        return $page;
    }
}
