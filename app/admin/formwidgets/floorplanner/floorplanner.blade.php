<div
    data-control="floorplanner"
    data-alias="{{ $this->alias }}"
    data-dining-tables='@json($diningTables)'
    data-connector-widget-alias="{{ $connectorWidgetAlias }}"
>
    <div class="floorplanner border border-2 rounded position-relative">
        <div class="toolbar text-right p-2">
            <button
                type="button"
                class="btn btn-light"
                data-floor-planner-control="zoom-out"
            ><i class="fas fa-magnifying-glass-minus"></i></button>
            <button
                type="button"
                class="btn btn-light"
                data-floor-planner-control="zoom-in"
            ><i class="fas fa-magnifying-glass-plus"></i></button>
        </div>
        <div
            class="floorplanner-canvas border-top overflow-auto d-flex flex-wrap"
            data-floor-planner-canvas
        ></div>
    </div>
    @isset($field)
        <input
            type="hidden"
            name="{{ $field->getName() }}"
            value='@json($field->value)'
            data-floor-planner-input
        />
    @endisset
</div>
