<div
    data-control="floorplanner"
    data-alias="{{ $this->alias }}"
    data-draggable-selector=".draggable"
    data-wrapper-selector=".dining-table-wrapper"
>
    <div class="floorplanner position-relative">
        <div class="toolbar bg-transparent border-none text-right position-absolute end-0 pe-3">
            <button
                type="button"
                class="btn"
                data-floor-planner-control="zoom-out"
            ><i class="fas fa-magnifying-glass-minus fa-2x"></i></button>
            <button
                type="button"
                class="btn"
                data-floor-planner-control="zoom-in"
            ><i class="fas fa-magnifying-glass-plus fa-2x"></i></button>
            <button
                type="button"
                class="btn"
                data-floor-planner-control="zoom-reset"
            ><i class="fa-solid fa-rotate-left fa-2x"></i></button>
        </div>
        <div class="dining-table-wrapper border rounded overflow-auto pt-5 d-flex flex-wrap">
            @foreach($diningTables as $table)
                <div
                    class="dining-table d-inline-block m-4"
                    data-table-id="{{ $table->id }}"
                    data-table-name="{{ $table->name }}"
                    data-table-capacity="{{ $table->max_capacity }}"
                    data-table-shape="{{ $table->type ?? 'rectangle' }}"
                >
                    <input
                        data-table-layout-x
                        type="hidden"
                        name="{{ $fieldName }}[{{ $table->id }}][x]"
                        value="{{ array_get($table->seat_layout, 'x', 0) }}"
                    />
                    <input
                        data-table-layout-y
                        type="hidden"
                        name="{{ $fieldName }}[{{ $table->id }}][y]"
                        value="{{ array_get($table->seat_layout, 'y', 0) }}"
                    />
                    <input
                        data-table-layout-degree
                        type="hidden"
                        name="{{ $fieldName }}[{{ $table->id }}][degree]"
                        value="{{ array_get($table->seat_layout, 'degree', 0) }}"
                    />
                </div>
            @endforeach
        </div>
    </div>
    <script type="text/template" data-table-info-template>
        <div
            class="dining-table-overlay d-flex justify-content-center align-items-center"
            style="height:inherit;width:inherit;z-index:10;position:absolute;"
            data-floor-planner-control="select-table"
        >
            <button
                type="button"
                class="btn p-0 fw-bold shadow-none"
                data-control="load-table-form"
                data-connector-widget-alias="{{ $connectorWidgetAlias }}"
            >@{{ tableName }}</button>
        </div>
    </script>
</div>
