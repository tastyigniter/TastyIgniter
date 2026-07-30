<div class="card bg-white border shadow-sm mb-3">
    <div class="card-body">
        <figure>
            <blockquote class="blockquote">
                <p class="review-text">{{ $review->review_text }}</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                <div>
                    {{ $review->author }}
                    @if($review->customer?->address)
                        @lang('igniter.local::default.text_from')
                        <cite title="@lang('igniter.local::default.text_source')">
                            {{ $review->customer?->address ? $review->customer->address->city : '' }}
                        </cite>
                    @endif
                    @lang('igniter.local::default.text_on')
                    {{ $review->created_at->isoFormat(lang('system::lang.moment.date_format_short')) }}
                </div>
                <div class="d-md-flex mt-2">
                    <div class="pe-md-4">
                        <span class="text-muted"><b>Quality:</b></span>
                        <x-igniter-orange::star-rating :score="$review->quality" name="quality"
                                                       class="text-warning"/>
                    </div>
                    <div class="px-md-4">
                        <span class="text-muted"><b>Delivery:</b></span>
                        <x-igniter-orange::star-rating :score="$review->delivery" name="delivery"
                                                       class="text-warning"/>
                    </div>
                    <div class="px-md-4">
                        <span class="text-muted"><b>Service:</b></span>
                        <x-igniter-orange::star-rating :score="$review->service" name="service"
                                                       class="text-warning"/>
                    </div>
                </div>
            </figcaption>
        </figure>
    </div>
</div>
