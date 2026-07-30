<?php

declare(strict_types=1);

namespace Igniter\Cart\Classes;

use Exception;
use Igniter\Cart\Cart;
use Igniter\Cart\CartCondition;
use Igniter\Cart\CartItem;
use Igniter\Cart\Exceptions\InvalidRowIDException;
use Igniter\Cart\Models\CartSettings;
use Igniter\Cart\Models\Mealtime;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Coupons\Models\Coupon;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Classes\Location;
use Igniter\System\Actions\SettingsModel;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;

class CartManager
{
    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var Location
     */
    protected $location;

    /**
     * @var CartSettings|SettingsModel
     */
    protected $settings;

    protected $menuItemCache = [];

    public function __construct()
    {
        $this->cart = App::make('cart');
        $this->location = App::make('location');
        $this->settings = CartSettings::instance();

        $this->loadCartConditions();
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): static
    {
        $this->cart = $cart;

        return $this;
    }

    public function cartInstance(int $locationId): Cart
    {
        return $this->cart->instance('location-'.$locationId);
    }

    public function getCartItem(string $rowId): CartItem
    {
        try {
            return $this->cart->get($rowId);
        } catch (InvalidRowIDException) {
            throw new ApplicationException(lang('igniter.cart::default.alert_no_menu_item_found'));
        }
    }

    public function findMenuItem($menuId)
    {
        if (!is_numeric($menuId)) {
            throw new ApplicationException(lang('igniter.cart::default.alert_no_menu_selected'));
        }

        if (array_key_exists($menuId, $this->menuItemCache)) {
            return $this->menuItemCache[$menuId];
        }

        return $this->menuItemCache[$menuId] = Menu::findBy($menuId, $this->location->current());
    }

    public function addCartItem($menuId, array $properties = [])
    {
        return $this->addOrUpdateCartItem(array_merge($properties, [
            'menuId' => $menuId,
        ]));
    }

    public function updateCartItem($rowId, array $properties = [])
    {
        return $this->addOrUpdateCartItem(array_merge($properties, [
            'rowId' => $rowId,
        ]));
    }

    public function addOrUpdateCartItem(array $postData)
    {
        $rowId = array_get($postData, 'rowId') ?: '';
        $menuId = array_get($postData, 'menuId');
        $quantity = array_get($postData, 'quantity', 1);
        $comment = array_get($postData, 'comment');
        $menuOptions = array_get($postData, 'menu_options', []);

        if ($quantity <= 0) {
            $this->removeCartItem($rowId);

            return null;
        }

        $this->validateLocation();

        $this->validateOrderTime();

        $menuItem = $menuId ? $this->findMenuItem($menuId) : null;
        $cartItem = $rowId ? $this->getCartItem($rowId) : null;
        if ($cartItem instanceof CartItem) {
            $menuItem = $cartItem->model;
        }

        throw_unless($menuItem, new ApplicationException(lang('igniter.cart::default.alert_menu_not_found')));

        $this->validateCartMenuItem($menuItem, $quantity);

        $options = $this->prepareCartMenuItemOptions($menuItem->menu_options, $menuOptions);

        if (is_null($cartItem)) {
            return $this->cart->add($menuItem, $quantity, $options, $comment);
        }

        return $this->cart->update($cartItem->rowId, [
            'name' => $menuItem->getBuyableName(),
            'price' => $menuItem->getBuyablePrice(),
            'qty' => $quantity,
            'options' => $options,
            'comment' => $comment,
        ]);
    }

    public function removeCartItem(string $rowId): void
    {
        $this->getCartItem($rowId);

        $this->cart->remove($rowId);
    }

    public function updateCartItemQty(string $rowId, $quantityOrAction = 0): CartItem
    {
        $cartItem = $this->getCartItem($rowId);
        $menuItem = $this->findMenuItem($cartItem->id);

        if ($quantityOrAction === 'plus') {
            $quantity = $cartItem->qty + $menuItem->minimum_qty;
        } elseif ($quantityOrAction === 'minus') {
            $quantity = max($cartItem->qty - $menuItem->minimum_qty, 0);
        } else {
            $quantity = $quantityOrAction > 1 ? $quantityOrAction : $cartItem->qty - $menuItem->minimum_qty;
        }

        return $this->cart->update($rowId, $quantity);
    }

