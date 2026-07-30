<?php

declare(strict_types=1);

namespace Igniter\Admin\Widgets;

use Exception;
use Igniter\Admin\Classes\BaseMainMenuWidget;
use Igniter\Admin\Classes\BaseWidget;
use Igniter\Admin\Classes\MainMenuItem;
use Igniter\Flame\Exception\FlashException;
use Igniter\User\Models\User;
use Override;

class Menu extends BaseWidget
{
    /**
     * @var ?array Item definition configuration.
     */
    public ?array $items = null;

    /**
     * @var null|string|array The context of this menu, items that do not belong
     * to this context will not be shown.
     */
    public null|string|array $context = null;

    protected string $defaultAlias = 'top-menu';

    /**
     * @var bool Determines if item definitions have been created.
     */
    protected bool $itemsDefined = false;

    /**
     * @var array Collection of all items used in this menu.
     */
    protected array $allItems = [];

    protected array $widgets = [];

    /**
     * @var array List of CSS classes to apply to the menu container element
     */
    public array $cssClasses = [];

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'items',
            'context',
        ]);
    }

    #[Override]
    public function bindToController(): void
    {
        $this->defineMenuItems();
        parent::bindToController();
    }

    #[Override]
    public function render(): string
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

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('mainmenu.js', 'mainmenu-js');
        $this->addJs('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');
    }

    /**
     * Renders the HTML element for a item
     */
    public function renderItemElement(MainMenuItem $item): string
    {
        $params = ['item' => $item];

        return $this->makePartial('menu/item_'.$item->type, $params);
    }

    /**
     * Creates a flat array of menu items from the configuration.
     */
    protected function defineMenuItems()
    {
        if ($this->itemsDefined) {
            return;
        }

        $this->items ??= [];

        $this->addItems($this->items);

        $this->allItems = collect($this->allItems)->sortBy('priority')->all();

        // Bind all main menu widgets to controller
        foreach ($this->allItems as $item) {
            if ($item->type !== 'widget') {
                continue;
            }

            $widget = $this->makeMenuItemWidget($item);
            $widget->bindToController();
        }

        $this->itemsDefined = true;
    }

    /**
     * Programatically add items, used internally and for extensibility.
     */
    public function addItems(array $items): void
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

            $this->allItems[$itemObj->itemName] = $itemObj;
        }
    }

    /**
     * Creates a menu item object from name and configuration.
     */
    protected function makeMenuItem(string $name, array|MainMenuItem $config): MainMenuItem
    {
        if ($config instanceof MainMenuItem) {
            return $config;
        }

        $label = $config['label'] ?? null;
        $itemType = $config['type'] ?? null;

        $item = new MainMenuItem($name, $label);
        $item->displayAs($itemType, $config);

        // Get menu item options from model
        $optionModelTypes = ['dropdown', 'partial'];
        if (in_array($item->type, $optionModelTypes, false)) {
            // Defer the execution of option data collection
            $item->options(function() use ($item, $config) {
                $itemOptions = $config['options'] ?? null;

                return $this->getOptionsFromModel($item, $itemOptions);
            });
        }

        return $item;
    }

    /**
     * Get all the registered items for the instance.
     */
    public function getItems(): array
    {
        return $this->allItems;
    }

    /**
     * Get a specified item object
     */
    public function getItem($item): MainMenuItem
    {
        if (!isset($this->allItems[$item])) {
            throw new FlashException(sprintf(lang('igniter::admin.side_menu.alert_no_definition'), $item));
        }

        return $this->allItems[$item];
    }

    public function getLoggedUser(): ?User
    {
        if (!$this->getController()->checkUser()) {
            return null;
        }

        return $this->getController()->getUser();
    }

    public function makeMenuItemWidget(MainMenuItem $item): ?BaseMainMenuWidget
    {
        if ($item->type !== 'widget') {
            return null;
        }

        if (isset($this->widgets[$item->itemName])) {
            return $this->widgets[$item->itemName];
        }

        $widgetConfig = $this->makeConfig($item->config);
        $widgetConfig['alias'] = $this->alias.studly_case(name_to_id($item->itemName));

        throw_unless(class_exists($widgetClass = $widgetConfig['widget']), new Exception(sprintf(
            lang('igniter::admin.alert_widget_class_name'), $widgetClass,
        )));

        return $this->widgets[$item->itemName] = new $widgetClass($this->controller, $item, $widgetConfig);
    }

    //
    // Event handlers
    //

    /**
     * Update a menu item value.
     */
    public function onGetDropdownOptions(): array
    {
        if (empty($itemName = input('item', ''))) {
            throw new FlashException(lang('igniter::admin.side_menu.alert_invalid_menu'));
        }

        $item = $this->getItem($itemName);

        // Return a partial if item has a path defined
        return [
            '#'.$this->getId($item->itemName.'-options') => $this->makePartial($item->path, [
                'item' => $item,
                'itemOptions' => $item->options(),
            ]),
        ];
    }

    /**
     * Returns the active context for displaying the menu.
     */
    public function getContext(): string
    {
        return $this->context;
    }

    protected function getOptionsFromModel(MainMenuItem $item, callable $itemOptions): mixed
    {
        $user = $this->getLoggedUser();

        return $itemOptions($this, $item, $user);
    }
}
