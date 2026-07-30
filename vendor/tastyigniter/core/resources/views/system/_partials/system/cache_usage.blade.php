@if(!empty($cacheSizes))
    <div class="progress mb-0" style="height: 20px;">
        @foreach($cacheSizes as $cacheInfo)
            @php($width = $totalCacheSize > 0 ? round(($cacheInfo->size / $totalCacheSize) * 100, 2) : 0)
            <div
                class="progress-bar"
                role="progressbar"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="{{ $cacheInfo->label }} - {{ $cacheInfo->formattedSize }}"
                aria-valuenow="{{ $cacheInfo->size }}"
                aria-valuemin="0"
                aria-valuemax="{{ $totalCacheSize }}"
                style="{{ 'background-color: '.$cacheInfo->color.'; width: '.$width.'%' }}"
            ></div>
        @endforeach
    </div>
@endif
