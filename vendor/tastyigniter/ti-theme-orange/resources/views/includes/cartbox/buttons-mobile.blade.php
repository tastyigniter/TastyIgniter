<div class="fixed-bottom d-block d-lg-none">
    <a
        class="btn btn-primary w-100 btn-lg radius-none cart-toggle text-nowrap"
        href="{{ page_url('cart') }}"
    >
        @lang('igniter.orange::default.button_view_cart'):
        <span class="fw-bold">{{ $this->cartTotal }}</span>
    </a>
</div>
