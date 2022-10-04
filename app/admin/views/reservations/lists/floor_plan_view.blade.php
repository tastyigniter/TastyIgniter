<div
    class="p-5"
    style="background-color: var(--bs-gray-400)"
>
    {!! $this->makePartial('~/app/admin/formwidgets/floorplanner/floorplanner', [
        'diningTables' => $this->controller->getDiningTables($records),
        'connectorWidgetAlias' => '',
    ]) !!}
</div>
