<div
    class="components-item"
    data-control="component"
    data-component-alias="{{ $component->alias }}"
>
    <div class="components-item-action">
        <a
            data-component-control="drag"
            class="handle btn btn-light btn-sm"
            role="button"
        ><i class="fa fa-arrows-alt"></i></a>
        <a
            data-component-control="remove"
            class="remove btn btn-light btn-sm pull-right"
            role="button"
            data-prompt="@lang('admin::lang.alert_confirm')"
            title="@lang('main::lang.components.button_delete')"
        ><i class="fa fa-trash text-danger"></i></a>
    </div>
    <div
        class="component btn btn-light text-left{{ $component->fatalError ? ' border-danger' : '' }}"
        data-component-control="load"
    >
        <b>@lang($component->name)</b>
        <p class="text-muted mb-0">{{ $component->description ? lang($component->description) : '' }}</p>
        @if ($component->fatalError)
            <p class="text-danger mb-0">{{ $component->fatalError }}</p>
        @endif
    </div>
    <input
        type="hidden"
        name="{{ $this->formField->getName() }}[]"
        value="{{ $component->alias }}"
    >
</div>