    public function removeCondition($name): ?bool
    {
        return $this->cart->removeCondition($name);
    }

    public function applyCondition($name, array $metaData = [])
    {
        if (!$condition = $this->cart->getCondition($name)) {
            return false;
        }

        $condition->setMetaData($metaData);

        $this->cart->loadCondition($condition);

        return $condition;
    }

    public function applyCouponCondition($code)
    {
        /** @var null|array|CartCondition $condition */
        $condition = Event::dispatch('igniter.cart.beforeApplyCoupon', [$code], true);
        if (!is_array($condition) && $condition instanceof CartCondition) {
            return $condition;
        }

        if (strlen((string)$code) !== 0 && !Coupon::whereIsEnabled()->whereCodeAndLocation($code, $this->location->getId())->first()) {
            throw new ApplicationException(lang('igniter.cart::default.alert_coupon_invalid'));
        }

        return $this->applyCondition('coupon', ['code' => $code]);
    }

    protected function loadCartConditions()
    {
        $conditionManager = resolve(CartConditionManager::class);

        $conditions = $this->settings->get('conditions') ?: [];
        foreach ($conditions as $definition) {
            if (!(bool)array_get($definition, 'status', true)) {
                continue;
            }

            $definition['cartInstance'] = $this->cart->currentInstance();

            $className = array_get($definition, 'className', '');
            $condition = $conditionManager->makeCondition($className, $definition);

            $this->cart->loadCondition($condition);
        }
    }

    //
    //
    //

    public function validateCartMenuItem(Menu $menuItem, $quantity): void
    {
        $this->validateMenuItem($menuItem);

        $this->validateMenuItemMinQty($menuItem, $quantity);

        $this->validateMenuItemStockQty($menuItem, $quantity);

        $this->validateMenuItemLocation($menuItem);
    }

    protected function prepareCartMenuItemOptions(Collection $menuOptions, array $selected)
    {
        $selected = collect($selected);
        $menuOptions = $menuOptions->keyBy('menu_option_id')->sortBy('priority');

        return $menuOptions->map(function(MenuItemOption $menuOption) use ($selected): array|false {
            $selectedOption = $selected->get($menuOption->getKey());
            $selectedValues = array_filter((array)array_get($selectedOption, 'option_values', []));

            if (!in_array($menuOption->option->display_type, ['quantity', 'checkbox'])) {
                $selectedValues = array_filter($selectedValues, is_numeric(...));
            }

            $this->validateMenuItemOption($menuOption, $selectedValues);

            $menuOptionValues = $this->prepareCartItemOptionValues(
                $menuOption, $selectedValues,
            );

            return $menuOptionValues->isNotEmpty() ? [
                'id' => $menuOption->menu_option_id,
                'name' => $menuOption->option_name,
                'type' => $menuOption->display_type,
                'values' => $menuOptionValues->all(),
            ] : false;
        })->filter()->all();
    }

    protected function prepareCartItemOptionValues(MenuItemOption $menuOption, array $selectedValues)
    {
        $menuOptionValues = $menuOption->menu_option_values->keyBy('menu_option_value_id')->sortBy('priority');

        $menuOptionValues->each(fn(MenuItemOptionValue $value) => $value->setRelation('menu_option', $menuOption));

        $freeQtyMap = $this->allocateFreeQuantities($menuOption, $menuOptionValues, $selectedValues);

        return $menuOptionValues
            ->map(function(MenuItemOptionValue $optionValue) use ($selectedValues, $freeQtyMap) {
                $selectedIds = array_column($selectedValues, 'id') ?: $selectedValues;
                if (!in_array($optionValue->getKey(), $selectedIds)
                    && (array_get($selectedIds, $optionValue->getKey()) !== true
                        && !is_array(array_get($selectedIds, $optionValue->getKey())))) {
                    return;
                }

                $qty = (int)array_get($selectedValues, $optionValue->getKey().'.qty', 1);
                if ($qty < 1) {
                    return;
                }

                $freeQty = $freeQtyMap[$optionValue->getKey()] ?? 0;

                return [
                    'id' => $optionValue->menu_option_value_id,
                    'qty' => $qty,
                    'name' => $optionValue->name,
                    'price' => $freeQty >= $qty ? 0 : $optionValue->price,
                    'free_qty' => $freeQty,
                ];
            })->filter();
    }

