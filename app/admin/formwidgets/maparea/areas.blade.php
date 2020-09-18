<div
    id="{{ $this->getId('areas') }}"
    class="map-areas"
    aria-multiselectable="true"
    data-control="areas"
>
    @foreach ($mapAreas as $mapArea)
        {!! $this->makePartial('maparea/area', ['area' => $mapArea]) !!}
    @endforeach
</div>
