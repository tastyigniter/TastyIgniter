@isset($diningArea)
    <div
        data-control="floorplanner"
        data-dining-tables='@json($diningArea->getDiningTablesWithReservation($records))'
        data-preview-mode="true"
    >
        <div class="floorplanner border-top border-bottom position-relative">
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
        <input
            type="hidden"
            value='@json($diningArea->floor_plan)'
            data-floor-planner-input
        />
    </div>
@else
    <div class="p-5 text-center">
        {{ lang('igniter.reservation::default.alert_no_selected_dining_area') }}
    </div>
@endisset
