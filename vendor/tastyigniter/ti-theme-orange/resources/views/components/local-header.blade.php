<div class="panel-local d-md-flex">
    @if ($showThumb)
        <img
            class="img-fluid rounded me-4"
            src="{{ $locationInfo->getThumb(['width' => $localThumbWidth, 'height' => $localThumbHeight]) }}"
            alt="{{ $locationInfo->name }}"
            style="width: {{ $localThumbWidth }}px; height: {{ $localThumbHeight }}px;"
        />
    @endif
    <div>
        <h1 class="h3 mb-2">{{ $locationInfo->name }}</h1>
        <div style="--bs-breadcrumb-divider: '·';">
            <div class="breadcrumb mb-2">
                <div class="breadcrumb-item fw-bold">
                    @if ($currentSchedule($locationInfo)->isOpen())
                        @lang('igniter.local::default.text_is_opened')
                    @elseif ($currentSchedule($locationInfo)->isOpening())
                        {!! sprintf(lang('igniter.local::default.text_opening_time'), make_carbon($currentSchedule($locationInfo)->getOpenTime())->isoFormat(lang('igniter::system.moment.day_time_format_short'))) !!}
                    @else
                        @lang('igniter.local::default.text_closed')
                    @endif
                </div>
                @if (!$currentSchedule($locationInfo)->isOpen() && $currentSchedule($locationInfo)->isOpening())
                    <div class="breadcrumb-item">
                        {!! $locationInfo->orderType()->getOpeningDescription(lang('igniter::system.moment.day_time_format_short')) !!}
                    </div>
                @endif
                <div class="breadcrumb-item">
                    <a
                        class="link-dark fw-bold cursor-pointer"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#localInfoCanvas"
                        aria-controls="localInfoCanvas"
                    >@lang('igniter.local::default.text_more_info')</a>
                </div>
            </div>
        </div>
        <div class="text-muted">
            {{format_address($locationInfo->address, false)}}
        </div>
        @if ($allowReviews)
            <div class="rating rating-sm mt-2">
                <x-igniter-orange::star-rating :score="$locationInfo->reviewsScore()">
                    <a
                        data-bs-toggle="offcanvas"
                        data-bs-target="#reviewsOffCanvas"
                        aria-controls="reviewsOffCanvas"
                        class="link-primary cursor-pointer"
                    ><span class="small">({{ $locationInfo->reviewsCount() }}) @lang('igniter.orange::default.text_reviews')</span></a>
                </x-igniter-orange::star-rating>
            </div>
        @endif
    </div>
    @include('igniter-orange::includes.local.info-offcanvas')
    @include('igniter-orange::includes.local.reviews-offcanvas')
</div>
