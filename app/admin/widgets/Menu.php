<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Admin\Classes\MenuItem;
use Admin\Classes\UserState;
use Admin\Facades\AdminLocation;
use Admin\Models\Locations_model;
use Carbon\Carbon;
use Igniter\Flame\Exception\ApplicationException;

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
     * @var bool Determines if item definitions have been created.
     */
    protected $itemsDefined = false;

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

        if (!isset($this->items) || !is_array($this->items)) {
            $this->items = [];
        }

        $this->addItems($this->items);

        $this->itemsDefined = true;
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

        // Defer the execution of badge unread count
        $item->unreadCount(function () use ($item, $config) {
            $itemBadgeCount = $config['badgeCount'] ?? null;

            return $this->getUnreadCountFromModel($item, $itemBadgeCount);
        });

        // Get menu item options from model
        $optionModelTypes = ['dropdown', 'partial'];
        if (in_array($item->type, $optionModelTypes, false)) {

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
     * @param string $item
     *
     * @return mixed
     * @throws \Exception
     */
    public function getItem($item)
    {
        if (!isset($this->allItems[$item])) {
            throw new ApplicationException(sprintf(lang('admin::lang.side_menu.alert_no_definition'), $item));
        }

        return $this->allItems[$item];
    }

    public function getLoggedUser()
    {
        if (!$this->getController()->checkUser())
            return false;

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
            throw new ApplicationException(lang('admin::lang.side_menu.alert_invalid_menu'));

        $this->defineMenuItems();

        if (!$item = $this->getItem($itemName))
            throw new ApplicationException(sprintf(lang('admin::lang.side_menu.alert_menu_not_found'), $itemName));

        $itemOptions = $item->options();

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
     * Mark menu items as read.
     * @return array
     * @throws \Exception
     */
    public function onMarkOptionsAsRead()
    {
        if (!strlen($itemName = post('item')))
            throw new ApplicationException(lang('admin::lang.side_menu.alert_invalid_menu'));

        $this->defineMenuItems();

        if (!$item = $this->getItem($itemName))
            throw new ApplicationException(sprintf(lang('admin::lang.side_menu.alert_menu_not_found'), $itemName));

        $this->resolveMarkAsReadFromModel($item);
    }

    public function onChooseLocation()
    {
        $location = null;
        if (is_numeric($locationId = post('location')))
            $location = Locations_model::find($locationId);

        if ($location && AdminLocation::hasAccess($location)) {
            AdminLocation::setCurrent($location);
        }
        else {
            AdminLocation::clearCurrent();
        }

        return $this->controller->redirectBack();
    }

    public function onSetUserStatus()
    {
        $status = (int)post('status');
        $message = (string)post('message');
        $clearAfterMinutes = (int)post('clear_after');

        if ($status < 1 && !strlen($message))
            throw new ApplicationException(lang('admin::lang.side_menu.alert_invalid_status'));

        $stateData['status'] = $status;
        $stateData['isAway'] = $status !== 1;
        $stateData['updatedAt'] = Carbon::now();
        $stateData['awayMessage'] = e($message);
        $stateData['clearAfterMinutes'] = $clearAfterMinutes;

        UserState::forUser($this->controller->getUser())->updateState($stateData);
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
        if (is_array($itemOptions) && is_callable($itemOptions)) {
            $user = $this->getLoggedUser();
            $itemOptions = call_user_func($itemOptions, $this, $item, $user);
        }

        return $itemOptions;
    }

    protected function getUnreadCountFromModel($item, $itemBadgeCount)
    {
        if (is_array($itemBadgeCount) && is_callable($itemBadgeCount)) {
            $user = $this->getLoggedUser();
            $itemBadgeCount = $itemBadgeCount($this, $item, $user);
        }

        return $itemBadgeCount;
    }

    protected function resolveMarkAsReadFromModel($item)
    {
        $callback = array_get($item->config, 'markAsRead');
        if (is_array($callback) && is_callable($callback)) {
            $user = $this->getLoggedUser();
            $callback($this, $item, $user);
        }
    }
}
