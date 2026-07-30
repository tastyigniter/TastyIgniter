<?php

declare(strict_types=1);

namespace Igniter\Pages\Classes;

use Igniter\Main\Models\Theme;
use Igniter\Pages\Models\Menu;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class MenuManager
{
    /**
     * @var array<string, \Igniter\Main\Classes\Theme>
     */
    protected static array $themesCache;

    protected $defaultMenuItem = [
        'code' => null,
        'title' => null,
        'url' => null,
        'isActive' => false,
        'isChildActive' => false,
        'extraAttributes' => false,
        'items' => [],
    ];

    public function getMenusConfig()
    {
        $menus = [];
        $themes = Theme::whereIsEnabled()->get();
        foreach ($themes as $theme) {
            /** @var Theme $theme */
            if (!$themeObj = $theme->getTheme()) {
                continue;
            }

            $metaPath = $themeObj->hasParent() ? $themeObj->getParent()->getMetaPath() : $themeObj->getMetaPath();

            $files = File::glob($metaPath.'/menus/*.php');
            foreach ($files as $file) {
                $config = File::getRequire($file);
                $menus[] = [
                    'code' => basename((string)$file, '.php'),
                    'name' => array_get($config, 'name', '-- no name --'),
                    'themeCode' => $theme->code,
                    'items' => array_get($config, 'items', []),
                ];
            }
        }

        return $menus;
    }

    public function generateReferences(Menu $menu, $pageOrLayout = null)
    {
        $currentUrl = ($currentUrl = Request::path()) === '' ? '/' : $currentUrl;

        $currentUrl = strtolower(URL::to($currentUrl));

        $activeMenuItem = $pageOrLayout->activeMenuItem ?: false;

        $iterator = function($items) use (&$iterator, $currentUrl, $activeMenuItem, $menu): array {
            $result = [];

            foreach ($items as $item) {
                $parentReference = (object)$this->defaultMenuItem;
                $parentReference->code = $item->code;
                $parentReference->title = $item->title;
                $parentReference->extraAttributes = array_get($item->config, 'extraAttributes');

                if ($item->type == 'url') {
                    $parentReference->url = $item->url;
                    $parentReference->isActive = $currentUrl === strtolower(URL::to($item->url)) || $activeMenuItem === $item->code;
                } else {
                    $parentReference = $this->resolveItem(
                        $menu, $item, $parentReference, $currentUrl, $activeMenuItem,
                    );
                }

                if (count($item->children) > 0) {
                    $parentReference->items = $iterator($item->children);
                }

                $result[] = $parentReference;
            }

            return $result;
        };

        $items = $iterator($menu->items()->sorted()->get()->toTree());

        $hasActiveChild = function($items) use (&$hasActiveChild): bool {
            foreach ($items as $item) {
                if ($item->isActive) {
                    return true;
                }

                $result = $hasActiveChild($item->items);
                if ($result) {
                    return $result;
                }
            }

            return false;
        };

        $iterator = function($items) use (&$iterator, &$hasActiveChild): void {
            foreach ($items as $item) {
                $item->isChildActive = $hasActiveChild($item->items);
                $iterator($item->items);
            }
        };

        $iterator($items);

        Event::dispatch('pages.menu.referencesGenerated', [&$items]);

        return $items;
    }

    protected function resolveItem($menu, $item, $parentReference, $currentUrl, $activeMenuItem)
    {
        $theme = $this->getThemeFromMenu($menu);

        $response = Event::dispatch('pages.menuitem.resolveItem', [$item, $currentUrl, $theme]);

        if (is_array($response)) {
            $eventResultItems = [];
            foreach (array_filter($response) as $eventResult) {
                if (!isset($eventResult[0])) {
                    $eventResult = [$eventResult];
                }

                $eventResultItems = array_merge($eventResultItems, $eventResult);
            }

            foreach ($eventResultItems as $itemInfo) {
                if (isset($itemInfo['url'])) {
                    $parentReference->url = $itemInfo['url'];
                    $parentReference->isActive = $itemInfo['isActive'] || $activeMenuItem === $item->code;
                }

                if (isset($itemInfo['items'])) {
                    $itemIterator = function($items) use (&$itemIterator, $parentReference): array {
                        $result = [];
                        foreach ($items as $item) {
                            $reference = (object)$this->defaultMenuItem;
                            $reference->code = array_get($item, 'code');
                            $reference->title = array_get($item, 'title', '-- no title --');
                            $reference->url = array_get($item, 'url', '#');
                            $reference->isActive = array_get($item, 'isActive', false);
                            $reference->extraAttributes = array_get($item, 'extraAttributes');

                            if ((string)$parentReference->url === '') {
                                $parentReference->url = $reference->url;
                                $parentReference->isActive = $reference->isActive;
                            }

                            if (isset($item['items'])) {
                                $reference->items = $itemIterator($item['items']);
                            }

                            $result[] = $reference;
                        }

                        return $result;
                    };

                    $parentReference->items = $itemIterator($itemInfo['items']);
                }
            }
        }

        return $parentReference;
    }

    protected function getThemeFromMenu($menu)
    {
        $code = $menu->theme_code;

        return self::$themesCache[$code] ?? (self::$themesCache[$code] = $menu->theme->getTheme());
    }
}