    /**
     * Allocate free units to selected option values, in the order they were
     * selected, bounded by each value's own free_quantity budget and the
     * option group's optional shared free_quantity cap.
     *
     * @return array<int, int> menu_option_value_id => free units granted
     */
    protected function allocateFreeQuantities(MenuItemOption $menuOption, Collection $menuOptionValues, array $selectedValues): array
    {
        $remainingGroupCap = $menuOption->free_quantity > 0 ? $menuOption->free_quantity : null;

        $freeQtyMap = [];
        foreach ($this->selectedValueIdsInOrder($selectedValues) as $valueId) {
            $optionValue = $menuOptionValues->get($valueId);
            if (!$optionValue || $optionValue->free_quantity < 1) {
                continue;
            }

            $qty = (int)array_get($selectedValues, $valueId.'.qty', 1);

            $grantable = min($qty, $optionValue->free_quantity, $remainingGroupCap ?? PHP_INT_MAX);
            if ($grantable < 1) {
                continue;
            }

            $freeQtyMap[$valueId] = $grantable;

            if (!is_null($remainingGroupCap)) {
                $remainingGroupCap -= $grantable;
            }
        }

        return $freeQtyMap;
    }

    /**
     * Extract the selected option value IDs in the order the customer picked
     * them, regardless of whether $selectedValues is a flat list of IDs, a
     * list of {id, qty} entries, or a dict keyed by ID (booleans or {qty}).
     *
     * @return array<int, int>
     */
    protected function selectedValueIdsInOrder(array $selectedValues): array
    {
        $ids = array_column($selectedValues, 'id');
        if ($ids !== []) {
            return array_map(intval(...), $ids);
        }

        $isKeyedById = collect($selectedValues)->contains(fn($value): bool => $value === true || is_array($value));

        return array_map(intval(...), $isKeyedById ? array_keys($selectedValues) : array_values($selectedValues));
    }

    //
    //
    //

    public function validateContents(): void
    {
        if (!$this->cart->count()) {
            throw new ApplicationException(lang('igniter.cart::default.checkout.alert_no_menu_to_order'));
        }

        $this->cart->content()->each(function(CartItem $cartItem): void {
            $menuItem = $this->findMenuItem($cartItem->id);

            $this->validateCartMenuItem($menuItem, $cartItem->qty);

            $menuOptions = $menuItem->menu_options->keyBy('menu_option_id');

            $cartItem->options->each(function($cartItemOption) use ($menuOptions): void {
                throw_unless($menuItemOption = $menuOptions->get($cartItemOption->id), new ApplicationException(
                    lang('igniter.cart::default.alert_option_not_found'),
                ));

                $this->validateMenuItemOption(
                    $menuItemOption,
                    $cartItemOption->values->toArray(),
                );
            });
        });
    }

    public function validateLocation(): void
    {
        if (!$this->location->current()) {
            throw new ApplicationException(lang('igniter.local::default.alert_location_required'));
        }

        if ($this->location->orderTypeIsDelivery()
            && $this->location->requiresUserPosition()
            && (!$this->location->userPosition()->isValid() || !$this->location->checkDeliveryCoverage())
        ) {
            throw new ApplicationException(lang('igniter.local::default.alert_no_search_query'));
        }
    }

