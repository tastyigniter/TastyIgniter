<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Local\Models\Review as ReviewModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Concerns\WithReviews;
use Illuminate\View\View;
use Livewire\Component;

final class ReviewList extends Component
{
    use ConfigurableComponent;
    use WithReviews;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::review-list',
            'name' => 'igniter.orange::default.component_review_list_title',
            'description' => 'igniter.orange::default.component_review_list_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'itemPerPage' => [
                'label' => 'Number of reviews to display per page.',
                'type' => 'number',
                'validationRule' => 'integer|min:1',
            ],
            'sortOrder' => [
                'label' => 'Default sort order of reviews.',
                'type' => 'select',
                'validationRule' => 'required|string',
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.review-list', [
            'reviewRatingHints' => (new ReviewModel)->getRatingOptions(),
            'reviewList' => $this->loadReviewList(),
        ]);
    }

    public static function getPropertyOptions(Form $form, FormField $field): array
    {
        return match ($field->getConfig('property')) {
            'sortOrder' => self::getSortOrderOptionsWithReviews(),
            default => [],
        };
    }
}
