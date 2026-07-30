<div>
    <h1 class="h4">@lang('igniter.orange::default.text_customer_reviews')</h1>
    @forelse($reviewList as $review)
        @include('igniter-orange::includes.local.review-card')

        @if($loop->last)
            <div class="pagination-bar text-right">
                <div class="links">{!! $reviewList->links() !!}</div>
            </div>
        @endif
    @empty
        <p>@lang('igniter.local::default.review.text_no_review')</p>
    @endforelse
</div>