    public function validateOrderTime(): void
    {
        if (!$this->location->current()) {
            throw new ApplicationException(lang('igniter.local::default.alert_location_required'));
        }

        if ($this->location->checkNoOrderTypeAvailable()) {
            throw new ApplicationException(lang('igniter.local::default.alert_order_type_required'));
        }

        $orderType = $this->location->getOrderType();
        if (!$orderType || $orderType->isDisabled()) {
            throw new ApplicationException(sprintf(lang('igniter.local::default.alert_order_is_unavailable'),
                optional($orderType)->getLabel() ?? $this->location->orderType(),
            ));
        }

        if (!$this->location->checkOrderTime()) {
            throw new ApplicationException(sprintf(lang('igniter.cart::default.checkout.alert_outside_hours'),
                optional($orderType)->getLabel() ?? $this->location->orderType(),
            ));
        }
    }

    public function validateMenuItem(Menu $menuItem): void
    {
        // if menu mealtime is enabled and menu is outside mealtime
        if (!$menuItem->isAvailable($this->location->orderDateTime())) {
            throw new ApplicationException(
                sprintf(
                    lang('igniter.cart::default.alert_menu_not_within_mealtimes'),
                    $menuItem->menu_name,
                    strtolower((string)$menuItem->mealtimes->filter(fn(Mealtime $mealtime): bool => $mealtime->isEnabled())
                        ->pluck('description')
                        ->join(', ')),
                ),
            );
        }

        $orderType = $this->location->getOrderType();
        if ($menuItem->hasOrderTypeRestriction($orderType->getCode())) {
            throw new ApplicationException(sprintf(
                lang('igniter.cart::default.alert_menu_order_type_restriction'),
                $menuItem->getBuyableName(),
                $orderType->getLabel(),
            ));
        }
    }

    public function validateMenuItemMinQty(Menu $menuItem, $quantity): void
    {
        if ($quantity == 0 || $menuItem->minimum_qty == 0) {
            return;
        }

        // if cart quantity is less than minimum quantity
        if (!$menuItem->checkMinQuantity($quantity)) {
            throw new ApplicationException(sprintf(
                lang('igniter.cart::default.alert_qty_is_below_min_qty'), $menuItem->minimum_qty,
            ));
        }

        // Quantity is valid if its divisive by the minimum quantity
        if (($quantity % $menuItem->minimum_qty) > 0) {
            throw new ApplicationException(sprintf(
                lang('igniter.cart::default.alert_qty_is_invalid'), $menuItem->minimum_qty,
            ));
        }
    }

    public function validateMenuItemStockQty(Menu $menuItem, $quantity): void
    {
        // checks if stock quantity is less than to zero
        if ($menuItem->outOfStock($this->location->getId())) {
            throw new ApplicationException(sprintf(
                lang('igniter.cart::default.alert_out_of_stock'), $menuItem->menu_name,
            ));
        }

        // checks if stock quantity is less than the cart quantity
        if (!$menuItem->checkStockLevel($quantity, $this->location->getId())) {
            throw new ApplicationException(sprintf(
                lang('igniter.cart::default.alert_low_on_stock'),
                $menuItem->menu_name,
                $menuItem->stocks->where('location_id', $this->location->getId())->value('quantity'),
            ));
        }
    }

