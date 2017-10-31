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

    public function getVisibleNavItems()
    {
        $navItems = [];
        foreach ($this->getNavItems() as $code => $navItem) {
            if ($this->filterPermittedNavItem($navItem) === FALSE)
                continue;

            $navItems[$code] = $navItem;
        }

        foreach ($navItems as $key => $navItem) {
            $sort_array[$key] = isset($navItem['priority'])
                ? $navItem['priority'] : 9999999;
        }

        array_multisort($sort_array, SORT_ASC, $navItems);

        return $navItems;
    }

    public function isActiveNavItem($code)
    {
        if ($code == self::$navContextParentCode)
            return true;

        if ($code == self::$navContextItemCode)
            return true;

        return false;
    }

    public function getMainItems()
    {
        if (!self::$mainItems)
            $this->loadItems();

        return self::$mainItems;
    }

    public function render($partial)
    {
        $navItems = $this->getVisibleNavItems();

        $this->partialPath[] = '~/app/admin/views/_partials/';

        return $this->makePartial($partial, [
            'navItems' => $navItems
        ]);
    }

    public function addNavItem($itemCode, $options = [], $parentCode = null)
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

    protected function filterPermittedNavItem($menu)
    {
        $permissions = array_get($menu, 'child', []) ?: [$menu];

        $collection = collect($permissions)->pluck('permission')->toArray();

        $filtered = [];
        foreach ($collection as $permission) {
            if (strpos($permission, '|') !== FALSE) {
                $results = explode('|', $permission);
            } else {
                $results = [$permission];
            }

            $filtered = array_merge($filtered, $results);
        }

        foreach ($filtered as $permission) {
            $permissionName = (count(explode('.', $permission)) > 1)
                ? $permission
                : $permission.'.Access';

            if (!AdminAuth::hasPermission($permissionName))
                return FALSE;
        }

        return TRUE;
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

            if (count($navItem['child'])) {
                $this->registerNavItems($navItem['child'], $navItem['code']);
            }

            $this->registerNavItem($navItem['code'], $navItem, $parent);
        }
    }

    public function registerNavItem($code, $item, $parent = null)
    {
        if (!is_null($parent)) {
            $this->navItems[$parent]['child'][$code] = $item;
        } else {
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
