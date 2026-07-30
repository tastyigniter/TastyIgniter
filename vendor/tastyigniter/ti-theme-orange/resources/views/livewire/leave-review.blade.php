<div>
    @if ($allowReviews && $reviewable && $reviewable->isCompleted())
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h4 class="text-center fw-normal">
                    @if ($hasCustomerReview)
                        @lang('igniter.local::default.review.text_your_review')
                    @else
                        @lang('igniter.local::default.review.text_write_review')
                    @endif
                </h4>
                <form
                    role="form"
                    @unless($hasCustomerReview)wire:submit="onLeaveReview" @endunless
                    accept-charset="utf-8"
                >
                    <div class="d-flex text-center">
                        <div class="form-group flex-fill">
                            <label
                                class="form-label d-block"
                                for="quality"
                            >@lang('igniter.local::default.review.label_quality')</label>
                            <x-igniter-orange::star-rating
                                :score="$quality ?? 0"
                                :readOnly="$hasCustomerReview"
                                :name="'quality'"
                                class="h4 text-warning"
                            />
                            <x-igniter-orange::forms.error field="quality" class="text-danger" />
                        </div>
                        <div class="form-group flex-fill">
                            <label
                                class="form-label d-block"
                                for="delivery"
                            >@lang('igniter.local::default.review.label_delivery')</label>
                            <x-igniter-orange::star-rating
                                :score="$delivery ?? 0"
                                :readOnly="$hasCustomerReview"
                                :name="'delivery'"
                                class="h4 text-warning"
                            />
                            <x-igniter-orange::forms.error field="delivery" class="text-danger" />
                        </div>
                        <div class="form-group flex-fill">
                            <label
                                class="form-label d-block"
                                for="service"
                            >@lang('igniter.local::default.review.label_service')</label>
                            <x-igniter-orange::star-rating
                                :score="$quality ?? 0"
                                :readOnly="$hasCustomerReview"
                                :name="'service'"
                                class="h4 text-warning"
                            />
                            <x-igniter-orange::forms.error field="service" class="text-danger" />
                        </div>
                    </div>
                    @unless($hasCustomerReview)
                        <div class="form-group">
                            <div @class(['form-floating', 'is-invalid' => has_form_error('comment')])>
                                <textarea
                                    wire:model="comment"
                                    id="comment"
                                    rows="5"
                                    class="form-control"
                                ></textarea>
                                <label
                                    for="review-text"
                                >@lang('igniter.local::default.review.label_review')</label>
                            </div>
                            <x-igniter-orange::forms.error field="comment" id="commentFeedback" class="text-danger" />
                        </div>

                        <div class="buttons">
                            <button
                                type="submit"
                                class="btn btn-secondary w-100"
                                data-attach-loading=""
                            >@lang('igniter.local::default.review.button_review')</button>
                        </div>
                    @else
                        <div class="form-group text-center">
                            <p class="lead">{{ $comment }}</p>
                        </div>
                    @endunless
                </form>
            </div>
        </div>
        @script
        <script>
            $(document).render(function () {
                $('[data-control="star-rating"] i').on('click', function () {
                    $wire.set($(this).closest('[data-score-name]').data('score-name'), $(this).data('alt'), false);
                });
            });
        </script>
        @endscript
    @endif
</div>
