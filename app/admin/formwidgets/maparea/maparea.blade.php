<div
    id="{{ $this->getId() }}"
    data-control="map-area"
    data-alias="{{ $this->alias }}"
    data-remove-handler="{{ $this->getEventHandler('onDeleteArea') }}"
    data-sortable-container="#{{ $this->getId('areas') }}"
    data-sortable-handle=".{{ $this->getId('areas') }}-handle"
>
    <div class="map-area-container my-3" id="{{ $this->getId('items') }}">
        {!! $this->makePartial('maparea/areas') !!}
    </div>

    <div
        id="{{ $this->getId('toolbar') }}"
        class="map-area-toolbar"
    >
        {!! $this->makePartial('maparea/toolbar') !!}
    </div>
</div>
