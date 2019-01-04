<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Admin\Classes\MenuItem;
use SystemException;

class Menu extends BaseWidget
{
    /**
     * @var array Item definition configuration.
     */
    public $items;

    /**
     * @var string The context of this menu, items that do not belong
     * to this context will not be shown.
     */
    public $context = null;

    protected $defaultAlias = 'top-menu';

    /**
     * @var boolean Determines if item definitions have been created.
     */
    protected $itemsDefined = FALSE;

    /**
     * @var array Collection of all items used in this menu.
     */
    protected $allItems = [];

    /**
     * @var array List of CSS classes to apply to the menu container element
     */
    public $cssClasses = [];

    public function initialize()
    {
        $this->fillFromConfig([
            'items',
            'context',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('menu/top_menu');
    }

    protected function prepareVars()
    {
        $this->defineMenuItems();
        $this->vars['cssClasses'] = implode(' ', $this->cssClasses);
        $this->vars['items'] = $this->getItems();
    }

    public function loadAssets()
    {
        $this->addJs('js/mainmenu.js', 'mainmenu-js');
    }

    /**
     * Renders the HTML element for a item
     *
     * @param $item
     *
     * @return string
     */
    public function renderItemElement($item)
    {
        $params = ['item' => $item];

        return $this->makePartial('menu/item_'.$item->type, $params);
    }

    /**
     * Creates a flat array of menu items from the configuration.
     */
    protected function defineMenuItems()
    {
        if ($this->itemsDefined)
            return;

        if (!isset($this->items) OR !is_array($this->items)) {
            $this->items = [];
        }

        $this->addItems($this->items);

        $this->itemsDefined = TRUE;
    }

    /**
     * Programatically add items, used internally and for extensibility.
     *
     * @param array $items
     */
    public function addItems(array $items)
    {
        foreach ($items as $name => $config) {

            $itemObj = $this->makeMenuItem($name, $config);

            // Check that the menu item matches the active context
            if ($itemObj->context !== null) {
                $context = (is_array($itemObj->context)) ? $itemObj->context : [$itemObj->context];
                if (!in_array($this->getContext(), $context)) {
                    continue;
                }
            }

            $this->allItems[$name] = $itemObj;
        }
    }

    /**
     * Creates a menu item object from name and configuration.
     *
     * @param $name
     * @param $config
     *
     * @return \Admin\Classes\MenuItem
     */
    protected function makeMenuItem($name, $config)
    {
        $label = $config['label'] ?? null;
        $itemType = $config['type'] ?? null;

        $item = new MenuItem($name, $label);
        $item->displayAs($itemType, $config);

        // Get menu item options from model
        $optionModelTypes = ['dropdown', 'partial'];
        if (in_array($item->type, $optionModelTypes, FALSE)) {

            // Defer the execution of option data collection
            $item->options(function () use ($item, $config) {
                $itemOptions = $config['options'] ?? null;
                $itemOptions = $this->getOptionsFromModel($item, $itemOptions);

                return $itemOptions;
            });
        }

        return $item;
    }

    /**
     * Get all the registered items for the instance.
     * @return array
     */
    public function getItems()
    {
        return $this->allItems;
    }

    /**
     * Get a specified item object
     *
     * @param  string $item
     *
     * @return mixed
     * @throws \Exception
     */
    public function getItem($item)
    {
        if (!isset($this->allItems[$item])) {
            throw new SystemException('No definition for item '.$item);
        }

        return $this->allItems[$item];
    }

    public function getLoggedUser()
    {
        if (!$this->getController()->checkUser())
            return FALSE;

        return $this->getController()->getUser();
    }

    //
    // Event handlers
    //

    /**
     * Update a menu item value.
     * @return array
     * @throws \Exception
     */
    public function onGetDropdownOptions()
    {
        if (!strlen($itemName = input('item')))
            throw new SystemException('Invalid item specified');

        $this->defineMenuItems();

        if (!$item = $this->getItem($itemName))
            throw new SystemException("No main menu item found matching {$itemName}");

        $itemOptions = $item->options();

//        if (array_key_exists('total', $options))
//            $this->setBadgeCount($item, $options['total']);

        // Return a partial if item has a path defined
        if (strlen($item->partial)) {
            return [
                '#'.$item->getId($item->itemName.'-options') => $this->makePartial(
                    $item->partial, ['item' => $item, 'itemOptions' => $itemOptions]
                ),
            ];
        }

        return [
            'options' => $itemOptions,
        ];
    }

    /**
     * Returns the active context for displaying the menu.
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    protected function getOptionsFromModel($item, $itemOptions)
    {
        if (is_array($itemOptions) AND is_callable($itemOptions)) {
            $user = $this->getLoggedUser();
            $itemOptions = call_user_func($itemOptions, $this, $item, $user);
        }

        return $itemOptions;
    }
}
