<?php namespace Admin\Classes;

use AdminAuth;
use Igniter\Flame\Traits\Singleton;
use System\Classes\BaseExtension;
use System\Classes\ExtensionManager;

class Navigation
{
    use Singleton;

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

    public function getMainItems()
    {
        if (!self::$mainItems)
            $this->loadItems();

        return self::$mainItems;
    }

    public function render($prefs = [])
    {
        $openTag = '<ul class="nav" id="side-menu">';
        $closeTag = '</ul>';

        extract($prefs);

        $navItems = $this->getNavItems();

        return $openTag.$this->_buildNav($navItems).$closeTag;
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

    protected function _buildNav($nav_menu = [], $has_child = 0)
    {
        $levels = ['', 'nav-second-level', 'nav-third-level'];

        foreach ($nav_menu as $key => $value) {
            $sort_array[$key] = isset($value['priority']) ? $value['priority'] : '1111';
        }

        array_multisort($sort_array, SORT_ASC, $nav_menu);

        $out = '';
        foreach ($nav_menu as $code => $menu) {

            if ($this->filterPermittedNavItem($menu) === FALSE) continue;

            $class = null;
            var_dump($has_child, self::$navContextParentCode, self::$navContextItemCode);
            if (!$has_child AND $code == self::$navContextParentCode) {
                $class = ' class="active"';
            }
            else if ($has_child AND $code == self::$navContextItemCode) {
                $class = ' class="active"';
            }

            $out .= '<li'.$class.'>'.$this->_buildNavLink($menu);

            if (isset($menu['child'])) {
                $has_child += 1;

                $child_links = $this->_buildNav($menu['child'], $has_child);
                $out .= '<ul class="nav '.$levels[$has_child].'">'.$child_links.'</ul>';

                $has_child = 0;
            }

            $out .= '</li>';
        }

        return $out;
    }

    protected function _buildNavLink($menu_link = [])
    {
        $out = '<a';
        $out .= ' class="'.$menu_link['class'].'"';

        if (isset($menu_link['href']))
            $out .= ' href="'.$menu_link['href'].'"';

        $out .= '>';
        if (isset($menu_link['icon'])) {
            $out .= '<i class="fa '.$menu_link['icon'].' fa-fw"></i>';
        }
        else {
            $out .= '<i class="fa fa-square-o fa-fw"></i>';
        }

        if (isset($menu_link['icon']) AND isset($menu_link['title'])) {
            $out .= '<span class="content">'.$menu_link['title'].'</span>';
        }
        else {
            $out .= $menu_link['title'];
        }

        if (isset($menu_link['child'])) {
            $out .= '<span class="fa arrow"></span>';
        }

        $out .= '</a>';

        return $out;
    }

    protected function filterPermittedNavItem($menu)
    {
        if (empty($menu['permission']))
            return null;

        $permissions = $menu['permission'];
        if (is_string($permissions)) {
            $permissions = strpos($permissions, '|') !== FALSE
                ? explode('|', $permissions) : [$permissions];
        }

        foreach ($permissions as $permission) {
            if (!AdminAuth::hasPermission($permission.'.Access'))
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

            if (is_null($parent))
                $this->navItems[$navItem['code']] = $navItem;

            if (count($navItem['child']))
                $this->registerNavItems($navItem['child'], $navItem['code']);

            if (!is_null($parent)) {
                $this->navItems[$parent]['child'][$navItem['code']] = $navItem;
            }
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
