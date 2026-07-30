<div
    class="offcanvas offcanvas-end w-100 w-md-50"
    id="reviewsOffCanvas"
    tabindex="-1"
    aria-labelledby="reviewsOffCanvasLabel"
    aria-hidden="true"
>
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="reviewsOffCanvasLabel">
            {{ sprintf(lang('igniter.local::default.review.text_review_heading'), $locationInfo->name) }}
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @forelse($listReviews() as $review)
            @include('igniter-orange::includes.local.review-card')

            @if($loop->last)
                <a
                    href="{{ restaurant_url($reviewsPage) }}"
                    class="btn btn-link w-100"
                >@lang('igniter.orange::default.button_more_reviews')</a>
            @endif
        @empty
            <p>@lang('igniter.local::default.review.text_no_review')</p>
        @endforelse
    </div>
</div>
