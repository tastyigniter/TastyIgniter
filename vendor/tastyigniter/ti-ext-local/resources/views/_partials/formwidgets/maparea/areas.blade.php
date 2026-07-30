@if($mapAreas)
    <div
        id="{{ $this->getId('areas') }}"
        class="map-areas"
        aria-multiselectable="true"
        data-control="areas"
    >
        @foreach($mapAreas as $index => $mapArea)
            {!! $this->makePartial('maparea/area', ['index' => $index, 'area' => $mapArea]) !!}
        @endforeach
    </div>
@else
    <div class="card shadow-sm border-warning text-warning">
        <div class="card-body">
            <b>@lang('igniter.local::default.alert_delivery_area')</b>
        </div>
    </div>
@endif