    public function validateMenuItemOption(MenuItemOption $menuOption, $selectedValues): void
    {
        if ($menuOption->isRequired() && !$selectedValues) {
            throw new ApplicationException(sprintf(
                lang('igniter.cart::default.alert_option_required'), $menuOption->option_name,
            ));
        }

        if ($menuOption->display_type == 'quantity') {
            $countSelected = (int)array_reduce($selectedValues, fn($qty, array $selectedValue): int => $qty + $selectedValue['qty']);
        } else {
            $countSelected = count($selectedValues);
        }

        if (($menuOption->min_selected > 0 || $menuOption->max_selected > 0) &&
            ($countSelected < $menuOption->min_selected || $countSelected > $menuOption->max_selected)
        ) {
            throw new ApplicationException(sprintf(
                lang('igniter.cart::default.alert_option_selected'),
                $menuOption->option_name,
                $menuOption->min_selected,
                $menuOption->max_selected,
            ));
        }

        $availableOptionValueIds = $menuOption->menu_option_values->pluck('menu_option_value_id')->all();
        collect($selectedValues)->each(function($selectedValue) use ($availableOptionValueIds): void {
            $selectedId = array_get($selectedValue, 'id');
            if (is_numeric($selectedId) && !in_array($selectedId, $availableOptionValueIds)) {
                throw new ApplicationException(sprintf(
                    lang('igniter.cart::default.alert_option_value_not_found'),
                    array_get($selectedValue, 'name'),
                ));
            }
        });

        // Validate stock for each selected option value
        collect($selectedValues)->each(function($selectedValue) use ($menuOption): void {
            if (!is_numeric($selectedId = array_get($selectedValue, 'id'))) {
                return;
            }

            $menuItemOptionValue = $menuOption->menu_option_values->firstWhere('menu_option_value_id', $selectedId);
            if ($menuItemOptionValue && $menuItemOptionValue->option_value->outOfStock($this->location->getId())) {
                throw new ApplicationException(sprintf(
                    lang('igniter.cart::default.alert_out_of_stock'),
                    $menuItemOptionValue->name,
                ));
            }
        });
    }

    public function validateMenuItemLocation(Menu $menuItem): void
    {
        if ($menuItem->locations->isNotEmpty() &&
            !$menuItem->locations->keyBy('location_id')->has($this->location->getId())
        ) {
            throw new ApplicationException(sprintf(
                lang('igniter.cart::default.alert_menu_location_restricted'), $menuItem->menu_name,
            ));
        }
    }

    //
    //
    //

    public function cartTotalIsBelowMinimumOrder(): bool
    {
        return !$this->location->checkMinimumOrderTotal($this->cart->subtotal());
    }

    public function deliveryChargeIsUnavailable(): bool
    {
        return $this->location->orderTypeIsDelivery()
            && $this->location->deliveryAmount($this->cart->subtotal()) < 0;
    }

    //
    // Reorder
    //

    public function restoreWithOrderMenus(Collection $orderMenuItems)
    {
        $notes = [];

        foreach ($orderMenuItems as $orderMenu) {
            try {
                throw_unless($orderMenu->menu, new ApplicationException(
                    lang('igniter.cart::default.alert_menu_not_found'),
                ));

                $this->validateCartMenuItem($orderMenu->menu, $orderMenu->quantity);

                if (is_string($orderMenu->option_values)) {
                    $orderMenu->option_values = @unserialize($orderMenu->option_values);
                }

                if ($orderMenu->option_values instanceof Arrayable) {
                    $orderMenu->option_values = $orderMenu->option_values->toArray();
                }

                $options = $this->prepareCartItemOptionsFromOrderMenu($orderMenu->menu, $orderMenu->option_values, $notes);

                $this->cart->add($orderMenu->menu, $orderMenu->quantity, $options, $orderMenu->comment);
            } catch (Exception $ex) {
                $notes[] = $ex->getMessage();
            }
        }

        return $notes;
    }

    protected function prepareCartItemOptionsFromOrderMenu($menuModel, $optionValues, &$notes)
    {
        $options = [];
        foreach ($optionValues as $cartOption) {
            $cartOption = (array)$cartOption;
            if (!$menuOption = $menuModel->menu_options->keyBy('menu_option_id')->get($cartOption['id'])) {
                continue;
            }

            try {
                $this->validateMenuItemOption($menuOption, $cartOption['values']->toArray());

                $cartOption['values'] = $cartOption['values']->filter(fn($cartOptionValue) => $menuOption->menu_option_values->keyBy('menu_option_value_id')->has($cartOptionValue->id))->toArray();

                $options[] = $cartOption;
            } catch (Exception $ex) {
                $notes[] = $ex->getMessage();
            }
        }

        return $options;
    }
}
