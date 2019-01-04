<?php namespace Admin\Classes;

use AdminAuth;
use System\Classes\BaseExtension;
use System\Classes\ExtensionManager;
use System\Traits\ViewMaker;

class Navigation
{
    use ViewMaker;

    protected $navItems = [];

    protected $mainItems;

    protected $navItemsLoaded = FALSE;

    protected $navContextItemCode;

    protected $navContextParentCode;

    protected $callbacks = [];

    public function __construct($path = null)
    {
        $this->viewPath[] = $path;
    }

    public function setContext($itemCode, $parentCode = null)
    {
        $this->navContextItemCode = $itemCode;
        $this->navContextParentCode = is_null($parentCode) ? $itemCode : $parentCode;
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
        if ($code == $this->navContextParentCode)
            return TRUE;

        if ($code == $this->navContextItemCode)
            return TRUE;

        return FALSE;
    }

    public function getMainItems()
    {
        if (!$this->mainItems)
            $this->loadItems();

        return $this->filterPermittedNavItems($this->mainItems);
    }

    public function render($partial)
    {
        $navItems = $this->getVisibleNavItems();

        return $this->makePartial($partial, [
            'navItems' => $navItems,
        ]);
    }

    public function addNavItem($itemCode, array $options = [], $parentCode = null)
    {
        $navItemDefaults = [
            'code' => $itemCode,
            'class' => null,
            'href' => null,
            'icon' => null,
            'title' => null,
            'child' => null,
            'priority' => 500,
            'permission' => null,
        ];

        $navItem = array_merge($navItemDefaults, $options);

        if ($parentCode) {
            if (!isset($this->navItems[$parentCode]))
                $this->navItems[$parentCode] = array_merge($navItemDefaults, [
                    'code' => $parentCode,
                    'class' => $parentCode,
                ]);

            $this->navItems[$parentCode]['child'][$itemCode] = $navItem;
        }
        else {
            $this->navItems[$itemCode] = $navItem;
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
        if ($this->navItemsLoaded)
            return;

        if (!AdminAuth::check())
            return;

        // Load app items
        foreach ($this->callbacks as $callback) {
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

        $this->navItemsLoaded = TRUE;
    }

    public function filterPermittedNavItems($items)
    {
        return collect($items)->filter(function ($item) {
            if (!$permission = array_get($item, 'permission'))
                return TRUE;

            if (!is_array($permission))
                $permission = [$permission];

            $permission = array_map(function ($value) {
                $permArray = explode('.', $value);
                $name = array_slice($permArray, 0, 2);
                return implode('.', $name).'.Access';
            }, $permission);

            return AdminAuth::user()->hasPermission($permission);
        })->toArray();
    }

    //
    // Registration
    //

    public function registerMainItems($definitions = null)
    {
        if (!$this->mainItems) {
            $this->mainItems = [];
        }

        foreach ($definitions as $name => $definition) {
            $this->mainItems[$name] = $definition;
        }
    }

    public function registerNavItems($definitions = null, $parent = null)
    {
        if (!$this->navItems) {
            $this->navItems = [];
        }

        foreach ($definitions as $name => $definition) {
            if (isset($definition['child']) AND count($definition['child'])) {
                $this->registerNavItems($definition['child'], $name);
            }

            if (array_except($definition, 'child')) {
                $this->addNavItem($name, $definition, $parent);
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
    public function registerCallback(callable $callback)
    {
        $this->callbacks[] = $callback;
    }
}
