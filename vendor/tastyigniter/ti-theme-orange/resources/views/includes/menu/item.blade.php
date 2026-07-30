<div
    id="menu{{ $menuItemData->id }}"
    @class([
        'bg-white h-100 p-3 border rounded shadow-sm',
        'shadow-hover cursor-pointer' => $menuItemData->mealtimeIsAvailable(),
        'cursor-no-drop' => !$menuItemData->mealtimeIsAvailable(),
    ])
    @if($menuItemData->mealtimeIsAvailable())
        @if($menuItemData->hasOptions())
            data-toggle="orange-modal"
            data-component="igniter-orange::cart-item-modal"
            data-arguments='{"menuId": {{ $menuItemData->id }}}'
        @else
            wire:click="$dispatch('cart-box:add-item', {menuId: {{ $menuItemData->id }}, quantity: {{ $menuItemData->minimumQuantity }}})"
            data-control="menu-item"
        @endif
    @endif
>
    @unless($showThumb)
    <button
        type="button"
        class="btn btn-outline-secondary rounded py-1 px-2 float-end"
    >
        <i @class([
            'fa fa-plus' => $menuItemData->mealtimeIsAvailable(),
            'far fa-clock' => !$menuItemData->mealtimeIsAvailable()
        ])
           wire:loading.class="fa-spinner fa-spin"
        ></i>
    </button>
    @endunless
    <div class="d-flex flex-row">
        <div class="menu-content flex-grow-1 me-3">
            <h6 class="menu-name fw-bold">{{ $menuItemData->name }}</h6>
            <p class="menu-desc text-muted mb-2">
                {!! $menuItemData->description !!}
            </p>
        </div>
        @if($showThumb)
            <div
                class="col-3 p-0 me-3 menu-item-image align-self-center rounded"
                style="
                    background: url('{{ $menuItemData->getThumb() }}') no-repeat center center;
                    background-size: cover;
                    width: {{$menuThumbWidth}}px;
                    height: {{$menuThumbHeight}}px;
                    ">
            </div>
        @endif
    </div>
    <div style="--bs-breadcrumb-divider: '·';">
        <div class="breadcrumb">
            <div class="breadcrumb-item">
                <span class="menu-price">
                    @if ($menuItemData->specialIsActive())
                        <s class="text-muted">{!! currency_format($menuItemData->priceBeforeSpecial) !!}</s>
                    @endif
                    {!! $menuItemData->price() > 0 ? currency_format($menuItemData->price()) : lang('igniter::main.text_free') !!}
                </span>
            </div>
            @if ($menuItemData->specialIsActive() && $menuItemData->specialDaysRemaining())
                <div class="breadcrumb-item menu-meta">
                    <span
                        class="text-warning"
                    >{!! sprintf(lang('igniter.local::default.text_end_elapsed'), $menuItemData->specialDaysRemaining()) !!}</span>
                </div>
            @endif
            @if (!$menuItemData->mealtimeIsAvailable())
                <div class="breadcrumb-item">
                    <i class="far fa-clock text-danger"></i>
                    <small class="text-danger">@lang('igniter.cart::default.mealtimes.text_available') {{ $menuItemData->mealtimeTitles() }}</small>
                </div>
            @endif
        </div>
    </div>
    <div class="layout-scrollable w-100">
        @includeWhen($menuItemData->hasIngredients(), 'igniter-orange::includes.menu.ingredients', [
            'ingredients' => $menuItemData->ingredients()
        ])
    </div>
</div>
