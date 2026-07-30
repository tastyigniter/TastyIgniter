<div id="cart-coupon" class="py-3 border-top border-bottom">
    <x-igniter-orange::forms.form id="coupon-form" wire:submit="onApplyCoupon">
        <div class="cart-coupon">
            <div class="input-group">
                <input
                    wire:model="couponCode"
                    type="text"
                    class="form-control rounded"
                    placeholder="@lang('igniter.cart::default.text_apply_coupon')"
                />

                <button
                    type="submit"
                    class="btn btn btn-secondary rounded ms-2"
                    data-replace-loading="fa fa-spinner fa-spin"
                ><i class="fa fa-check"></i></button>
            </div>
        </div>
    </x-igniter-orange::forms.form>
</div>
