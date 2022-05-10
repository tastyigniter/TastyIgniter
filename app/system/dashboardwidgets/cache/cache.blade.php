<div id="{{ $this->getId() }}" class="dashboard-widget widget-cache">
    <h6 class="widget-title">@lang($this->property('title'))</h6>

    <span>@lang('admin::lang.dashboard.text_total_cache')<b>{{ $formattedTotalCacheSize }}</b></span>
    <div class="progress mb-3" style="height: 25px;">
        @foreach ($cacheSizes as $cacheInfo)
            <div
                class="progress-bar progress-bar-animated p-2"
                role="progressbar"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="{{ $cacheInfo->label }}"
                aria-valuenow="{{ $cacheInfo->size }}"
                aria-valuemin="0"
                aria-valuemax="{{ $totalCacheSize }}"
                style="{{ 'background-color: '.$cacheInfo->color.'; width: '.$cacheInfo->size.'%' }}"
            ><b>{{ $cacheInfo->formattedSize }}</b></div>
        @endforeach
    </div>
    <button
        type="button"
        data-request="{{ $this->getEventHandler('onClearCache') }}"
        data-request-success="$('#cache-sizes').replaceWith(data.partial)"
        class="btn btn-default"
    ><i class="fa fa-trash"></i>&nbsp;&nbsp;@lang('admin::lang.text_clear')</button>
</div>
