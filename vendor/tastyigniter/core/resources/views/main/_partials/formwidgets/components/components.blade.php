<div
    id="{{ $this->getId() }}"
    data-control="components"
    data-alias="{{ $this->alias }}"
    data-attach-handler="{{ $this->getEventHandler('onSaveRecord') }}"
    data-remove-handler="{{ $this->getEventHandler('onRemoveComponent') }}"
    data-sortable-container=".components-container"
>
    <div class="mb-3">
        <select
            data-control="selectlist"
            class="form-select"
            data-component-control="attach"
        >
            <option value="">@lang($this->prompt)</option>
            @foreach($components as $code => $name)
                <option value="{{ $code }}">{{ lang($name[0]).(!empty($name[1]) ? ' - '.$name[1] : '') }}</option>
            @endforeach
        </select>
    </div>
    <div class="components list-group list-group-flush d-flex">
        <div
            id="{{ $this->getId('container') }}"
            class="components-container"
        >
            {!! $this->makePartial('container', ['components' => $templateComponents]) !!}
        </div>
    </div>
</div>
