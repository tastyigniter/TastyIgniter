<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Exception;
use Igniter\Cart\CartItem;
use Igniter\Cart\Classes\CartManager;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Contracts\ModalComponent;
use Igniter\Orange\Data\MenuItemData;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;

final class CartItemModal extends ModalComponent
{
    use ConfigurableComponent;

    public ?int $menuId = null;

    public ?string $rowId = null;

    public ?int $quantity = null;

    public ?string $comment = null;

    public ?array $menuOptions = [];

    public float $price = 0;

    public float $total = 0;

    public ?int $minQuantity = null;

    /** Show cart menu item image in the popup */
    public bool $showThumb = true;

    /** Cart item image width */
    public int $thumbWidth = 720;

    /** Cart item image height */
    public int $thumbHeight = 300;

    /** Whether to hide zero prices on options */
    public bool $hideZeroOptionPrices = false;

    /** Limit number of item option values */
    public ?int $limitOptionsValues = 6;

    /**
     * @var CartManager
     */
    protected $cartManager;

    protected ?CartItem $cartItem = null;

    protected ?MenuItemData $menuItemData = null;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::cart-item-modal',
            'name' => 'igniter.orange::default.component_cart_item_modal_title',
            'description' => 'igniter.orange::default.component_cart_item_modal_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'showThumb' => [
                'label' => 'Display menu item image in the popup',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'thumbWidth' => [
                'label' => 'Menu item image width',
                'type' => 'number',
                'validationRule' => 'nullable|required_if:showThumb,1|integer',
            ],
            'thumbHeight' => [
                'label' => 'Menu item image height',
                'type' => 'number',
                'validationRule' => 'nullable|required_if:showThumb,1|integer',
            ],
            'hideZeroOptionPrices' => [
                'label' => 'Hide zero prices on options.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'limitOptionsValues' => [
                'label' => 'Limit number of item option values',
                'type' => 'number',
                'validationRule' => 'nullable|integer',
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.cart-item-modal', [
            'cartItem' => $this->getCartItem(),
            'menuItemData' => $this->getMenuItemData(),
        ]);
    }

    public function mount(int $menuId, ?string $rowId = null): void
    {
        $this->menuId = $menuId;
        $this->rowId = $rowId;

        $this->getCartItem();
        $this->getMenuItemData();

        $this->minQuantity = $this->menuItemData->minimumQuantity;
        $this->price = $this->cartItem->price ?? $this->menuItemData->price();
        $this->quantity = $this->cartItem->qty ?? $this->menuItemData->minimumQuantity;
        $this->comment = $this->cartItem?->comment;
    }

    public function boot(): void
    {
        $this->cartManager = resolve(CartManager::class);
    }

    public function onSave(): void
    {
        try {
            $cartItem = $this->cartManager->addOrUpdateCartItem([
                'menuId' => $this->menuId,
                'rowId' => $this->rowId,
                'quantity' => $this->quantity,
                'comment' => $this->comment,
                'menu_options' => $this->menuOptions,
            ]);

            $this->rowId = $cartItem->rowId;

            $this->dispatch('hideModal');
        } catch (Exception $exception) {
            throw ValidationException::withMessages(['menuOptions' => $exception->getMessage()]);
        }
    }

    public function getLocationId()
    {
        return Location::getId();
    }

    public function getOptionQuantityTypeValue($menuOptionValueId)
    {
        $value = 0;
        if ($this->getCartItem()?->hasOptionValue($menuOptionValueId)) {
            $this->getCartItem()->options->search(function($option) use ($menuOptionValueId, &$value): void {
                $option->values->each(function($opt) use ($menuOptionValueId, &$value): void {
                    if ($opt->id == $menuOptionValueId) {
                        $value = $opt->qty;
                    }
                });
            });
        }

        return $value;
    }

    protected function getCartItem(): ?CartItem
    {
        if (!is_null($this->cartItem)) {
            return $this->cartItem;
        }

        return $this->cartItem = $this->rowId ? $this->cartManager->getCartItem($this->rowId) : null;
    }

    protected function getMenuItemData(): MenuItemData
    {
        if (!is_null($this->menuItemData)) {
            return $this->menuItemData;
        }

        return $this->menuItemData = new MenuItemData($this->cartManager->findMenuItem($this->menuId));
    }
}
