<div
    class="components-item"
    data-control="component"
    data-component-alias="{{ $component->alias }}"
>
    <div class="btn btn-light text-left p-3 w-100 mb-1 component{{ $component->fatalError ? ' border-danger' : '' }}">
        <div
            class="components-item-info"
            data-component-control="load"
            data-component-context="edit"
        >
            <span class="d-block mb-1">@lang($component->name)</span>
            <p class="text-muted text-sm mb-0"><code>{{ $component->alias }}</code></p>
            @if($component->fatalError)
                <p class="text-danger text-sm mb-0">{{ $component->fatalError }}</p>
            @endif
        </div>
        <div class="components-item-action mt-2">
            <a
                data-component-control="drag"
                class="handle btn btn-light btn-sm mr-1"
                role="button"
            ><i class="fa fa-arrows-up-down"></i></a>
            @unless($this->isConfigurableComponent($component))
            <a
                role="button"
                class="partial btn btn-light btn-sm mr-1"
                data-component-control="load"
                data-component-context="partial"
                title="@lang('igniter::main.components.button_copy_partial')"
            ><i class="fa fa-file-alt"></i></a>
            @endunless
            <a
                data-component-control="remove"
                class="remove btn btn-light btn-sm"
                role="button"
                data-prompt="@lang('igniter::admin.alert_confirm')"
                title="@lang('igniter::main.components.button_delete')"
            ><i class="fa fa-trash text-danger"></i></a>
        </div>
    </div>
    <input
        type="hidden"
        name="{{ $this->formField->getName() }}[]"
        value="{{ $component->alias }}"
    >
</div>
