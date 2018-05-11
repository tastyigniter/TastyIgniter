<?php namespace Admin\Classes;

use AdminAuth;
use Igniter\Flame\Traits\Singleton;
use System\Classes\BaseExtension;
use System\Classes\ExtensionManager;
use System\Traits\ViewMaker;

class Navigation
{
    use Singleton;
    use ViewMaker;

    protected $navItems = [];

    protected static $mainItems;

    protected static $navItemsLoaded = FALSE;

    protected static $navContextItemCode;

    protected static $navContextParentCode;

    protected static $callbacks = [];

    public function setContext($itemCode, $parentCode = null)
    {
        self::$navContextItemCode = $itemCode;
        self::$navContextParentCode = is_null($parentCode) ? $itemCode : $parentCode;
    }

    public function getNavItems()
    {
        if (!$this->navItems)
            $this->loadItems();

        return $this->navItems;
    }

    public function isCollapsed()
    {
        return array_get($_COOKIE, 'ti_sidebarToggleState') == 'collapsed';
    }

    public function getVisibleNavItems()
    {
        uasort($this->navItems, function ($a, $b) {
            return $a['priority'] - $b['priority'];
        });

        $this->navItems = $this->filterPermittedNavItems($this->navItems);

        foreach ($this->navItems as $code => &$navItem) {
            if (!isset($navItem['child']) OR !count($navItem['child'])) {
                continue;
            }

            uasort($navItem['child'], function ($a, $b) {
                return $a['priority'] - $b['priority'];
            });

            $navItem['child'] = $this->filterPermittedNavItems($navItem['child']);
        }

        return $this->navItems;
    }

    public function isActiveNavItem($code)
    {
        if ($code == self::$navContextParentCode)
            return TRUE;

        if ($code == self::$navContextItemCode)
            return TRUE;

        return FALSE;
    }

    public function getMainItems()
    {
        if (!self::$mainItems)
            $this->loadItems();

        return $this->filterPermittedNavItems(self::$mainItems);
    }

    public function render($partial)
    {
        $this->partialPath[] = '~/app/admin/views/_partials/';

        $navItems = $this->getVisibleNavItems();

        return $this->makePartial($partial, [
            'navItems' => $navItems,
        ]);
    }

    public function addNavItem($itemCode, array $options = [], $parentCode = null)
    {
        if (!is_null($parentCode)) {
            $this->navItems[$parentCode]['child'][$itemCode] = $options;
        }
        else {
            $this->navItems[$itemCode] = $options;
        }
    }

    public function removeNavItem($itemCode, $parentCode = null)
    {
        if (!is_null($parentCode)) {
            unset($this->navItems[$parentCode]['child'][$itemCode]);
        }
        else {
            unset($this->navItems[$itemCode]);
        }
    }

    public function loadItems()
    {
        if (self::$navItemsLoaded)
            return;

        if (!AdminAuth::check())
            return;

        // Load app items
        foreach (self::$callbacks as $callback) {
            $callback($this);
        }

        // Load extension items
        $extensions = ExtensionManager::instance()->getExtensions();
        foreach ($extensions as $code => $extension) {
            if (!$extension instanceof BaseExtension)
                continue;

            $items = $extension->registerNavigation();
            if (!is_array($items))
                continue;

            $this->registerNavItems($items);
        }

        self::$navItemsLoaded = TRUE;
    }

    public function filterPermittedNavItems($items)
    {
        return collect($items)->filter(function ($item) {
            if (!$permission = array_get($item, 'permission'))
                return TRUE;

            return AdminAuth::user()->hasPermission($permission);
        })->toArray();
    }

    //
    // Registration
    //

    public function registerMainItems($definitions = null)
    {
        if (!static::$mainItems) {
            static::$mainItems = [];
        }

        foreach ($definitions as $name => $definition) {
            static::$mainItems[$name] = $definition;
        }
    }

    public function registerNavItems($definitions = null, $parent = null)
    {
        $navItemDefaults = $navItemDefaults = [
            'class'      => null,
            'href'       => null,
            'icon'       => null,
            'title'      => null,
            'child'      => null,
            'priority'   => 500,
            'permission' => null,
        ];

        if (!$this->navItems) {
            $this->navItems = [];
        }

        foreach ($definitions as $name => $definition) {
            $navItem = array_merge($navItemDefaults, array_merge($definition, [
                'code' => $name,
            ]));

            if ($navItem['child']) && count($navItem['child'])) {
                $this->registerNavItems($navItem['child'], $navItem['code']);
            }

            if (array_except($definition, 'child')) {
                $this->addNavItem($navItem['code'], $navItem, $parent);
            }
        }
    }

    public function registerNavItem($code, $item, $parent = null)
    {
        if (!is_null($parent)) {
            $this->navItems[$parent]['child'][$code] = $item;
        }
        else {
            $this->navItems[$code] = $item;
        }
    }

    /**
     * Registers a callback function that defines navigation items.
     * The callback function should register permissions by calling the manager's
     * registerNavItems() function. The manager instance is passed to the
     * callback function as an argument. Usage:
     * <pre>
     *   Template::registerCallback(function($manager){
     *       $manager->registerNavItems([...]);
     *   });
     * </pre>
     *
     * @param callable $callback A callable function.
     */
    public static function registerCallback(callable $callback)
    {
        static::$callbacks[] = $callback;
    }
}
