<h5>@lang('igniter.local::default.text_delivery_areas')</h5>
<div class="bg-white border rounded p-3 mb-4">
    <div class="list-group list-group-flush">
        @if (count($deliveryAreas = $locationInfo->deliveryAreas()))
            <div class="list-group-item">
                <div class="row">
                    <div class="col-sm-4"><b>@lang('admin::lang.label_name')</b></div>
                    <div class="col-sm-8"><b>@lang('igniter.local::default.column_area_charge')</b>
                    </div>
                </div>
            </div>
            @foreach ($deliveryAreas as $key => $area)
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-sm-4">{{ $area->name }}</div>
                        <div class="col-sm-8">
                            {!! implode('<br>', $area->getConditionLabels()) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="list-group-item">
                <p>@lang('igniter.local::default.text_no_delivery_areas')</p>
            </div>
        @endif
    </div>
</div>
