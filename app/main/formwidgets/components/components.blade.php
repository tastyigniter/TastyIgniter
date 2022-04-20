<div
    data-control="components"
    data-alias="{{ $this->alias }}"
    data-remove-handler="{{ $this->getEventHandler('onRemoveComponent') }}"
    data-sortable-container=".components-container"
>
    <div class="components d-flex">
        <div class="components-item components-picker">
            <div
                class="component btn btn-light p-4 h-100"
                data-component-control="load"
                data-component-context="create"
            >
                <b><i class="fa fa-plus"></i></b>
                <p class="text-muted mb-0">@lang($this->prompt)</p>
            </div>
        </div>

        <div
            id="{{ $this->getId('container') }}"
            class="components-container"
        >
            {!! $this->makePartial('container', ['components' => $components]) !!}
        </div>
    </div>
</div>
