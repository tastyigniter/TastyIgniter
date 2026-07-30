<?php

declare(strict_types=1);

namespace Igniter\Coupons\CartConditions;

use Exception;
use Igniter\Cart\CartCondition;
use Igniter\Cart\CartItem;
use Igniter\Cart\Concerns\ActsAsItemable;
use Igniter\Cart\Facades\Cart;
use Igniter\Cart\Models\Menu;
use Igniter\Coupons\Models\Coupon as CouponModel;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Facades\Location;
use Igniter\User\Facades\Auth;
use Override;

class Coupon extends CartCondition
{
    use ActsAsItemable;

    public bool $removeable = true;

    public ?int $priority = 200;

    protected static ?CouponModel $couponModel = null;

    protected static $applicableItems;

    protected static $hasErrors = false;

    #[Override]
    public function getLabel(): string
    {
        return sprintf(lang($this->label), $this->getMetaData('code'));
    }

    #[Override]
    public function getValue(): int|float
    {
        return 0 - $this->calculatedValue;
    }

    public function getModel(): ?CouponModel
    {
        if ((string)($couponCode = $this->getMetaData('code', '')) === '') {
            return null;
        }

        if (is_null(self::$couponModel) || strtolower(self::$couponModel->code) !== strtolower((string)$couponCode)) {
            self::$couponModel = CouponModel::getByCode($couponCode);
        }

        return self::$couponModel;
    }

    public function getApplicableItems($couponModel)
    {
        $applicableItems = $couponModel->menus->pluck('menu_id');
        $couponModel->categories->pluck('category_id')
            ->each(function($category) use (&$applicableItems): void {
                $applicableItems = $applicableItems
                    ->merge(Menu::whereHasCategory($category)->pluck('menu_id'));
            });

        self::$applicableItems = $applicableItems;

        return self::$applicableItems;
    }

    #[Override]
    public function onLoad(): void
    {
        if (!strlen((string)$this->getMetaData('code', '')) || self::$hasErrors) {
            return;
        }

        try {
            if (!($couponModel = $this->getModel()) instanceof CouponModel) {
                throw new ApplicationException(lang('igniter.cart::default.alert_coupon_invalid'));
            }

            $user = Auth::user();
            $locationId = Location::getId();
            $orderType = Location::orderType();
            $orderDateTime = Location::orderDateTime();

            $couponModel->validateCoupon($orderType, $orderDateTime, Cart::content(), $user, $locationId);

            $this->getApplicableItems($couponModel);
        } catch (Exception $exception) {
            flash()->alert($exception->getMessage())->now();

            $this->removeMetaData('code');
        }
    }

    #[Override]
    public function beforeApply()
    {
        $couponModel = $this->getModel();
        if (!$couponModel || $couponModel->appliesOnMenuItems() || self::$hasErrors) {
            return false;
        }

        return !$couponModel->appliesOnDelivery() || Location::orderTypeIsDelivery();
    }

    #[Override]
    public function getActions(): array
    {
        $value = optional($this->getModel())->discountWithOperand();

        if (optional($this->getModel())->appliesOnDelivery()) {
            $value = $this->calculateDeliveryDiscount();
        }// if we are item limited and not a % we need to apportion
        elseif (!str_contains((string)$value, '%') && optional($this->getModel())->appliesOnMenuItems()) {
            $value = $this->calculateApportionment($value);
        }

        $actions = [
            'value' => $value,
        ];

        return [$actions];
    }

    #[Override]
    public function whenInvalid(): void
    {
        if (!$this->getModel()->auto_apply) {
            $minimumOrder = $this->getModel()->minimumOrderTotal();

            flash()->warning(sprintf(
                lang('igniter.cart::default.alert_coupon_not_applied'),
                currency_format($minimumOrder),
            ))->now();
        }

        $this->removeMetaData('code');
    }

    protected function calculateApportionment($value)
    {
        $applicableItems = self::$applicableItems;
        if ($applicableItems && count($applicableItems)) {
            $applicableItemsTotal = Cart::content()->sum(function(CartItem $cartItem) use ($applicableItems): float|int {
                if (!$applicableItems->contains($cartItem->id) || !self::$couponModel->canRedeemOnMenuItemQuantity($cartItem->qty)) {
                    return 0;
                }

                return $cartItem->subtotalWithoutConditions();
            });

            $value = ($this->target->subtotalWithoutConditions() / $applicableItemsTotal) * (float)$value;
        }

        return $value;
    }

    protected function calculateDeliveryDiscount(): string
    {
        $cartSubtotal = Cart::subtotal();
        $deliveryCharge = Location::coveredArea()->deliveryAmount($cartSubtotal);
        $couponModel = optional($this->getModel());
        if ($couponModel->isFixed()) {
            $value = $couponModel->discount > $deliveryCharge ? $deliveryCharge : $couponModel->discount;
        } else {
            $value = $deliveryCharge * ($couponModel->discount * 0.01);
        }

        return '-'.$value;
    }

    public static function isApplicableTo($cartItem)
    {
        if (!($couponModel = self::$couponModel) || self::$hasErrors) {
            return false;
        }

        if (!$couponModel->appliesOnMenuItems()) {
            return false;
        }

        if (!$applicableItems = self::$applicableItems) {
            return false;
        }

        return $applicableItems->contains($cartItem->id) && self::$couponModel->canRedeemOnMenuItemQuantity($cartItem->qty);
    }

    public static function clearInternalCache(): void
    {
        self::$couponModel = null;
        self::$applicableItems = null;
        self::$hasErrors = false;
    }
}
