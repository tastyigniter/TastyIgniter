<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Cart\Classes\OrderManager;
use Igniter\Flame\Database\Model;
use Igniter\Local\Models\Review as ReviewModel;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Reservation\Classes\BookingManager;
use Igniter\System\Facades\Assets;
use Igniter\User\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Throwable;

final class LeaveReview extends Component
{
    use ConfigurableComponent;

    public string $type = 'order';

    /** The parameter name used for the review hash code */
    public string $hashParamName = 'hash';

    public ?string $reviewableHash = null;

    public ?string $comment = null;

    public int $delivery = 0;

    public int $quality = 0;

    public int $service = 0;

    protected ?Model $reviewable = null;

    protected ?Model $customerReview = null;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::leave-review',
            'name' => 'igniter.orange::default.component_leave_review_title',
            'description' => 'igniter.orange::default.component_leave_review_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'type' => [
                'label' => 'Leave a review for the order or reservation.',
                'type' => 'select',
                'default' => 'order',
                'options' => [
                    'order' => 'Order',
                    'reservation' => 'Reservation',
                ],
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.leave-review', [
            'allowReviews' => ReviewSettings::allowReviews(),
            'reviewable' => $this->reviewable(),
            'hasCustomerReview' => (bool)$this->loadReview(),
            'reviewRatingHints' => ReviewSettings::getHints(),
        ]);
    }

    public function mount(): void
    {
        Assets::addCss('igniter.local::/css/starrating.css', 'starrating-css');
        Assets::addJs('igniter.local::/js/starrating.js', 'starrating-js');

        $this->reviewableHash = request()->route($this->hashParamName);

        $customerReview = $this->loadReview();
        $this->quality = $customerReview->quality ?? 0;
        $this->delivery = $customerReview->delivery ?? 0;
        $this->service = $customerReview->service ?? 0;
        $this->comment = $customerReview->review_text ?? '';
    }

    public function onLeaveReview(): void
    {
        $this->validate([
            'comment' => ['required', 'min:2', 'max:1028'],
            'delivery' => ['required', 'integer', 'min:0'],
            'quality' => ['required', 'integer', 'min:0'],
            'service' => ['required', 'integer', 'min:0'],
        ], [], [
            'comment' => lang('igniter.local::default.review.label_review'),
            'delivery' => lang('igniter.local::default.review.label_delivery'),
            'quality' => lang('igniter.local::default.review.label_quality'),
            'service' => lang('igniter.local::default.review.label_service'),
        ]);

        throw_unless(Auth::customer(), ValidationException::withMessages([
            'comment' => lang('igniter.local::default.review.alert_expired_login'),
        ]));

        throw_unless(ReviewSettings::allowReviews(), ValidationException::withMessages([
            'comment' => lang('igniter.local::default.review.alert_review_disabled'),
        ]));

        throw_unless($reviewable = $this->getReviewable(), ValidationException::withMessages([
            'comment' => lang('igniter.local::default.review.alert_review_not_found'),
        ]));

        rescue(function() use ($reviewable): void {
            ReviewModel::leaveReview($reviewable, [
                'quality' => $this->quality,
                'delivery' => $this->delivery,
                'service' => $this->service,
                'review_text' => $this->comment,
            ]);

            flash()->success(lang('igniter.local::default.review.alert_review_success'))->now();
        }, function(Throwable $e): never {
            throw ValidationException::withMessages([
                'comment' => $e->getMessage(),
            ]);
        });
    }

    protected function reviewable()
    {
        return $this->reviewable ??= $this->getReviewable();
    }

    protected function loadReview()
    {
        return $this->customerReview ??= ($this->reviewable() ? ReviewModel::query()->whereReviewable($this->reviewable())->first() : null);
    }

    protected function getReviewable()
    {
        if (!$this->reviewableHash) {
            return null;
        }

        return match ($this->type) {
            'reservation' => resolve(BookingManager::class)->getReservationByHash($this->reviewableHash, Auth::customer()),
            'order' => resolve(OrderManager::class)->getOrderByHash($this->reviewableHash, Auth::customer()),
            default => null,
        };
    }
}
