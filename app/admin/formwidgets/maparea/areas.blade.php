<div
    id="{{ $this->getId('areas') }}"
    class="map-areas"
    aria-multiselectable="true"
    data-control="areas"
>
    @foreach ($mapAreas as $index => $mapArea)
        {!! $this->makePartial('maparea/area', ['index' => $index, 'area' => $mapArea]) !!}
    @endforeach
</div>
