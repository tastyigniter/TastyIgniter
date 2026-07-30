<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Models\CartSettings;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\System\Facades\Assets;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * @property-read string $cartTotal
 */
final class CartBox extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    /** Checkout Page */
    public string $checkoutPage = 'checkout.checkout';

    public int|float $tipAmount = 0;

    public bool $isCustomTip = false;

    public ?string $couponCode = null;

    /**
     * @var CartManager
     */
    protected $cartManager;

    protected $listeners = ['hideModal' => '$refresh'];

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::cart-box',
            'name' => 'igniter.orange::default.component_cartbox_title',
            'description' => 'igniter.orange::default.component_cartbox_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'checkoutPage' => [
                'label' => 'Page to redirect to when the checkout button is clicked.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'default' => 'checkout.checkout',
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.cart-box', [
            'previewMode' => false,
            'location' => Location::getFacadeRoot(),
            'cart' => $this->cartManager->getCart(),
        ]);
    }

    public function mount(): void
    {
        Assets::addJs('igniter-orange::/js/cart-item-options.js', 'cart-item-options-js');
        Assets::addJs('igniter-orange::/js/cart-item.js', 'cart-item-js');

        $this->prepareProps();
    }

    public function boot(): void
    {
        $this->cartManager = resolve(CartManager::class);
    }

    public function updated($property, mixed $value): void
    {
        if ($property === 'tipAmount') {
            $this->onApplyTip((float) $value, true);
        }
    }

    public function onOpenItemModal(string $rowId, int $menuId): void
    {
        $this->dispatch('showModal', component: 'igniter-orange::cart-item-modal', arguments: ['menuId' => $menuId, 'rowId' => $rowId]);
    }

    #[On('cart-box:add-item')]
    public function onUpdateItem(int $menuId, ?string $rowId = null, ?int $quantity = null): void
    {
        $this->cartManager->addOrUpdateCartItem([
            'menuId' => $menuId,
            'rowId' => $rowId,
            'quantity' => $quantity,
        ]);
    }

    public function onUpdateItemQuantity(string $rowId, string $action = 'plus'): void
    {
        $this->cartManager->updateCartItemQty($rowId, $action);
    }

    public function onApplyCoupon(): void
    {
        $this->cartManager->applyCouponCondition($this->couponCode);
    }

    public function onApplyTip(int|float $amount, bool $isCustom = false): void
    {
        $this->cartManager->applyCondition('tip', [
            'isCustom' => $isCustom,
            'amount' => $amount,
        ]);

        $this->prepareProps();
    }

    public function onRemoveCondition(string $conditionName): void
    {
        throw_unless(strlen($conditionName), new ApplicationException(
            lang('igniter.cart::default.alert_condition_not_found'),
        ));

        $this->cartManager->removeCondition($conditionName);
    }

    public function onProceedToCheckout(int $locationId)
    {
        if (!$locationId || !($location = Location::getById($locationId)) || !$location->location_status) {
            throw new ApplicationException(lang('igniter.local::default.alert_location_required'));
        }

        Location::setCurrent($location);

        throw_if($this->locationIsClosed(), new ApplicationException(lang('igniter.cart::default.alert_location_closed')));

        throw_if($this->hasMinimumOrder(), new ApplicationException(
            sprintf(lang('igniter.local::default.alert_order_is_unavailable'), Location::orderType()),
        ));

        return Redirect::to(page_url($this->checkoutPage));
    }

    #[Computed]
    public function cartTotal(): string
    {
        return currency_format($this->cartManager->getCart()->total());
    }

    public function locationIsClosed(): bool
    {
        return !Location::checkOrderTime() || Location::checkNoOrderTypeAvailable();
    }

    public function hasMinimumOrder(): bool
    {
        return $this->cartManager->cartTotalIsBelowMinimumOrder()
            || $this->cartManager->deliveryChargeIsUnavailable();
    }

    public function buttonLabel($checkoutComponent = null): string
    {
        if ($this->locationIsClosed()) {
            return lang('igniter.cart::default.text_is_closed');
        }

        if ($this->cartManager->getCart()->count()) {
            return lang('igniter.cart::default.button_order').' · '.$this->cartTotal;
        }

        return lang('igniter.cart::default.button_order');
    }

    public function getLocationId()
    {
        return Location::getId();
    }

    public function tippingEnabled(): bool
    {
        return CartSettings::tippingEnabled();
    }

    public function tippingAmounts()
    {
        return CartSettings::tippingAmounts();
    }

    protected function prepareProps(): void
    {
        $this->couponCode = $this->cartManager->getCart()->getCondition('coupon')?->getMetaData('code');

        $this->tipAmount = $this->cartManager->getCart()->getCondition('tip')?->getMetaData('amount', 0) ?? 0;
        $this->isCustomTip = (bool)$this->cartManager->getCart()->getCondition('tip')?->getMetaData('isCustom');
    }
}
