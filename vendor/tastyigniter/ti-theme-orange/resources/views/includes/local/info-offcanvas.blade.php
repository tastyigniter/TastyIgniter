<div
    class="offcanvas offcanvas-end w-sm-100 w-md-50"
    id="localInfoCanvas"
    tabindex="-1"
    aria-labelledby="localInfoCanvasLabel"
    aria-hidden="true"
>
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="localInfoCanvasLabel">@lang('igniter.orange::default.text_local_tab_info')</h3>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-4">
            @if (strlen($locationInfo->description ?? ''))
                {{html(nl2br($locationInfo->description))}}
            @endif
        </div>

        @foreach($locationInfo->orderTypes() as $code => $orderType)
            <div class="bg-white border rounded p-3 mb-3">
                @if ($orderType->isDisabled())
                    {!! $orderType->getDisabledDescription() !!}
                @elseif ($orderType->getSchedule()->isOpen())
                    {!! $orderType->getOpenDescription()!!}
                @elseif ($orderType->getSchedule()->isOpening())
                    {!! $orderType->getOpeningDescription(lang('system::lang.moment.day_time_format_short')) !!}
                @else
                    {!! $orderType->getClosedDescription() !!}
                @endif
            </div>
        @endforeach
        @if ($locationInfo->hasDelivery)
            <div class="bg-white border rounded p-3 mb-4">
                @lang('igniter.local::default.text_last_order_time')&nbsp;
                <b>{{ $locationInfo->lastOrderTime()->isoFormat(lang('system::lang.moment.day_time_format')) }}</b>
            </div>
        @endif
        @if ($locationInfo->payments())
            <h5><i class="fas fa-credit-card fa-fw text-muted"></i>&nbsp;@lang('igniter.local::default.text_payments')</h5>
            <div class="bg-white border rounded p-3 mb-4">
                {!! implode(', ', $locationInfo->payments()) !!}.
            </div>
        @endif

        @includeWhen($locationInfo->hasDelivery, 'igniter-orange::includes.local.delivery-areas')

        @includeUnless(empty($locationInfo->scheduleItems()), 'igniter-orange::includes.local.hours')

        @includeWhen($locationInfo->hasGallery(), 'igniter-orange::includes.local.gallery')
    </div>
</div>
